{extend name="layout" /}

{block name="title"}公司简介{/block}

{block name="content"}
<div class="layui-card">
    <div class="layui-card-header">公司简介</div>
    <div class="layui-card-body">
        <form class="layui-form" lay-filter="companyForm">
            <div class="layui-form-item">
                <label class="layui-form-label">标题</label>
                <div class="layui-input-block">
                    <input type="text" name="title" value="{$info.title|default=''}" placeholder="请输入标题" class="layui-input">
                </div>
            </div>
            
            <div class="layui-form-item">
                <label class="layui-form-label">图片</label>
                <div class="layui-input-block">
                    <input type="text" name="image" id="image" value="{$info.image|default=''}" placeholder="图片地址" class="layui-input">
                    <button type="button" class="layui-btn" id="uploadBtn" style="margin-top: 10px;">
                        <i class="layui-icon">&#xe67c;</i>上传图片
                    </button>
                    <div id="imagePreview" style="margin-top: 10px;">
                        {if condition="$info.image"}
                        <img src="{$info.image}" style="max-width: 300px; max-height: 200px;" />
                        {/if}
                    </div>
                </div>
            </div>
            
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">内容</label>
                <div class="layui-input-block">
                    <textarea name="content" id="content" placeholder="请输入内容" class="layui-textarea" style="min-height: 300px;">{$info.content|default=''}</textarea>
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
<script src="https://cdn.jsdelivr.net/npm/wangeditor@4.7.15/dist/index.js"></script>
<script>
layui.use(['form', 'upload', 'layer', 'jquery'], function(){
    var form = layui.form;
    var upload = layui.upload;
    var layer = layui.layer;
    var $ = layui.$;
    
    var editor = null;
    
    // 等待 wangEditor 加载完成
    function initEditor() {
        if (typeof window.wangEditor === 'undefined') {
            setTimeout(initEditor, 100);
            return;
        }
        
        // 初始化富文本编辑器
        const E = window.wangEditor;
        editor = new E('#content');
        editor.config.uploadImgServer = '/admin/upload/image';
        editor.config.uploadFileName = 'file';
        editor.create();
        
        // 设置编辑器内容
        {if condition="$info.content"}
        editor.txt.html('{$info.content}');
        {/if}
    }
    
    // 初始化编辑器
    initEditor();
    
    // 图片上传（延迟初始化，确保富文本编辑器完全加载后再初始化上传）
    setTimeout(function(){
        upload.render({
            elem: '#uploadBtn',
            url: '/admin/upload/image',
            accept: 'images',
            field: 'file',
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
    }, 300);
    
    // 表单提交
    form.on('submit(submitBtn)', function(data){
        if(editor){
            data.field.content = editor.txt.html();
        }
        $.post('/admin/company/intro', data.field, function(res){
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

