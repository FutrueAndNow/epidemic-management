<?php


namespace app\admin\controller;


use app\admin\model\stuinfo;
use app\BaseController;

class Student extends BaseController
{
    public function findall()
    {
        $nums = $this->request->get('page_nums');
        if (empty($nums)) {
            $nums = 15;
        }
        $name = $this->request->get('name');
        $where = [];
        if (!empty($name)) {
            array_push($where, ['name', '=', $name]);
        }
        $model = new stuinfo();
        $result = $model->where($where)->paginate([
            'query' => $this->request->param('page'), //url额外参数
            'fragment' => '', //url锚点
            'var_page' => 'page', //分页变量
            'list_rows' => $nums, //每页数量
        ]);
        return  jsonStatus(true,'数据获取成功',$result);
    }

    public function update()
    {
        $id = $this->request->route('id');
        $data = $this->request->put();
        $password = $data['password'];
        $in_school_status = $data['in_school_status'];
        if (empty($password) && empty($in_school_status)) {
            return json([
                'code' => 400,
                'message' => '获取不到修改的值',
                '1'=>$password,
                '2'=>$in_school_status
            ]);
        }
        $record = (new stuinfo())->where('id', '=', $id)->find();
        if (empty($record)) {
            return jsonStatus(false,'查找不到数据');
        }
        $record['password'] = $password;
        $record['in_school_status'] = $in_school_status;
        $record['update_time'] = date('Y-m-d H:i:s');
        if (!$record->save()) {
            return jsonStatus(false,'修改失败');
        }
        return jsonStatus(true,'修改成功',$record);
    }

//    public function edit()
//    {
//        $id = $this->request->route('id');
//        if (empty($id)){
//            return json([
//                'code' => 400,
//                'message' => '未获取学生id',
//                'data' => []
//            ]);
//        }
//        $record = (new stuinfo())->where(['id', '=', $id])->find();
//        if (empty($record)) {
//            return json([
//                'code' => 400,
//                'message' => '查找不到该学生',
//                'data' => []
//            ]);
//        }
//        $data = $this->request->put();
//        $new_data['username'] = $data['username'];
//        $new_data['password'] = $data['password'];
//        (int) $new_data['in_school_status'] = $data['in_school_status'];
//        $new_data['update_time'] =date('Y-m-d H:i:s');
//        if ($record->save($new_data)){
//            return json([
//                'code' => 200,
//                'message' => '修改成功',
//                'data' => $record
//            ]);
//        }
//        return json([
//            'code' => 400,
//            'message' => '修改失败',
//            'data' => $record
//        ]);
//    }
}