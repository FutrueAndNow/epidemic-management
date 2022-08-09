<?php

namespace app\admin\controller;

use app\admin\model\admininfo;
use app\admin\model\powerinfo;

class Admin extends Base
{
    public function index()
    {
        if ($this->powerid != 1) {
            return jsonStatus(false, '非超级管理员无法查看');
        }
        $model = new admininfo();
        $result = $model->field('a.*,b.power powerName')->alias('a')->join('powerinfo b', 'a.powerid = b.id')->select();
        if (!empty($result)) {
            return jsonStatus(true, '数据获取成功', $result);
        } else {
            return jsonStatus(false, '数据获取失败');
        }

    }

    public function edit()
    {
        if ($this->powerid != 1) {
            return jsonStatus(false, '非超级管理员无法查看');
        }
        $data = request()->put();
        if (empty($data['password']) || empty($data['powerid']) || empty($data['id'])) {
            return jsonStatus(false, '数据修改填写不完善');
        }
        $model = new admininfo();
        if ($data['powerid'] == 1) {
            return jsonStatus(false, '无法修改成超级管理员');
        }
        $powerid = (new powerinfo())->where('id', '=', $data['powerid'])->find();
        if (empty($powerid)) {
            return jsonStatus(false, '没有这个管理员权限');
        }
        $record = $model->where('id', '=', $data['id'])->find();
        if (empty($record)) {
            return jsonStatus(false, '查找不到管理员数据');
        }
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        if ($record->save($data)) {
            return jsonStatus(true, '数据修改成功', $record);
        } else {
            return jsonStatus(false, '数据修改失败', $record);
        }
    }

    public function add()
    {
        if ($this->powerid != 1) {
            return jsonStatus(false, '非超级管理员无法查看');
        }
        $data = request()->post();
        if (empty($data['password']) || empty($data['powerid']) || empty($data['username'])) {
            return jsonStatus(false, '数据修改填写不完善');
        }
        $powerid = (new powerinfo())->where('id', '=', $data['powerid'])->find();
        if (empty($powerid)) {
            return jsonStatus(false, '没有这个管理员权限');
        }
        if ($powerid['id'] == 1) {
            return jsonStatus(false, '超级管理员无法添加');
        }
        $model = new admininfo();
        $username = $model->where('username', '=', $data['username'])->find();
        if (!empty($username)) {
            return jsonStatus(false, '已有该管理员账号。请重新填写');
        }
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $data['status'] = 1;
        $record = $model->save($data);
        if ($record) {
            return jsonStatus(true, '管理员添加成功');
        } else {
            return jsonStatus(false, '管理员添加失败');
        }

    }

    public function premissonStatus()
    {
        if ($this->powerid != 1) {
            return jsonStatus(false, '非超级管理员无法更改其他账号状态');
        }
        $id = request()->delete('id');
        if (empty($id)) {
            return jsonStatus(false, '未获取到id');
        }
        $model = new admininfo();
        $record = $model->where('id', '=', $id)->find();
        if (empty($record)) {
            return jsonStatus(false, '未查找到要修改状态的id数据');
        }
        $record['status'] = $record['status'] == 1 ? 0 : 1;
        if ($record->save()) {
            return jsonStatus(true, '管理员修改状态成功');
        } else {
            return jsonStatus(false, '管理员修改状态失败');
        }
    }
}
