<?php
declare (strict_types = 1);

namespace app\index\controller;

use app\BaseController;
use app\index\middleware\compareToken;
use app\index\model\pointsinfo;
use app\index\model\stuinfo;
use think\Request;

class Student extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $model = new stuinfo();
        return json([
            'data'=>$model->select()
        ]);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save()
    {
        $openid = $this->openid;
        $data = $this->request->post();
        if (empty($data['faculty_id']) || empty($data['classnumber']) || empty($data['uid']) || empty($data['name']) || empty($data['grade'])) {
            return json([
                'code'=>400,
                'message'=>'数据填写不完善'
            ]);
        }
        $new_data['faculty_id'] = $data['faculty_id'];
        $new_data['classnumber'] = $data['classnumber'];
        $new_data['uid'] = $data['uid'];
        $new_data['name'] = $data['name'];
        $new_data['grade'] = $data['grade'];
        $model = new stuinfo();
        $record = $model->where('openid','=',$openid)->find();
        if ($record->save($new_data)){
            $point = new pointsinfo();
            $point_data['stuname']= $new_data['name'];
            $point_data['uid']= $new_data['uid'];
            $point_data['point'] = 0;
            $point_data['days'] = 0;
            $point_data['none'] = 0;
            $point_data['create_time'] = date('Y-m-d H:i:s');
            $point_data['update_time'] = date('Y-m-d H:i:s');
            $point->save($point_data);
            return json([
                'code'=>200,
                'message'=>'数据保存成功',
                'data'=>$new_data
            ]);
        }else{
            return json([
                'code'=>400,
                'message'=>'数据保存失败',
            ]);
        }
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
