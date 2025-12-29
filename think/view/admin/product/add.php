{extend name="layout" /}

{block name="title"}添加产品{/block}

{block name="content"}
<div class="layui-card">
    <div class="layui-card-header">添加产品</div>
    <div class="layui-card-body">
        <form class="layui-form" lay-filter="productForm">
            <div class="layui-form-item">
                <label class="layui-form-label">产品分类</label>
                <div class="layui-input-block">
                    <select name="category_id" lay-verify="required">
                        <option value="">请选择分类</option>
                        {volist name="categories" id="vo"}
                        <option value="{$vo.id}">{$vo.name}</option>
                        {/volist}
                    </select>
                </div>
            </div>
            
            <div class="layui-form-item">
                <label class="layui-form-label">产品标题</label>
                <div class="layui-input-block">
                    <input type="text" name="title" required lay-verify="required" placeholder="请输入产品标题" class="layui-input">
                </div>
            </div>
            
            <div class="layui-form-item">
                <label class="layui-form-label">产品图片</label>
                <div class="layui-input-block">
                    <input type="text" name="image" id="image" placeholder="图片地址" class="layui-input">
                    <button type="button" class="layui-btn" id="uploadBtn" style="margin-top: 10px;">
                        <i class="layui-icon">&#xe67c;</i>上传图片
                    </button>
                    <div id="imagePreview" style="margin-top: 10px;"></div>
                </div>
            </div>
            
            <div class="layui-form-item">
                <label class="layui-form-label">产品描述</label>
                <div class="layui-input-block">
                    <textarea name="description" placeholder="简短描述" class="layui-textarea"></textarea>
                </div>
            </div>
            
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">产品详情</label>
                <div class="layui-input-block">
                    <textarea name="content" id="content" placeholder="产品详情" class="layui-textarea" style="min-height: 300px;"></textarea>
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
                    <a href="/admin/product/index" class="layui-btn layui-btn-primary">返回</a>
                </div>
            </div>
        </form>
    </div>
</div>
{/block}

{block name="js"}
<script src="https://cdn.jsdelivr.net/npm/wangeditor@4.7.15/dist/index.js"></script>
<script>
layui.use(['form', 'upload', 'layer', 'jquery'], function(){
    var form = layui.form;
    var upload = layui.upload;
    var layer = layui.layer;
    var $ = layui.$;
    
    // 初始化富文本编辑器
    const E = window.wangEditor;
    const editor = new E('#content');
    editor.config.uploadImgServer = '/admin/upload/image';
    editor.config.uploadFileName = 'file';
    editor.create();
    
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
        }
    });
    
    // 表单提交
    form.on('submit(submitBtn)', function(data){
        data.field.content = editor.txt.html();
        $.post('/admin/product/add', data.field, function(res){
            if(res.code == 0){
                layer.msg(res.msg, {icon: 1}, function(){
                    location.href = '/admin/product/index';
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

