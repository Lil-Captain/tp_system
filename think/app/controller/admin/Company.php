<?php
namespace app\controller\admin;

use think\facade\Db;
use think\facade\View;
use think\facade\Request;

class Company extends Base
{
    /**
     * 公司简介
     */
    public function intro()
    {
        if (Request::isPost()) {
            $data = [
                'type' => 'intro',
                'title' => input('post.title', ''),
                'content' => input('post.content', ''),
                'image' => input('post.image', ''),
                'update_time' => date('Y-m-d H:i:s'),
            ];
            
            $info = Db::table('bew_company_info')->where('type', 'intro')->find();
            if ($info) {
                Db::table('bew_company_info')->where('type', 'intro')->update($data);
            } else {
                $data['create_time'] = date('Y-m-d H:i:s');
                Db::table('bew_company_info')->insert($data);
            }
            
            return $this->jsonReturn(0, '保存成功');
        }
        
        $info = Db::table('bew_company_info')->where('type', 'intro')->find();
        // 确保info数组包含所有必要的键，避免视图访问时报错
        $info = $info ?: [];
        $info = array_merge([
            'title' => '',
            'content' => '',
            'image' => '',
        ], $info);
        View::assign('info', $info);
        return View::fetch();
    }
    
    /**
     * 关于我们
     */
    public function about()
    {
        if (Request::isPost()) {
            $data = [
                'type' => 'about',
                'title' => input('post.title', ''),
                'content' => input('post.content', ''),
                'image' => input('post.image', ''),
                'update_time' => date('Y-m-d H:i:s'),
            ];
            
            $info = Db::table('bew_company_info')->where('type', 'about')->find();
            if ($info) {
                Db::table('bew_company_info')->where('type', 'about')->update($data);
            } else {
                $data['create_time'] = date('Y-m-d H:i:s');
                Db::table('bew_company_info')->insert($data);
            }
            
            return $this->jsonReturn(0, '保存成功');
        }
        
        $info = Db::table('bew_company_info')->where('type', 'about')->find();
        // 确保info数组包含所有必要的键，避免视图访问时报错
        $info = $info ?: [];
        $info = array_merge([
            'title' => '',
            'content' => '',
            'image' => '',
        ], $info);
        View::assign('info', $info);
        return View::fetch();
    }
    
    /**
     * 联系方式
     */
    public function contact()
    {
        if (Request::isPost()) {
            $data = [
                'type' => 'contact',
                'title' => input('post.title', ''),
                'address' => input('post.address', ''),
                'phone' => input('post.phone', ''),
                'email' => input('post.email', ''),
                'map_lat' => input('post.map_lat', ''),
                'map_lng' => input('post.map_lng', ''),
                'update_time' => date('Y-m-d H:i:s'),
            ];
            
            $info = Db::table('bew_company_info')->where('type', 'contact')->find();
            if ($info) {
                Db::table('bew_company_info')->where('type', 'contact')->update($data);
            } else {
                $data['create_time'] = date('Y-m-d H:i:s');
                Db::table('bew_company_info')->insert($data);
            }
            
            return $this->jsonReturn(0, '保存成功');
        }
        
        $info = Db::table('bew_company_info')->where('type', 'contact')->find();
        // 确保info数组包含所有必要的键，避免视图访问时报错
        $info = $info ?: [];
        $info = array_merge([
            'title' => '',
            'address' => '',
            'phone' => '',
            'email' => '',
            'map_lat' => '',
            'map_lng' => '',
        ], $info);
        View::assign('info', $info);
        return View::fetch();
    }
}

