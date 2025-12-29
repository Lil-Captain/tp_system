<?php
namespace app\controller\admin;

use think\facade\Db;
use think\facade\View;
use think\facade\Request;

class Banner extends Base
{
    /**
     * 轮播图列表
     */
    public function index()
    {
        $list = Db::table('bew_banner')
            ->order('sort asc, id desc')
            ->select()
            ->toArray();
        
        View::assign('list', $list);
        return View::fetch();
    }
    
    /**
     * 添加轮播图
     */
    public function add()
    {
        if (Request::isPost()) {
            $data = [
                'title' => input('post.title', ''),
                'image' => input('post.image', ''),
                'link' => input('post.link', ''),
                'sort' => input('post.sort', 0),
                'status' => input('post.status', 1),
                'create_time' => date('Y-m-d H:i:s'),
                'update_time' => date('Y-m-d H:i:s'),
            ];
            
            if (empty($data['image'])) {
                return $this->jsonReturn(1, '请上传图片');
            }
            
            $id = Db::table('bew_banner')->insertGetId($data);
            if ($id) {
                return $this->jsonReturn(0, '添加成功');
            } else {
                return $this->jsonReturn(1, '添加失败');
            }
        }
        
        return View::fetch();
    }
    
    /**
     * 编辑轮播图
     */
    public function edit()
    {
        $id = input('get.id', 0);
        if (empty($id)) {
            return $this->jsonReturn(1, '参数错误');
        }
        
        if (Request::isPost()) {
            $data = [
                'title' => input('post.title', ''),
                'image' => input('post.image', ''),
                'link' => input('post.link', ''),
                'sort' => input('post.sort', 0),
                'status' => input('post.status', 1),
                'update_time' => date('Y-m-d H:i:s'),
            ];
            
            if (empty($data['image'])) {
                return $this->jsonReturn(1, '请上传图片');
            }
            
            $result = Db::table('bew_banner')->where('id', $id)->update($data);
            if ($result !== false) {
                return $this->jsonReturn(0, '更新成功');
            } else {
                return $this->jsonReturn(1, '更新失败');
            }
        }
        
        $info = Db::table('bew_banner')->where('id', $id)->find();
        if (empty($info)) {
            return redirect('/admin/banner/index');
        }
        
        View::assign('info', $info);
        return View::fetch();
    }
    
    /**
     * 删除轮播图
     */
    public function delete()
    {
        $id = input('post.id', 0);
        if (empty($id)) {
            return $this->jsonReturn(1, '参数错误');
        }
        
        $result = Db::table('bew_banner')->where('id', $id)->delete();
        if ($result) {
            return $this->jsonReturn(0, '删除成功');
        } else {
            return $this->jsonReturn(1, '删除失败');
        }
    }
}

