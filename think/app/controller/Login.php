<?php
namespace app\controller;
use app\BaseController;
use think\facade\View;
use think\captcha\facade\Captcha;
use think\facade\Db;
use think\facade\Cookie;

class Login{
    public function index(){
        // echo md5("abc123456"); exit;
        return View::fetch();
    }

    public function doLogin()
    {
        $account = trim(input('post.account'));
        if(empty($account)){
            echo json_encode(["code"=>1, "msg"=>"请输入账号"]);
            exit;
        }

        $password = trim(input('post.password'));
        if(empty($password)){
            echo json_encode(["code"=>1, "msg"=>"请输入密码"]);
            exit;
        }
        
        $code = trim(input('post.captcha'));
        if(empty($code)){
            echo json_encode(["code"=>1, "msg"=>"请输入验证码"]);
            exit;
        }

        if(!captcha_check($code)){
            echo json_encode(["code"=>1, "msg"=>"验证码错误"]);
            exit;
        }

        $user = Db::table("bew_admin_user")->where("account", $account)->find();
        if(empty($user)){
            echo json_encode(["code"=>1, "msg"=>"未找到用户"]);
            exit;
        }

        if($user["password"] != md5($password)){
            echo json_encode(["code"=>1, "msg"=>"密码错误"]);
            exit;
        }

        Cookie::set("admin_id", $user["uid"]);
        Cookie::set("admin_name", $user["name"]);

        Db::table("bew_admin_user")->where("uid", $user["uid"])->update([
            "time_last" => date("Y-m-d H:i:s"),
            "times_login" => $user["times_login"] + 1
        ]);
        
        echo json_encode(["code"=>0, "msg"=>"登录成功"]);
    }
    
    /**
     * 退出登录
     */
    public function logout()
    {
        Cookie::delete('admin_id');
        Cookie::delete('admin_name');
        return redirect('/login/index');
    }
}