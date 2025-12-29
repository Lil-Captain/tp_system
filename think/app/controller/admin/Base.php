<?php
namespace app\controller\admin;

use app\BaseController;
use think\facade\Cookie;
use think\facade\Db;

class Base extends BaseController
{
    protected $adminId;
    protected $adminName;
    
    protected function initialize()
    {
        parent::initialize();
        
        // 检查登录状态
        $this->adminId = Cookie::get('admin_id');
        $this->adminName = Cookie::get('admin_name');
        
        if (empty($this->adminId) || empty($this->adminName)) {
            if ($this->request->isAjax()) {
                echo json_encode(['code' => 401, 'msg' => '请先登录']);
                exit;
            }
            redirect('/login/index')->send();
            exit;
        }
        
        // 获取管理员信息
        $admin = Db::table('bew_admin_user')->where('uid', $this->adminId)->find();
        if (empty($admin)) {
            Cookie::delete('admin_id');
            Cookie::delete('admin_name');
            if ($this->request->isAjax()) {
                echo json_encode(['code' => 401, 'msg' => '用户不存在']);
                exit;
            }
            redirect('/login/index')->send();
            exit;
        }
        
        // 传递给视图
        \think\facade\View::assign('admin_id', $this->adminId);
        \think\facade\View::assign('admin_name', $this->adminName);
        \think\facade\View::assign('admin', $admin);
        
        // 设置视图路径，避免子目录控制器路径解析问题
        \think\facade\View::config(['view_path' => app()->getRootPath() . 'view/admin/']);
    }
    
    /**
     * 统一返回JSON格式
     */
    protected function jsonReturn($code = 0, $msg = '操作成功', $data = [])
    {
        return json(['code' => $code, 'msg' => $msg, 'data' => $data]);
    }
}

