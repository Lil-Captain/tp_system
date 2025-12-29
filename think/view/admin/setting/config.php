{extend name="layout" /}

{block name="title"}站点配置{/block}

{block name="content"}
<div class="layui-card">
    <div class="layui-card-header">站点配置</div>
    <div class="layui-card-body">
        <form class="layui-form" lay-filter="configForm">
            <div class="layui-form-item">
                <label class="layui-form-label">站点名称</label>
                <div class="layui-input-block">
                    <input type="text" name="config[site_name]" value="{$configs.site_name|default=''}" placeholder="请输入站点名称" class="layui-input">
                </div>
            </div>
            
            <div class="layui-form-item">
                <label class="layui-form-label">站点关键词</label>
                <div class="layui-input-block">
                    <input type="text" name="config[site_keywords]" value="{$configs.site_keywords|default=''}" placeholder="请输入站点关键词" class="layui-input">
                </div>
            </div>
            
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">站点描述</label>
                <div class="layui-input-block">
                    <textarea name="config[site_description]" placeholder="请输入站点描述" class="layui-textarea">{$configs.site_description|default=''}</textarea>
                </div>
            </div>
            
            <div class="layui-form-item">
                <label class="layui-form-label">ICP备案号</label>
                <div class="layui-input-block">
                    <input type="text" name="config[site_icp]" value="{$configs.site_icp|default=''}" placeholder="请输入ICP备案号" class="layui-input">
                </div>
            </div>
            
            <div class="layui-form-item">
                <label class="layui-form-label">版权信息</label>
                <div class="layui-input-block">
                    <input type="text" name="config[site_copyright]" value="{$configs.site_copyright|default=''}" placeholder="请输入版权信息" class="layui-input">
                </div>
            </div>
            
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit lay-filter="submitBtn">保存</button>
                </div>
            </div>
        </form>
    </div>
</div>
{/block}

{block name="js"}
<script>
layui.use(['form', 'layer', 'jquery'], function(){
    var form = layui.form;
    var layer = layui.layer;
    var $ = layui.$;
    
    // 表单提交
    form.on('submit(submitBtn)', function(data){
        $.post('/admin/setting/config', data.field, function(res){
            if(res.code == 0){
                layer.msg(res.msg, {icon: 1});
            } else {
                layer.msg(res.msg, {icon: 2});
            }
        }, 'json');
        return false;
    });
});
</script>
{/block}

