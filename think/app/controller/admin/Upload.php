<?php
namespace app\controller\admin;

use think\facade\Filesystem;

class Upload extends Base
{
    /**
     * 图片上传
     */
    public function image()
    {
        $file = request()->file('file');
        if (empty($file)) {
            return $this->jsonReturn(1, '请选择文件');
        }
        
        // 验证文件类型
        $ext = $file->getOriginalExtension();
        $allowExt = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];
        if (!in_array(strtolower($ext), $allowExt)) {
            return $this->jsonReturn(1, '只允许上传图片文件');
        }
        
        // 验证文件大小（5MB）
        if ($file->getSize() > 5 * 1024 * 1024) {
            return $this->jsonReturn(1, '文件大小不能超过5MB');
        }
        
        try {
            // 保存文件
            $saveName = Filesystem::disk('public')->putFile('uploads', $file);
            $url = '/storage/' . $saveName;
            
            return $this->jsonReturn(0, '上传成功', ['url' => $url]);
        } catch (\Exception $e) {
            return $this->jsonReturn(1, '上传失败：' . $e->getMessage());
        }
    }
}

