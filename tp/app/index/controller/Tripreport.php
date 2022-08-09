<?php


namespace app\index\controller;


use app\BaseController;
use app\index\model\tripreportinfo;
use think\facade\Filesystem;

class Tripreport extends BaseController
{
    public function add () {
        $data = $this->request->post();
        $model = new tripreportinfo();
        $new_data = [];
        $new_data['uid'] = $data['uid'];
        $new_data['stuname'] = $data['stuname'];
        $new_data['temperature'] = $data['temperature'];
        (int) $new_data['from_address'] = $data['from_address'];
        $new_data['address'] = $data['address'];
        $new_data['symptom'] = $data['symptom'];
        (int) $new_data['is_disease'] = $data['is_disease'];
        $new_data['is_covid'] = $data['is_covid'];
        (int) $new_data['is_higharea'] = $data['is_higharea'];
        (int) $new_data['is_touch'] = $data['is_touch'];
        $new_data['health_code'] = $data['health_code'];
        $new_data['trip_code'] = $data['trip_code'];
        $new_data['create_time'] = date('Y-m-d H:i:s');
        $new_data['update_time'] = date('Y-m-d H:i:s');
        $record = $model->where('uid','=',$new_data['uid'])->order('id desc')->find();
        if ($record){
            if (date('md') - date('md',strtotime($record['create_time'])) == 0){
                return jsonStatus(false,'今日无法二次报备');
            }
        }
        if ($model->save($new_data)){
            return json([
                'code'=>200,
                'message'=>'数据添加成功',
                'data'=>$new_data
            ]);
        }

    }
    public function health_img(){
        $fileimg = request()->file('imgname');
        if($fileimg)
        {
            //图片会被保存到public目录下的storage目录下的 image目录下
            $savename = Filesystem::disk('public')->putFile( 'health', $fileimg);
            //savename 返回了图片保存的路径及名称
            if($savename)
            {
                return  $savename;
            }else{
                return  '上传失败';
            }
        }else{
            return '未获取到图片对象！';
        }
    }
}