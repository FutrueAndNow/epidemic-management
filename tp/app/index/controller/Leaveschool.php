<?php


namespace app\index\controller;


use app\BaseController;
use app\index\model\leaveschoolinfo;
use app\index\model\returnschoolinfo;

class Leaveschool extends BaseController
{
    public function index()
    {
        $uid = $this->request->get('uid');
        if (empty($uid)){
            return jsonStatus(false,'未获取到uid');
        }
        $model = new leaveschoolinfo();
        $record = $model->where([
            ['uid','=',$uid],
            ['leave_status','=',0]
        ])->find();
        if (!empty($record)){
            return jsonStatus(false,'已提交过出校申请。请耐心等候审批',$record);
        }
        $oldData = (new leaveschoolinfo())->where([
            ['uid','=',$uid],
            ['leave_status','<>',0]
        ])->order('id desc')->find();
        return jsonStatus(true,'您未提交过申请出校申请。可以申请出校',$oldData);
    }
    public function add ()
    {
        $data = $this->request->post();
        $model = new leaveschoolinfo();
        $new_data['stuname'] = $data['stuname'];
        $new_data['uid'] = $data['uid'];
        $new_data['leave_status'] = $data['leave_status'];
        $new_data['remark'] = $data['remark'];
        $new_data['star_time'] = $data['star_time'];
        $new_data['end_time'] = $data['end_time'];
        $new_data['create_time'] = date('Y-m-d H:i:s');
        $new_data['update_time'] = date('Y-m-d H:i:s');
        $record = $model->where('uid','=',$new_data['uid'])->order('id desc')->find();
        if ($record['leave_status'] == 0){
            return jsonStatus(false,'已有提交过的申请。无法二次提交申请');
        }
        if ($model->save($new_data)){
            return json([
                'code'=>200,
                'message'=>'数据添加成功',
                'data'=>$new_data
            ]);
        }
    }
}