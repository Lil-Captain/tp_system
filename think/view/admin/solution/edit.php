{extend name="layout" /}

{block name="title"}编辑解决方案{/block}

{block name="content"}
<div class="layui-card">
    <div class="layui-card-header">编辑解决方案</div>
    <div class="layui-card-body">
        <form class="layui-form" lay-filter="solutionForm">
            <input type="hidden" name="id" value="{$info.id}">
            
            <div class="layui-form-item">
                <label class="layui-form-label">方案标题</label>
                <div class="layui-input-block">
                    <input type="text" name="title" value="{$info.title|default=''}" required lay-verify="required" placeholder="请输入方案标题" class="layui-input">
                </div>
            </div>
            
            <div class="layui-form-item">
                <label class="layui-form-label">方案图片</label>
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
            
            <div class="layui-form-item">
                <label class="layui-form-label">方案描述</label>
                <div class="layui-input-block">
                    <textarea name="description" placeholder="简短描述" class="layui-textarea">{$info.description|default=''}</textarea>
                </div>
            </div>
            
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">方案详情</label>
                <div class="layui-input-block">
                    <textarea name="content" id="content" placeholder="方案详情" class="layui-textarea" style="min-height: 300px;">{$info.content|default=''}</textarea>
                </div>
            </div>
            
            <div class="layui-form-item">
                <label class="layui-form-label">排序</label>
                <div class="layui-input-block">
                    <input type="number" name="sort" value="{$info.sort|default=0}" class="layui-input">
                </div>
            </div>
            
            <div class="layui-form-item">
                <label class="layui-form-label">状态</label>
                <div class="layui-input-block">
                    <input type="radio" name="status" value="1" title="启用" {if condition="$info.status == 1"}checked{/if}>
                    <input type="radio" name="status" value="0" title="禁用" {if condition="$info.status == 0"}checked{/if}>
                </div>
            </div>
            
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit lay-filter="submitBtn">提交</button>
                    <a href="/admin/solution/index" class="layui-btn layui-btn-primary">返回</a>
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
    
    // 设置编辑器内容
    {if condition="$info.content"}
    editor.txt.html('{$info.content}');
    {/if}
    
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
        $.post('/admin/solution/edit?id=' + data.field.id, data.field, function(res){
            if(res.code == 0){
                layer.msg(res.msg, {icon: 1}, function(){
                    location.href = '/admin/solution/index';
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

