{extend name="layout" /}

{block name="title"}控制台{/block}

{block name="content"}
<div class="layui-row layui-col-space15">
    <!-- 统计卡片 -->
    <div class="layui-col-md3">
        <div class="layui-card">
            <div class="layui-card-body">
                <div style="font-size: 30px; color: #1E9FFF;">
                    <i class="layui-icon layui-icon-picture"></i> {$data.banner_count}
                </div>
                <div style="margin-top: 10px;">轮播图</div>
            </div>
        </div>
    </div>
    <div class="layui-col-md3">
        <div class="layui-card">
            <div class="layui-card-body">
                <div style="font-size: 30px; color: #FF5722;">
                    <i class="layui-icon layui-icon-goods"></i> {$data.product_count}
                </div>
                <div style="margin-top: 10px;">产品</div>
            </div>
        </div>
    </div>
    <div class="layui-col-md3">
        <div class="layui-card">
            <div class="layui-card-body">
                <div style="font-size: 30px; color: #5FB878;">
                    <i class="layui-icon layui-icon-file"></i> {$data.news_count}
                </div>
                <div style="margin-top: 10px;">新闻</div>
            </div>
        </div>
    </div>
    <div class="layui-col-md3">
        <div class="layui-card">
            <div class="layui-card-body">
                <div style="font-size: 30px; color: #FFB800;">
                    <i class="layui-icon layui-icon-email"></i> {$data.message_count}
                </div>
                <div style="margin-top: 10px;">未读留言</div>
            </div>
        </div>
    </div>
</div>

<div class="layui-row layui-col-space15" style="margin-top: 15px;">
    <!-- 最新留言 -->
    <div class="layui-col-md6">
        <div class="layui-card">
            <div class="layui-card-header">最新留言</div>
            <div class="layui-card-body">
                <table class="layui-table">
                    <thead>
                        <tr>
                            <th>姓名</th>
                            <th>主题</th>
                            <th>时间</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        {volist name="latest_messages" id="vo"}
                        <tr>
                            <td>{$vo.name}</td>
                            <td>{$vo.subject|default='无主题'}</td>
                            <td>{$vo.create_time}</td>
                            <td>
                                <a href="/admin/message/detail?id={$vo.id}" class="layui-btn layui-btn-xs">查看</a>
                            </td>
                        </tr>
                        {/volist}
                        {empty name="latest_messages"}
                        <tr><td colspan="4" style="text-align: center;">暂无留言</td></tr>
                        {/empty}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- 最新新闻 -->
    <div class="layui-col-md6">
        <div class="layui-card">
            <div class="layui-card-header">最新新闻</div>
            <div class="layui-card-body">
                <table class="layui-table">
                    <thead>
                        <tr>
                            <th>标题</th>
                            <th>时间</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        {volist name="latest_news" id="vo"}
                        <tr>
                            <td>{$vo.title}</td>
                            <td>{$vo.create_time}</td>
                            <td>
                                <a href="/admin/news/edit?id={$vo.id}" class="layui-btn layui-btn-xs">编辑</a>
                            </td>
                        </tr>
                        {/volist}
                        {empty name="latest_news"}
                        <tr><td colspan="3" style="text-align: center;">暂无新闻</td></tr>
                        {/empty}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
{/block}

