{extend name="layout" /}

{block name="title"}添加轮播图{/block}

{block name="content"}
<div class="layui-card">
    <div class="layui-card-header">添加轮播图</div>
    <div class="layui-card-body">
        <form class="layui-form" lay-filter="bannerForm">
            <div class="layui-form-item">
                <label class="layui-form-label">标题</label>
                <div class="layui-input-block">
                    <input type="text" name="title" placeholder="请输入标题" class="layui-input">
                </div>
            </div>
            
            <div class="layui-form-item">
                <label class="layui-form-label">图片</label>
                <div class="layui-input-block">
                    <input type="text" name="image" id="image" placeholder="图片地址" class="layui-input" required>
                    <button type="button" class="layui-btn" id="uploadBtn" style="margin-top: 10px;">
                        <i class="layui-icon">&#xe67c;</i>上传图片
                    </button>
                    <div id="imagePreview" style="margin-top: 10px;"></div>
                </div>
            </div>
            
            <div class="layui-form-item">
                <label class="layui-form-label">链接地址</label>
                <div class="layui-input-block">
                    <input type="text" name="link" placeholder="点击跳转的链接（可选）" class="layui-input">
                </div>
            </div>
            
            <div class="layui-form-item">
                <label class="layui-form-label">排序</label>
                <div class="layui-input-block">
                    <input type="number" name="sort" value="0" class="layui-input">
                </div>
            </div>
            
            <div class="layui-form-item">
                <label class="layui-form-label">状态</label>
                <div class="layui-input-block">
                    <input type="radio" name="status" value="1" title="启用" checked>
                    <input type="radio" name="status" value="0" title="禁用">
                </div>
            </div>
            
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit lay-filter="submitBtn">提交</button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                    <a href="/admin/banner/index" class="layui-btn layui-btn-primary">返回</a>
                </div>
            </div>
        </form>
    </div>
</div>
{/block}

{block name="js"}
<script>
layui.use(['form', 'upload', 'layer', 'jquery'], function(){
    var form = layui.form;
    var upload = layui.upload;
    var layer = layui.layer;
    var $ = layui.$;
    
    // 图片上传
    upload.render({
        elem: '#uploadBtn',
        url: '/admin/upload/image',
        accept: 'images',
        done: function(res){
            if(res.code == 0){
                $('#image').val(res.data.url);
                $('#imagePreview').html('<img src="' + res.data.url + '" style="max-width: 300px; max-height: 200px;" />');
                layer.msg('上传成功', {icon: 1});
            } else {
                layer.msg(res.msg || '上传失败', {icon: 2});
            }
        },
        error: function(){
            layer.msg('上传失败', {icon: 2});
        }
    });
    
    // 表单提交
    form.on('submit(submitBtn)', function(data){
        $.post('/admin/banner/add', data.field, function(res){
            if(res.code == 0){
                layer.msg(res.msg, {icon: 1}, function(){
                    location.href = '/admin/banner/index';
                });
            } else {
                layer.msg(res.msg, {icon: 2});
            }
        }, 'json');
        return false;
    });
});
</script>
{/block}

