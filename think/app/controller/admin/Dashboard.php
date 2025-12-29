<?php
namespace app\controller\admin;

use think\facade\Db;
use think\facade\View;

class Dashboard extends Base
{
    /**
     * 后台首页
     */
    public function index()
    {
        // 统计数据
        $data = [
            'banner_count' => Db::table('bew_banner')->count(),
            'product_count' => Db::table('bew_product')->count(),
            'news_count' => Db::table('bew_news')->count(),
            'message_count' => Db::table('bew_message')->where('status', 0)->count(), // 未读留言
            'partner_count' => Db::table('bew_partner')->count(),
        ];
        
        // 最新留言
        $latest_messages = Db::table('bew_message')
            ->order('create_time', 'desc')
            ->limit(5)
            ->select()
            ->toArray();
        
        // 最新新闻
        $latest_news = Db::table('bew_news')
            ->order('create_time', 'desc')
            ->limit(5)
            ->select()
            ->toArray();
        
        View::assign('data', $data);
        View::assign('latest_messages', $latest_messages);
        View::assign('latest_news', $latest_news);
        
        return View::fetch('dashboard/index');
    }
}

