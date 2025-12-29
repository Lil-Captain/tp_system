#!/bin/bash
# ThinkPHP 命令行工具 Docker 包装脚本

# 获取脚本所在目录（项目根目录）
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"

# 处理参数：如果是 run 命令且没有指定端口，默认使用 8888
ARGS=("$@")
PORT="8888"
DOCKER_PORT_MAP=""

if [ "$1" = "run" ]; then
  # 检查是否已经指定了端口参数
  HAS_PORT=false
  PORT_INDEX=-1
  for i in "${!ARGS[@]}"; do
    arg="${ARGS[$i]}"
    if [[ "$arg" == "-p" ]] || [[ "$arg" == "--port" ]]; then
      HAS_PORT=true
      PORT_INDEX=$i
      # 检查下一个参数是否是端口号
      if [ $((i+1)) -lt ${#ARGS[@]} ]; then
        PORT="${ARGS[$((i+1))]}"
      fi
      break
    elif [[ "$arg" == -p=* ]]; then
      HAS_PORT=true
      PORT="${arg#-p=}"
      break
    elif [[ "$arg" == --port=* ]]; then
      HAS_PORT=true
      PORT="${arg#--port=}"
      break
    fi
  done
  
  # 如果没有指定端口，添加默认端口 8888
  if [ "$HAS_PORT" = false ]; then
    ARGS+=("-p" "8888")
  fi
  
  # 添加 Docker 端口映射，将容器端口映射到宿主机
  DOCKER_PORT_MAP="-p ${PORT}:${PORT}"
fi

# 使用 docker run 临时挂载目录执行 think 命令
sudo docker run --rm \
  -v "$SCRIPT_DIR":/app \
  -w /app \
  $DOCKER_PORT_MAP \
  php:8.1-fpm \
  php /app/think "${ARGS[@]}"

