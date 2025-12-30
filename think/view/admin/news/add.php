{extend name="layout" /}

{block name="title"}添加新闻{/block}

{block name="content"}
<div class="layui-card">
    <div class="layui-card-header">添加新闻</div>
    <div class="layui-card-body">
        <form class="layui-form" lay-filter="newsForm">
            <div class="layui-form-item">
                <label class="layui-form-label">新闻分类</label>
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
                <label class="layui-form-label">新闻标题</label>
                <div class="layui-input-block">
                    <input type="text" name="title" required lay-verify="required" placeholder="请输入新闻标题" class="layui-input">
                </div>
            </div>
            
            <div class="layui-form-item">
                <label class="layui-form-label">新闻图片</label>
                <div class="layui-input-block">
                    <input type="text" name="image" id="image" placeholder="图片地址" class="layui-input">
                    <button type="button" class="layui-btn" id="uploadBtn" style="margin-top: 10px;">
                        <i class="layui-icon">&#xe67c;</i>上传图片
                    </button>
                    <div id="imagePreview" style="margin-top: 10px;"></div>
                </div>
            </div>
            
            <div class="layui-form-item">
                <label class="layui-form-label">摘要</label>
                <div class="layui-input-block">
                    <textarea name="summary" placeholder="新闻摘要" class="layui-textarea"></textarea>
                </div>
            </div>
            
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">新闻内容</label>
                <div class="layui-input-block">
                    <textarea name="content" id="content" placeholder="新闻内容" class="layui-textarea" style="min-height: 300px;"></textarea>
                </div>
            </div>
            
            <div class="layui-form-item">
                <label class="layui-form-label">状态</label>
                <div class="layui-input-block">
                    <input type="radio" name="status" value="1" title="发布" checked>
                    <input type="radio" name="status" value="0" title="草稿">
                </div>
            </div>
            
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit lay-filter="submitBtn">提交</button>
                    <a href="/admin/news/index" class="layui-btn layui-btn-primary">返回</a>
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
        $.post('/admin/news/add', data.field, function(res){
            if(res.code == 0){
                layer.msg(res.msg, {icon: 1}, function(){
                    location.href = '/admin/news/index';
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

