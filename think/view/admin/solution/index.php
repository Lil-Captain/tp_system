{extend name="layout" /}

{block name="title"}解决方案管理{/block}

{block name="content"}
<div class="layui-card">
    <div class="layui-card-header">
        <span>解决方案列表</span>
        <a href="/admin/solution/add" class="layui-btn layui-btn-sm" style="float: right;">添加方案</a>
    </div>
    <div class="layui-card-body">
        <form class="layui-form" style="margin-bottom: 15px;">
            <div class="layui-row layui-col-space10">
                <div class="layui-col-md3">
                    <input type="text" name="keyword" value="{$keyword}" placeholder="搜索关键词" class="layui-input">
                </div>
                <div class="layui-col-md2">
                    <button type="submit" class="layui-btn">搜索</button>
                    <a href="/admin/solution/index" class="layui-btn layui-btn-primary">重置</a>
                </div>
            </div>
        </form>
        
        <table class="layui-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>方案标题</th>
                    <th>图片</th>
                    <th>排序</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                {volist name="list" id="vo"}
                <tr>
                    <td>{$vo.id}</td>
                    <td>{$vo.title}</td>
                    <td>
                        {if condition="$vo.image"}
                        <img src="{$vo.image}" style="max-width: 80px; max-height: 60px;" />
                        {else /}
                        -
                        {/if}
                    </td>
                    <td>{$vo.sort}</td>
                    <td>
                        {if condition="$vo.status == 1"}
                        <span class="layui-badge layui-bg-green">启用</span>
                        {else /}
                        <span class="layui-badge">禁用</span>
                        {/if}
                    </td>
                    <td>
                        <a href="/admin/solution/edit?id={$vo.id}" class="layui-btn layui-btn-xs">编辑</a>
                        <button class="layui-btn layui-btn-danger layui-btn-xs" onclick="deleteSolution({$vo.id})">删除</button>
                    </td>
                </tr>
                {/volist}
                {empty name="list"}
                <tr><td colspan="6" style="text-align: center;">暂无数据</td></tr>
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
    
    window.deleteSolution = function(id) {
        layer.confirm('确定要删除吗？', {icon: 3, title: '提示'}, function(index){
            $.post('/admin/solution/delete', {id: id}, function(res){
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

