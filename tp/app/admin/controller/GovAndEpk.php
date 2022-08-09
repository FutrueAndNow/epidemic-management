<?php


namespace app\admin\controller;


use app\admin\model\epknowledgeinfo;
use app\admin\model\govdocumentsinfo;
use app\BaseController;

class GovAndEpk extends BaseController
{
    public static function search($modelName, $title = '')
    {
        $where = [];
        if (!empty($title)) {
            array_push($where, ['title', 'like', "%$title%"]);
        }
        $modelName == 1 ? $model = new govdocumentsinfo() : $model = new epknowledgeinfo();
        $result = $model->where($where)->select();
        return [
            'code' => 200,
            'message' => '数据获取成功',
            'data' => $result,
        ];
    }

    public static function edit($modelName, $data)
    {
        if (empty($data['id'])) {
            return [
                'code' => 400,
                'message' => '获取不到id'
            ];
        }
        $id = $data['id'];
        $new_data['title'] = $data['title'];
        $new_data['content'] = $data['content'];
        $new_data['source'] = $data['source'];
        $new_data['create_time'] = $data['create_time'];
        $modelName == 1 ? $model = new govdocumentsinfo() : $model = new epknowledgeinfo();
        $record = $model->where('id', '=', $id)->find();
        if (empty($record)) {
            return [
                'code' => 400,
                'message' => '获取不到要数据库中要修改的数据'
            ];
        }
        if ($record->save($new_data)) {
            return [
                'code' => 200,
                'message' => '修改成功',
                'data' => $record
            ];
        }
        return [
            'code' => 400,
            'message' => '修改失败',
            'data' => $record
        ];
    }

    public static function add($modelName, $data)
    {
        $new_data['title'] = $data['title'];
        $new_data['content'] = $data['content'];
        $new_data['source'] = $data['source'];
        $new_data['source'] = $data['source'];
        $modelName == 1 ? $model = new govdocumentsinfo() : $model = new epknowledgeinfo();
        $result = $model->save($new_data);
        if ($result) {
            return [
                'code' => 200,
                'message' => '新增成功',
            ];
        }
        return [
            'code' => 400,
            'message' => '新增失败',
        ];
    }

    public static function delete($modelName, $id)
    {
        if (empty($id)) {
            return [
                'code' => 400,
                'message' => '获取不到id'
            ];
        }
        $modelName == 1 ? $model = new govdocumentsinfo() : $model = new epknowledgeinfo();
        $record = $model->where('id', '=', $id)->find();
        if (empty($record)) {
            return [
                'code' => 400,
                'message' => '获取不到数据库中要删除的数据'
            ];
        }
        if ($record->delete()) {
            return [
                'code' => 200,
                'message' => '删除成功'
            ];
        }
        return [
            'code' => 400,
            'message' => '删除失败'
        ];
    }
}