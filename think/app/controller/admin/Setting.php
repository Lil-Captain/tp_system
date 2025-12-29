<?php
namespace app\controller\admin;

use think\facade\Db;
use think\facade\View;
use think\facade\Request;

class Setting extends Base
{
    /**
     * 修改密码
     */
    public function password()
    {
        if (Request::isPost()) {
            $old_password = input('post.old_password', '');
            $new_password = input('post.new_password', '');
            $confirm_password = input('post.confirm_password', '');
            
            if (empty($old_password)) {
                return $this->jsonReturn(1, '请输入原密码');
            }
            if (empty($new_password)) {
                return $this->jsonReturn(1, '请输入新密码');
            }
            if (strlen($new_password) < 6) {
                return $this->jsonReturn(1, '新密码长度不能少于6位');
            }
            if ($new_password != $confirm_password) {
                return $this->jsonReturn(1, '两次输入的密码不一致');
            }
            
            // 验证原密码
            $admin = Db::table('bew_admin_user')->where('uid', $this->adminId)->find();
            if (md5($old_password) != $admin['password']) {
                return $this->jsonReturn(1, '原密码错误');
            }
            
            // 更新密码
            $result = Db::table('bew_admin_user')
                ->where('uid', $this->adminId)
                ->update([
                    'password' => md5($new_password),
                    'update_time' => date('Y-m-d H:i:s'),
                ]);
            
            if ($result !== false) {
                return $this->jsonReturn(0, '密码修改成功，请重新登录');
            } else {
                return $this->jsonReturn(1, '密码修改失败');
            }
        }
        
        return View::fetch();
    }
    
    /**
     * 站点配置
     */
    public function config()
    {
        if (Request::isPost()) {
            $configs = input('post.config', []);
            
            foreach ($configs as $key => $value) {
                $info = Db::table('bew_config')->where('key', $key)->find();
                if ($info) {
                    Db::table('bew_config')->where('key', $key)->update([
                        'value' => $value,
                        'update_time' => date('Y-m-d H:i:s'),
                    ]);
                } else {
                    Db::table('bew_config')->insert([
                        'key' => $key,
                        'value' => $value,
                        'update_time' => date('Y-m-d H:i:s'),
                    ]);
                }
            }
            
            return $this->jsonReturn(0, '保存成功');
        }
        
        // 获取配置列表
        $configs = Db::table('bew_config')->select()->toArray();
        $configData = [];
        foreach ($configs as $config) {
            $configData[$config['key']] = $config['value'];
        }
        
        View::assign('configs', $configData);
        return View::fetch();
    }
}

