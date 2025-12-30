{extend name="layout" /}

{block name="title"}新闻分类管理{/block}

{block name="content"}
<div class="layui-card">
    <div class="layui-card-header">
        <span>新闻分类列表</span>
        <button class="layui-btn layui-btn-sm" onclick="addCategory()" style="float: right;">添加分类</button>
    </div>
    <div class="layui-card-body">
        <table class="layui-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>分类名称</th>
                    <th>排序</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                {volist name="list" id="vo"}
                <tr>
                    <td>{$vo.id}</td>
                    <td>{$vo.name}</td>
                    <td>{$vo.sort}</td>
                    <td>
                        {if condition="$vo.status == 1"}
                        <span class="layui-badge layui-bg-green">启用</span>
                        {else /}
                        <span class="layui-badge">禁用</span>
                        {/if}
                    </td>
                    <td>
                        <button class="layui-btn layui-btn-xs" onclick="editCategory({$vo.id}, '{$vo.name}', {$vo.sort}, {$vo.status})">编辑</button>
                        <button class="layui-btn layui-btn-danger layui-btn-xs" onclick="deleteCategory({$vo.id})">删除</button>
                    </td>
                </tr>
                {/volist}
                {empty name="list"}
                <tr><td colspan="5" style="text-align: center;">暂无数据</td></tr>
                {/empty}
            </tbody>
        </table>
    </div>
</div>

<!-- 弹窗模板（隐藏） -->
<div id="categoryFormTemplate" style="display: none;">
    <form class="layui-form" lay-filter="categoryForm">
        <input type="hidden" name="action" id="formAction" value="add">
        <input type="hidden" name="id" id="formId">
        <div class="layui-form-item">
            <label class="layui-form-label">分类名称</label>
            <div class="layui-input-block">
                <input type="text" name="name" id="formName" required lay-verify="required" placeholder="请输入分类名称" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">排序</label>
            <div class="layui-input-block">
                <input type="number" name="sort" id="formSort" value="0" class="layui-input">
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
                <button class="layui-btn" lay-submit lay-filter="submitCategory">提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
</div>
{/block}

{block name="js"}
<script>
layui.use(['form', 'layer', 'jquery'], function(){
    var form = layui.form;
    var layer = layui.layer;
    var $ = layui.$;
    
    window.addCategory = function() {
        var html = $('#categoryFormTemplate').html();
        var index = layer.open({
            type: 1,
            title: '添加分类',
            area: ['500px', '400px'],
            content: '<div style="padding: 20px;">' + html + '</div>',
            shadeClose: true,
            closeBtn: 1,
            success: function(layero, index) {
                // 设置表单值
                layero.find('#formAction').val('add');
                layero.find('#formId').val('');
                layero.find('#formName').val('');
                layero.find('#formSort').val(0);
                layero.find('input[name="status"][value="1"]').prop('checked', true);
                
                // 重新渲染表单
                form.render();
                
                // 绑定提交事件
                form.on('submit(submitCategory)', function(data){
                    data.field.action = 'add';
                    $.post('/admin/news/category', data.field, function(res){
                        if(res.code == 0){
                            layer.close(index);
                            layer.msg(res.msg, {icon: 1}, function(){
                                location.reload();
                            });
                        } else {
                            layer.msg(res.msg, {icon: 2});
                        }
                    }, 'json');
                    return false;
                });
            }
        });
    };
    
    window.editCategory = function(id, name, sort, status) {
        var html = $('#categoryFormTemplate').html();
        var index = layer.open({
            type: 1,
            title: '编辑分类',
            area: ['500px', '400px'],
            content: '<div style="padding: 20px;">' + html + '</div>',
            shadeClose: true,
            closeBtn: 1,
            success: function(layero, index) {
                // 设置表单值
                layero.find('#formAction').val('edit');
                layero.find('#formId').val(id);
                layero.find('#formName').val(name);
                layero.find('#formSort').val(sort);
                layero.find('input[name="status"]').prop('checked', false);
                layero.find('input[name="status"][value="' + status + '"]').prop('checked', true);
                
                // 重新渲染表单
                form.render();
                
                // 绑定提交事件
                form.on('submit(submitCategory)', function(data){
                    data.field.action = 'edit';
                    data.field.id = id;
                    $.post('/admin/news/category', data.field, function(res){
                        if(res.code == 0){
                            layer.close(index);
                            layer.msg(res.msg, {icon: 1}, function(){
                                location.reload();
                            });
                        } else {
                            layer.msg(res.msg, {icon: 2});
                        }
                    }, 'json');
                    return false;
                });
            }
        });
    };
    
    window.deleteCategory = function(id) {
        layer.confirm('确定要删除吗？', {icon: 3, title: '提示'}, function(index){
            $.post('/admin/news/category', {action: 'delete', id: id}, function(res){
                if(res.code == 0){
                    layer.msg(res.msg, {icon: 1}, function(){
                        location.reload();
                    });
                } else {
                    layer.msg(res.msg, {icon: 2});
                }
            }, 'json');
            layer.close(index);
        });
    };
    
});
</script>
{/block}

