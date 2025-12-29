{extend name="layout" /}

{block name="title"}轮播图管理{/block}

{block name="content"}
<div class="layui-card">
    <div class="layui-card-header">
        <span>轮播图列表</span>
        <a href="/admin/banner/add" class="layui-btn layui-btn-sm" style="float: right;">添加轮播图</a>
    </div>
    <div class="layui-card-body">
        <table class="layui-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>标题</th>
                    <th>图片</th>
                    <th>链接</th>
                    <th>排序</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                {volist name="list" id="vo"}
                <tr>
                    <td>{$vo.id}</td>
                    <td>{$vo.title|default='-'}</td>
                    <td>
                        {if condition="$vo.image"}
                        <img src="{$vo.image}" style="max-width: 100px; max-height: 60px;" />
                        {else /}
                        -
                        {/if}
                    </td>
                    <td>{$vo.link|default='-'}</td>
                    <td>{$vo.sort}</td>
                    <td>
                        {if condition="$vo.status == 1"}
                        <span class="layui-badge layui-bg-green">启用</span>
                        {else /}
                        <span class="layui-badge">禁用</span>
                        {/if}
                    </td>
                    <td>
                        <a href="/admin/banner/edit?id={$vo.id}" class="layui-btn layui-btn-xs">编辑</a>
                        <button class="layui-btn layui-btn-danger layui-btn-xs" onclick="deleteBanner({$vo.id})">删除</button>
                    </td>
                </tr>
                {/volist}
                {empty name="list"}
                <tr><td colspan="7" style="text-align: center;">暂无数据</td></tr>
                {/empty}
            </tbody>
        </table>
    </div>
</div>
{/block}

{block name="js"}
<script>
layui.use(['layer', 'jquery'], function(){
    var layer = layui.layer;
    var $ = layui.$;
    
    window.deleteBanner = function(id) {
        layer.confirm('确定要删除吗？', {icon: 3, title: '提示'}, function(index){
            $.post('/admin/banner/delete', {id: id}, function(res){
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

