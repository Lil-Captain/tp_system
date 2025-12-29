{extend name="layout" /}

{block name="title"}联系方式{/block}

{block name="content"}
<div class="layui-card">
    <div class="layui-card-header">联系方式</div>
    <div class="layui-card-body">
        <form class="layui-form" lay-filter="contactForm">
            <div class="layui-form-item">
                <label class="layui-form-label">标题</label>
                <div class="layui-input-block">
                    <input type="text" name="title" value="{$info.title|default=''}" placeholder="请输入标题" class="layui-input">
                </div>
            </div>
            
            <div class="layui-form-item">
                <label class="layui-form-label">地址</label>
                <div class="layui-input-block">
                    <input type="text" name="address" value="{$info.address|default=''}" placeholder="请输入地址" class="layui-input">
                </div>
            </div>
            
            <div class="layui-form-item">
                <label class="layui-form-label">电话</label>
                <div class="layui-input-block">
                    <input type="text" name="phone" value="{$info.phone|default=''}" placeholder="请输入电话" class="layui-input">
                </div>
            </div>
            
            <div class="layui-form-item">
                <label class="layui-form-label">邮箱</label>
                <div class="layui-input-block">
                    <input type="text" name="email" value="{$info.email|default=''}" placeholder="请输入邮箱" class="layui-input">
                </div>
            </div>
            
            <div class="layui-form-item">
                <label class="layui-form-label">地图坐标</label>
                <div class="layui-input-block">
                    <div class="layui-row layui-col-space10">
                        <div class="layui-col-md6">
                            <input type="text" name="map_lat" value="{$info.map_lat|default=''}" placeholder="纬度" class="layui-input">
                        </div>
                        <div class="layui-col-md6">
                            <input type="text" name="map_lng" value="{$info.map_lng|default=''}" placeholder="经度" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-mid layui-word-aux">可通过百度地图、高德地图等获取坐标</div>
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
        $.post('/admin/company/contact', data.field, function(res){
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

