<?php
declare (strict_types = 1);

namespace app\admin\controller;

use app\admin\model\pointruleinfo;
use app\BaseController;
use think\Request;

class Pointrule extends BaseController
{
    public function findall(){
        $model = new pointruleinfo();
        $result = $model->select();
        return json([
            'code'=>200,
            'message'=>'数据获取成功',
            'data'=>$result
        ]);
    }

    public function edit () {
        $check_days = $this->request->put('check_days');
        $point = $this->request->put('point');
        if (empty($check_days) || empty($point)){
            return json([
                'code'=>400,
                'message'=>'未设置修改的天数'
            ]);
        }
        $model = new pointruleinfo();
        $record = $model->where('check_days','=',$check_days)->find();
        if (empty($record)){
            return json([
                'code'=>400,
                'message'=>'查询不到修改的数据'
            ]);
        }
        $record['point_num'] = $point;
        if ($record->save()){
            return json([
                'code'=>200,
                'message'=>'修改成功',
                'data'=>$record
            ]);
        }
    }
}
