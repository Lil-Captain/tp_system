{extend name="layout" /}

{block name="title"}留言详情{/block}

{block name="content"}
<div class="layui-card">
    <div class="layui-card-header">留言详情</div>
    <div class="layui-card-body">
        <table class="layui-table">
            <tr>
                <th width="100">姓名</th>
                <td>{$info.name}</td>
            </tr>
            <tr>
                <th>电话</th>
                <td>{$info.phone|default='-'}</td>
            </tr>
            <tr>
                <th>邮箱</th>
                <td>{$info.email|default='-'}</td>
            </tr>
            <tr>
                <th>主题</th>
                <td>{$info.subject|default='无主题'}</td>
            </tr>
            <tr>
                <th>留言内容</th>
                <td>{$info.content|raw}</td>
            </tr>
            <tr>
                <th>留言时间</th>
                <td>{$info.create_time}</td>
            </tr>
            {if condition="$info.reply"}
            <tr>
                <th>回复内容</th>
                <td>{$info.reply|raw}</td>
            </tr>
            <tr>
                <th>回复时间</th>
                <td>{$info.reply_time}</td>
            </tr>
            {/if}
        </table>
        
        <form class="layui-form" style="margin-top: 20px;">
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">回复留言</label>
                <div class="layui-input-block">
                    <textarea name="reply" id="reply" placeholder="请输入回复内容" class="layui-textarea" style="min-height: 150px;">{$info.reply|default=''}</textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit lay-filter="submitBtn">提交回复</button>
                    <a href="/admin/message/index" class="layui-btn layui-btn-primary">返回</a>
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
    
    form.on('submit(submitBtn)', function(data){
        $.post('/admin/message/detail?id={$info.id}', data.field, function(res){
            if(res.code == 0){
                layer.msg(res.msg, {icon: 1}, function(){
                    location.reload();
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

