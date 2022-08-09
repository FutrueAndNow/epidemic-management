<?php


namespace app\admin\controller;


use app\admin\model\leaveschoolinfo;
use app\BaseController;

class LeaveChangeStatus extends BaseController
{
    public function index()
    {
        $model = new leaveschoolinfo();
        $result = $model->where('leave_status','<>',0)->select();
        return jsonStatus(true,'数据获取成功',$result);
    }
}