<?php


namespace app\index\controller;


use app\BaseController;
use app\index\model\epknowledgeinfo;

class Epknowledge extends BaseController
{
    public function findall()
    {
        $id = $this->request->route('id');
        $where = [];
        if (!empty($id)) {
            array_push($where, ['id', '=', $id]);
        }
        $model = new epknowledgeinfo();
        $result = $model->where($where)->select();
        return json([
            'code' => 200,
            'message' => '数据获取成功',
            'data' => $result
        ]);
    }

    public function search()
    {
        $title = $this->request->route('title');
        if (empty($title)) {
            return json([
                'code' => 400,
                'message' => '未输入搜索的内容',
            ]);
        }
        $where = [];
        if (!empty($title)) {
            array_push($where, ['title', 'like', "%$title%"]);
        }
        $model = new epknowledgeinfo();
        $result = $model->where($where)->select();
        return json([
            'code' => 200,
            'message' => '数据获取成功',
            'data' => $result
        ]);
    }

}