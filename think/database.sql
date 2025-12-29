-- 数据库表结构
-- 数据库名: tp_system

-- 管理员用户表
CREATE TABLE IF NOT EXISTS `bew_admin_user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `account` varchar(50) NOT NULL COMMENT '账号',
  `password` varchar(32) NOT NULL COMMENT '密码(MD5)',
  `name` varchar(50) NOT NULL COMMENT '姓名',
  `role` tinyint(1) DEFAULT '1' COMMENT '角色：1普通编辑，2超级管理员',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态：1启用，0禁用',
  `times_login` int(11) DEFAULT '0' COMMENT '登录次数',
  `time_last` datetime DEFAULT NULL COMMENT '最后登录时间',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `account` (`account`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='管理员用户表';

-- 插入默认管理员账号（账号：admin，密码：abc123456）
INSERT INTO `bew_admin_user` (`account`, `password`, `name`, `role`, `status`, `create_time`) VALUES
('admin', '0659c7992e268962384eb17fafe88364', '超级管理员', 2, 1, NOW());

-- 轮播图表
CREATE TABLE IF NOT EXISTS `bew_banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `title` varchar(100) DEFAULT NULL COMMENT '标题',
  `image` varchar(255) NOT NULL COMMENT '图片路径',
  `link` varchar(255) DEFAULT NULL COMMENT '链接地址',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态：1启用，0禁用',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='轮播图表';

-- 公司信息表
CREATE TABLE IF NOT EXISTS `bew_company_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `type` varchar(50) NOT NULL COMMENT '类型：intro公司简介，about关于我们，contact联系方式',
  `title` varchar(200) DEFAULT NULL COMMENT '标题',
  `content` text COMMENT '内容',
  `image` varchar(255) DEFAULT NULL COMMENT '图片',
  `map_lat` decimal(10,6) DEFAULT NULL COMMENT '地图纬度',
  `map_lng` decimal(10,6) DEFAULT NULL COMMENT '地图经度',
  `address` varchar(255) DEFAULT NULL COMMENT '地址',
  `phone` varchar(50) DEFAULT NULL COMMENT '电话',
  `email` varchar(100) DEFAULT NULL COMMENT '邮箱',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='公司信息表';

-- 产品分类表
CREATE TABLE IF NOT EXISTS `bew_product_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(100) NOT NULL COMMENT '分类名称',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态：1启用，0禁用',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='产品分类表';

-- 产品表
CREATE TABLE IF NOT EXISTS `bew_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `category_id` int(11) NOT NULL COMMENT '分类ID',
  `title` varchar(200) NOT NULL COMMENT '产品标题',
  `image` varchar(255) DEFAULT NULL COMMENT '产品图片',
  `description` text COMMENT '产品描述',
  `content` text COMMENT '产品详情',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态：1启用，0禁用',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='产品表';

-- 解决方案表
CREATE TABLE IF NOT EXISTS `bew_solution` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `title` varchar(200) NOT NULL COMMENT '方案标题',
  `image` varchar(255) DEFAULT NULL COMMENT '方案图片',
  `description` text COMMENT '方案描述',
  `content` text COMMENT '方案详情',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态：1启用，0禁用',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='解决方案表';

-- 新闻分类表
CREATE TABLE IF NOT EXISTS `bew_news_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(100) NOT NULL COMMENT '分类名称',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态：1启用，0禁用',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='新闻分类表';

-- 新闻表
CREATE TABLE IF NOT EXISTS `bew_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `category_id` int(11) NOT NULL COMMENT '分类ID',
  `title` varchar(200) NOT NULL COMMENT '新闻标题',
  `image` varchar(255) DEFAULT NULL COMMENT '新闻图片',
  `summary` varchar(500) DEFAULT NULL COMMENT '摘要',
  `content` text COMMENT '新闻内容',
  `views` int(11) DEFAULT '0' COMMENT '浏览次数',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态：1发布，0草稿',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='新闻表';

-- 留言表
CREATE TABLE IF NOT EXISTS `bew_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(50) NOT NULL COMMENT '姓名',
  `phone` varchar(20) DEFAULT NULL COMMENT '电话',
  `email` varchar(100) DEFAULT NULL COMMENT '邮箱',
  `subject` varchar(200) DEFAULT NULL COMMENT '主题',
  `content` text NOT NULL COMMENT '留言内容',
  `status` tinyint(1) DEFAULT '0' COMMENT '状态：0未读，1已读',
  `reply` text DEFAULT NULL COMMENT '回复内容',
  `reply_time` datetime DEFAULT NULL COMMENT '回复时间',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='留言表';

-- 合作伙伴表
CREATE TABLE IF NOT EXISTS `bew_partner` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(100) NOT NULL COMMENT '合作伙伴名称',
  `logo` varchar(255) DEFAULT NULL COMMENT 'Logo图片',
  `link` varchar(255) DEFAULT NULL COMMENT '链接地址',
  `description` text COMMENT '描述',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态：1启用，0禁用',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='合作伙伴表';

-- 系统配置表
CREATE TABLE IF NOT EXISTS `bew_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `key` varchar(100) NOT NULL COMMENT '配置键',
  `value` text COMMENT '配置值',
  `description` varchar(255) DEFAULT NULL COMMENT '描述',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='系统配置表';

