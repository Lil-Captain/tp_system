<?php
namespace app\controller\admin;

use think\facade\Db;
use think\facade\View;
use think\facade\Request;

class Partner extends Base
{
    /**
     * 合作伙伴列表
     */
    public function index()
    {
        $keyword = input('get.keyword', '');
        
        $where = [];
        if (!empty($keyword)) {
            $where[] = ['name', 'like', '%' . $keyword . '%'];
        }
        
        $list = Db::table('bew_partner')
            ->where($where)
            ->order('sort asc, id desc')
            ->paginate([
                'list_rows' => 15,
                'query' => request()->get(),
            ]);
        
        View::assign('list', $list);
        View::assign('keyword', $keyword);
        return View::fetch();
    }
    
    /**
     * 添加合作伙伴
     */
    public function add()
    {
        if (Request::isPost()) {
            $data = [
                'name' => input('post.name', ''),
                'logo' => input('post.logo', ''),
                'link' => input('post.link', ''),
                'description' => input('post.description', ''),
                'sort' => input('post.sort', 0),
                'status' => input('post.status', 1),
                'create_time' => date('Y-m-d H:i:s'),
                'update_time' => date('Y-m-d H:i:s'),
            ];
            
            if (empty($data['name'])) {
                return $this->jsonReturn(1, '请输入合作伙伴名称');
            }
            
            $id = Db::table('bew_partner')->insertGetId($data);
            if ($id) {
                return $this->jsonReturn(0, '添加成功');
            } else {
                return $this->jsonReturn(1, '添加失败');
            }
        }
        
        return View::fetch();
    }
    
    /**
     * 编辑合作伙伴
     */
    public function edit()
    {
        $id = input('get.id', 0);
        if (empty($id)) {
            return redirect('/admin/partner/index');
        }
        
        if (Request::isPost()) {
            $data = [
                'name' => input('post.name', ''),
                'logo' => input('post.logo', ''),
                'link' => input('post.link', ''),
                'description' => input('post.description', ''),
                'sort' => input('post.sort', 0),
                'status' => input('post.status', 1),
                'update_time' => date('Y-m-d H:i:s'),
            ];
            
            if (empty($data['name'])) {
                return $this->jsonReturn(1, '请输入合作伙伴名称');
            }
            
            $result = Db::table('bew_partner')->where('id', $id)->update($data);
            if ($result !== false) {
                return $this->jsonReturn(0, '更新成功');
            } else {
                return $this->jsonReturn(1, '更新失败');
            }
        }
        
        $info = Db::table('bew_partner')->where('id', $id)->find();
        if (empty($info)) {
            return redirect('/admin/partner/index');
        }
        
        View::assign('info', $info);
        return View::fetch();
    }
    
    /**
     * 删除合作伙伴
     */
    public function delete()
    {
        $id = input('post.id', 0);
        if (empty($id)) {
            return $this->jsonReturn(1, '参数错误');
        }
        
        $result = Db::table('bew_partner')->where('id', $id)->delete();
        if ($result) {
            return $this->jsonReturn(0, '删除成功');
        } else {
            return $this->jsonReturn(1, '删除失败');
        }
    }
}

