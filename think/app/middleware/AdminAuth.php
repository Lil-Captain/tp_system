<?php
namespace app\middleware;

use think\facade\Cookie;
use think\facade\View;

class AdminAuth
{
    /**
     * 处理请求
     *
     * @param \think\Request $request
     * @param \Closure       $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        // 检查是否登录
        $adminId = Cookie::get('admin_id');
        $adminName = Cookie::get('admin_name');
        
        if (empty($adminId) || empty($adminName)) {
            // 如果是AJAX请求，返回JSON
            if ($request->isAjax()) {
                return json(['code' => 401, 'msg' => '请先登录']);
            }
            // 否则跳转到登录页
            return redirect('/login/index');
        }
        
        // 将管理员信息传递给视图
        View::assign('admin_id', $adminId);
        View::assign('admin_name', $adminName);
        
        return $next($request);
    }
}

