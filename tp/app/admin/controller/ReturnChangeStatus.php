<?php


namespace app\admin\controller;


use app\admin\model\returnschoolinfo;
use app\BaseController;

class ReturnChangeStatus extends BaseController
{
    public function index()
    {
        $model = new returnschoolinfo();
        $result = $model->where('leave_status','<>',0)->select();
        return  jsonStatus(true,'数据获取成功',$result);
    }
}