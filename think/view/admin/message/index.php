{extend name="layout" /}

{block name="title"}留言管理{/block}

{block name="content"}
<div class="layui-card">
    <div class="layui-card-header">留言列表</div>
    <div class="layui-card-body">
        <form class="layui-form" style="margin-bottom: 15px;">
            <div class="layui-row layui-col-space10">
                <div class="layui-col-md3">
                    <select name="status">
                        <option value="">全部状态</option>
                        <option value="0" {if condition="$status === '0'"}selected{/if}>未读</option>
                        <option value="1" {if condition="$status === '1'"}selected{/if}>已读</option>
                    </select>
                </div>
                <div class="layui-col-md3">
                    <input type="text" name="keyword" value="{$keyword}" placeholder="搜索关键词" class="layui-input">
                </div>
                <div class="layui-col-md2">
                    <button type="submit" class="layui-btn">搜索</button>
                    <a href="/admin/message/index" class="layui-btn layui-btn-primary">重置</a>
                </div>
            </div>
        </form>
        
        <table class="layui-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>姓名</th>
                    <th>电话</th>
                    <th>邮箱</th>
                    <th>主题</th>
                    <th>状态</th>
                    <th>留言时间</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                {volist name="list" id="vo"}
                <tr>
                    <td>{$vo.id}</td>
                    <td>{$vo.name}</td>
                    <td>{$vo.phone|default='-'}</td>
                    <td>{$vo.email|default='-'}</td>
                    <td>{$vo.subject|default='无主题'}</td>
                    <td>
                        {if condition="$vo.status == 1"}
                        <span class="layui-badge layui-bg-green">已读</span>
                        {else /}
                        <span class="layui-badge layui-bg-orange">未读</span>
                        {/if}
                    </td>
                    <td>{$vo.create_time}</td>
                    <td>
                        <a href="/admin/message/detail?id={$vo.id}" class="layui-btn layui-btn-xs">查看</a>
                        <button class="layui-btn layui-btn-danger layui-btn-xs" onclick="deleteMessage({$vo.id})">删除</button>
                    </td>
                </tr>
                {/volist}
                {empty name="list"}
                <tr><td colspan="8" style="text-align: center;">暂无数据</td></tr>
                {/empty}
            </tbody>
        </table>
        
        <div class="layui-box layui-laypage">
            {$list->render()|raw}
        </div>
    </div>
</div>
{/block}

{block name="js"}
<script>
layui.use(['layer', 'jquery'], function(){
    var layer = layui.layer;
    var $ = layui.$;
    
    window.deleteMessage = function(id) {
        layer.confirm('确定要删除吗？', {icon: 3, title: '提示'}, function(index){
            $.post('/admin/message/delete', {id: id}, function(res){
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

