<?php
namespace app\controller\admin;

use think\facade\Db;
use think\facade\View;
use think\facade\Request;

class News extends Base
{
    /**
     * 新闻分类列表
     */
    public function category()
    {
        if (Request::isPost()) {
            $action = input('post.action', '');
            
            if ($action == 'add') {
                $data = [
                    'name' => input('post.name', ''),
                    'sort' => input('post.sort', 0),
                    'status' => input('post.status', 1),
                    'create_time' => date('Y-m-d H:i:s'),
                    'update_time' => date('Y-m-d H:i:s'),
                ];
                
                if (empty($data['name'])) {
                    return $this->jsonReturn(1, '请输入分类名称');
                }
                
                $id = Db::table('bew_news_category')->insertGetId($data);
                if ($id) {
                    return $this->jsonReturn(0, '添加成功');
                } else {
                    return $this->jsonReturn(1, '添加失败');
                }
            } elseif ($action == 'edit') {
                $id = input('post.id', 0);
                $data = [
                    'name' => input('post.name', ''),
                    'sort' => input('post.sort', 0),
                    'status' => input('post.status', 1),
                    'update_time' => date('Y-m-d H:i:s'),
                ];
                
                if (empty($data['name'])) {
                    return $this->jsonReturn(1, '请输入分类名称');
                }
                
                $result = Db::table('bew_news_category')->where('id', $id)->update($data);
                if ($result !== false) {
                    return $this->jsonReturn(0, '更新成功');
                } else {
                    return $this->jsonReturn(1, '更新失败');
                }
            } elseif ($action == 'delete') {
                $id = input('post.id', 0);
                // 检查是否有新闻使用此分类
                $count = Db::table('bew_news')->where('category_id', $id)->count();
                if ($count > 0) {
                    return $this->jsonReturn(1, '该分类下还有新闻，无法删除');
                }
                
                $result = Db::table('bew_news_category')->where('id', $id)->delete();
                if ($result) {
                    return $this->jsonReturn(0, '删除成功');
                } else {
                    return $this->jsonReturn(1, '删除失败');
                }
            }
        }
        
        $list = Db::table('bew_news_category')
            ->order('sort asc, id desc')
            ->select()
            ->toArray();
        
        View::assign('list', $list);
        return View::fetch();
    }
    
    /**
     * 新闻列表
     */
    public function index()
    {
        $category_id = input('get.category_id', 0);
        $keyword = input('get.keyword', '');
        
        $where = [];
        if ($category_id > 0) {
            $where[] = ['category_id', '=', $category_id];
        }
        if (!empty($keyword)) {
            $where[] = ['title', 'like', '%' . $keyword . '%'];
        }
        
        $list = Db::table('bew_news')
            ->where($where)
            ->order('id desc')
            ->paginate([
                'list_rows' => 15,
                'query' => request()->get(),
            ]);
        
        // 获取分类列表
        $categories = Db::table('bew_news_category')
            ->where('status', 1)
            ->order('sort asc')
            ->select()
            ->toArray();
        
        View::assign('list', $list);
        View::assign('categories', $categories);
        View::assign('category_id', $category_id);
        View::assign('keyword', $keyword);
        return View::fetch();
    }
    
    /**
     * 添加新闻
     */
    public function add()
    {
        if (Request::isPost()) {
            $data = [
                'category_id' => input('post.category_id', 0),
                'title' => input('post.title', ''),
                'image' => input('post.image', ''),
                'summary' => input('post.summary', ''),
                'content' => input('post.content', ''),
                'status' => input('post.status', 1),
                'create_time' => date('Y-m-d H:i:s'),
                'update_time' => date('Y-m-d H:i:s'),
            ];
            
            if (empty($data['title'])) {
                return $this->jsonReturn(1, '请输入新闻标题');
            }
            if (empty($data['category_id'])) {
                return $this->jsonReturn(1, '请选择新闻分类');
            }
            
            $id = Db::table('bew_news')->insertGetId($data);
            if ($id) {
                return $this->jsonReturn(0, '添加成功');
            } else {
                return $this->jsonReturn(1, '添加失败');
            }
        }
        
        // 获取分类列表
        $categories = Db::table('bew_news_category')
            ->where('status', 1)
            ->order('sort asc')
            ->select()
            ->toArray();
        
        View::assign('categories', $categories);
        return View::fetch();
    }
    
    /**
     * 编辑新闻
     */
    public function edit()
    {
        $id = input('get.id', 0);
        if (empty($id)) {
            return redirect('/admin/news/index');
        }
        
        if (Request::isPost()) {
            $data = [
                'category_id' => input('post.category_id', 0),
                'title' => input('post.title', ''),
                'image' => input('post.image', ''),
                'summary' => input('post.summary', ''),
                'content' => input('post.content', ''),
                'status' => input('post.status', 1),
                'update_time' => date('Y-m-d H:i:s'),
            ];
            
            if (empty($data['title'])) {
                return $this->jsonReturn(1, '请输入新闻标题');
            }
            if (empty($data['category_id'])) {
                return $this->jsonReturn(1, '请选择新闻分类');
            }
            
            $result = Db::table('bew_news')->where('id', $id)->update($data);
            if ($result !== false) {
                return $this->jsonReturn(0, '更新成功');
            } else {
                return $this->jsonReturn(1, '更新失败');
            }
        }
        
        $info = Db::table('bew_news')->where('id', $id)->find();
        if (empty($info)) {
            return redirect('/admin/news/index');
        }
        
        // 获取分类列表
        $categories = Db::table('bew_news_category')
            ->where('status', 1)
            ->order('sort asc')
            ->select()
            ->toArray();
        
        View::assign('info', $info);
        View::assign('categories', $categories);
        return View::fetch();
    }
    
    /**
     * 删除新闻
     */
    public function delete()
    {
        $id = input('post.id', 0);
        if (empty($id)) {
            return $this->jsonReturn(1, '参数错误');
        }
        
        $result = Db::table('bew_news')->where('id', $id)->delete();
        if ($result) {
            return $this->jsonReturn(0, '删除成功');
        } else {
            return $this->jsonReturn(1, '删除失败');
        }
    }
}

