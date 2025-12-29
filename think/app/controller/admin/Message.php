<?php
namespace app\controller\admin;

use think\facade\Db;
use think\facade\View;
use think\facade\Request;

class Message extends Base
{
    /**
     * 留言列表
     */
    public function index()
    {
        $status = input('get.status', '');
        $keyword = input('get.keyword', '');
        
        $where = [];
        if ($status !== '') {
            $where[] = ['status', '=', $status];
        }
        if (!empty($keyword)) {
            $where[] = ['name|subject|content', 'like', '%' . $keyword . '%'];
        }
        
        $list = Db::table('bew_message')
            ->where($where)
            ->order('id desc')
            ->paginate([
                'list_rows' => 15,
                'query' => request()->get(),
            ]);
        
        View::assign('list', $list);
        View::assign('status', $status);
        View::assign('keyword', $keyword);
        return View::fetch();
    }
    
    /**
     * 留言详情
     */
    public function detail()
    {
        $id = input('get.id', 0);
        if (empty($id)) {
            return redirect('/admin/message/index');
        }
        
        if (Request::isPost()) {
            // 回复留言
            $reply = input('post.reply', '');
            $data = [
                'reply' => $reply,
                'reply_time' => date('Y-m-d H:i:s'),
                'status' => 1, // 标记为已读
            ];
            
            Db::table('bew_message')->where('id', $id)->update($data);
            return $this->jsonReturn(0, '回复成功');
        }
        
        $info = Db::table('bew_message')->where('id', $id)->find();
        if (empty($info)) {
            return redirect('/admin/message/index');
        }
        
        // 标记为已读
        if ($info['status'] == 0) {
            Db::table('bew_message')->where('id', $id)->update(['status' => 1]);
        }
        
        View::assign('info', $info);
        return View::fetch();
    }
    
    /**
     * 删除留言
     */
    public function delete()
    {
        $id = input('post.id', 0);
        if (empty($id)) {
            return $this->jsonReturn(1, '参数错误');
        }
        
        $result = Db::table('bew_message')->where('id', $id)->delete();
        if ($result) {
            return $this->jsonReturn(0, '删除成功');
        } else {
            return $this->jsonReturn(1, '删除失败');
        }
    }
}

