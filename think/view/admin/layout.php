<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{block name="title"}后台管理{/block} - 内容管理系统</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/layui@2.8.18/dist/css/layui.css">
    <style>
        body { background-color: #f2f2f2; }
        .layui-layout-admin .layui-header { background-color: #393D49; }
        .layui-layout-admin .layui-side { background-color: #2F4056; }
        .layui-nav-tree .layui-nav-item a { color: #c2c2c2; }
        .layui-nav-tree .layui-nav-itemed > a, .layui-nav-tree .layui-this > a { color: #fff; }
    </style>
    {block name="css"}{/block}
</head>
<body>
    <div class="layui-layout layui-layout-admin">
        <!-- 头部 -->
        <div class="layui-header">
            <div class="layui-logo layui-hide-xs" style="color: #fff; font-size: 18px;">内容管理系统</div>
            <ul class="layui-nav layui-layout-left">
                <li class="layui-nav-item layui-hide-xs"><a href="/admin/dashboard/index">控制台</a></li>
            </ul>
            <ul class="layui-nav layui-layout-right">
                <li class="layui-nav-item">
                    <a href="javascript:;">
                        <i class="layui-icon layui-icon-user"></i> {$admin_name|default='管理员'}
                    </a>
                    <dl class="layui-nav-child">
                        <dd><a href="/admin/setting/password">修改密码</a></dd>
                        <dd><a href="/login/logout">退出登录</a></dd>
                    </dl>
                </li>
            </ul>
        </div>
        
        <!-- 左侧导航 -->
        <div class="layui-side layui-bg-black">
            <div class="layui-side-scroll">
                <ul class="layui-nav layui-nav-tree" lay-filter="nav">
                    <li class="layui-nav-item">
                        <a href="/admin/dashboard/index"><i class="layui-icon layui-icon-console"></i> 控制台</a>
                    </li>
                    <li class="layui-nav-item">
                        <a href="javascript:;"><i class="layui-icon layui-icon-picture"></i> 轮播图管理</a>
                        <dl class="layui-nav-child">
                            <dd><a href="/admin/banner/index">轮播图列表</a></dd>
                            <dd><a href="/admin/banner/add">添加轮播图</a></dd>
                        </dl>
                    </li>
                    <li class="layui-nav-item">
                        <a href="javascript:;"><i class="layui-icon layui-icon-read"></i> 内容管理</a>
                        <dl class="layui-nav-child">
                            <dd><a href="/admin/company/intro">公司简介</a></dd>
                            <dd><a href="/admin/company/about">关于我们</a></dd>
                            <dd><a href="/admin/company/contact">联系方式</a></dd>
                        </dl>
                    </li>
                    <li class="layui-nav-item">
                        <a href="javascript:;"><i class="layui-icon layui-icon-goods"></i> 产品管理</a>
                        <dl class="layui-nav-child">
                            <dd><a href="/admin/product/category">产品分类</a></dd>
                            <dd><a href="/admin/product/index">产品列表</a></dd>
                        </dl>
                    </li>
                    <li class="layui-nav-item">
                        <a href="javascript:;"><i class="layui-icon layui-icon-solution"></i> 解决方案</a>
                        <dl class="layui-nav-child">
                            <dd><a href="/admin/solution/index">方案列表</a></dd>
                        </dl>
                    </li>
                    <li class="layui-nav-item">
                        <a href="javascript:;"><i class="layui-icon layui-icon-file"></i> 新闻管理</a>
                        <dl class="layui-nav-child">
                            <dd><a href="/admin/news/category">新闻分类</a></dd>
                            <dd><a href="/admin/news/index">新闻列表</a></dd>
                        </dl>
                    </li>
                    <li class="layui-nav-item">
                        <a href="/admin/message/index"><i class="layui-icon layui-icon-email"></i> 留言管理</a>
                    </li>
                    <li class="layui-nav-item">
                        <a href="/admin/partner/index"><i class="layui-icon layui-icon-friends"></i> 合作伙伴</a>
                    </li>
                    <li class="layui-nav-item">
                        <a href="javascript:;"><i class="layui-icon layui-icon-set"></i> 系统设置</a>
                        <dl class="layui-nav-child">
                            <dd><a href="/admin/setting/password">修改密码</a></dd>
                            <dd><a href="/admin/setting/config">站点配置</a></dd>
                        </dl>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- 内容区域 -->
        <div class="layui-body">
            <div style="padding: 15px;">
                {block name="content"}{/block}
            </div>
        </div>
        
        <!-- 底部 -->
        <div class="layui-footer" style="text-align: center;">
            <!-- © 2025 内容管理系统 -->
            <div data-ries-data-process="48" class="translation-text-wrapper" data-group-id="group-48"><img src="/ghs.png" alt="">鄂ICP备2025158873号  鄂公网安备42102302000093号</div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/layui@2.8.18/dist/layui.js"></script>
    <script>
        layui.use(['element', 'layer', 'jquery'], function(){
            var element = layui.element;
            var layer = layui.layer;
            var $ = layui.$;
            
            // 导航菜单高亮
            var path = window.location.pathname;
            $('.layui-nav-item a').each(function(){
                if($(this).attr('href') == path){
                    $(this).parent().addClass('layui-this');
                    $(this).parents('.layui-nav-item').addClass('layui-nav-itemed');
                }
            });
        });
    </script>
    {block name="js"}{/block}
</body>
</html>

