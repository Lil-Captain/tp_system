{extend name="layout" /}

{block name="title"}修改密码{/block}

{block name="content"}
<div class="layui-card">
    <div class="layui-card-header">修改密码</div>
    <div class="layui-card-body">
        <form class="layui-form" lay-filter="passwordForm">
            <div class="layui-form-item">
                <label class="layui-form-label">原密码</label>
                <div class="layui-input-block">
                    <input type="password" name="old_password" required lay-verify="required" placeholder="请输入原密码" class="layui-input">
                </div>
            </div>
            
            <div class="layui-form-item">
                <label class="layui-form-label">新密码</label>
                <div class="layui-input-block">
                    <input type="password" name="new_password" required lay-verify="required|password" placeholder="请输入新密码（至少6位）" class="layui-input">
                </div>
            </div>
            
            <div class="layui-form-item">
                <label class="layui-form-label">确认密码</label>
                <div class="layui-input-block">
                    <input type="password" name="confirm_password" required lay-verify="required|confirm" placeholder="请再次输入新密码" class="layui-input">
                </div>
            </div>
            
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit lay-filter="submitBtn">提交</button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
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
    
    // 自定义验证规则
    form.verify({
        password: function(value){
            if(value.length < 6){
                return '密码长度不能少于6位';
            }
        },
        confirm: function(value){
            var newPassword = $('input[name="new_password"]').val();
            if(value != newPassword){
                return '两次输入的密码不一致';
            }
        }
    });
    
    // 表单提交
    form.on('submit(submitBtn)', function(data){
        $.post('/admin/setting/password', data.field, function(res){
            if(res.code == 0){
                layer.msg(res.msg, {icon: 1}, function(){
                    location.href = '/login/logout';
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

