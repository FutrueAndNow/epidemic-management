<?php


namespace app\admin\controller;


use app\admin\model\admininfo;
use app\admin\model\powerinfo;
use app\BaseController;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;

class AdminLogin extends BaseController
{
    public function login(): \think\response\Json
    {
        $username = $this->request->post('username');
        $password = $this->request->post('password');
        if (empty($username) || empty($password)) {
            return jsonStatus(false, '账号密码输入不完善');
        }
        $model = new admininfo();
        try {
            $record = $model->where('username', '=', $username)->find();
        } catch (DataNotFoundException | ModelNotFoundException | DbException $e) {
            return jsonStatus(false, '数据查询异常', $e);
        }
        if (!$record) {
            return jsonStatus(false, '找不到该账号。');
        } else {
            if (!password_verify($password, $record['password'])) {
                return jsonStatus(false, '密码错误');
            }
        }
        $powerName = (new powerinfo())->where('id','=',$record['powerid'])->find();
        $record['powerName'] = $powerName['power'];
        $record['token'] = signAdminToken($record);
        return jsonStatus(true, '登录成功', $record);

    }
}