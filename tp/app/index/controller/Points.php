<?php
declare (strict_types=1);

namespace app\index\controller;

use app\BaseController;
use app\index\model\pointruleinfo;
use app\index\model\pointsinfo;
use think\Request;

class Points extends BaseController
{
    public function index (){
        $uid = $this->request->get('uid');
        $model = new pointsinfo();
        $record = $model->where('uid', '=', $uid)->find();
        return jsonStatus(true,'积分数据获取成功',$record);
    }

    public function sign_in()
    {
        // 接受uid
        $uid = $this->request->put('uid');
        if (empty($uid)) {
            return json([
                'code' => 400,
                'message' => '未获取到uid'
            ]);
        }

        // 判断是否可以签到 && 签到天数+1
        $model = new pointsinfo();
        $record = $model->where('uid', '=', $uid)->find();
        if (date('md')-date('md',strtotime($record['update_time'])) == 0) {
            return json([
                'code' => 200,
                'message'=>'你今天已经签到过了哦'
            ]);
        }
        $record['days'] += 1;

        // 判断加多少积分
        $check_point = (new pointruleinfo())->where('check_days', '=', $record['days'])->find();
        if (empty($check_point)) {
            $record['point'] += 7;
        } else {
            $record['point'] += $check_point['point_num'];
        }

        //保存签到天数和积分
        if ($record->save()) {
            return json([
                'code' => 200,
                'message' => '签到成功',
                'data' => $record
            ]);
        }
        return json([
            'code' => 400,
            'message' => '签到失败'
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
     * @param \think\Request $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param int $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param int $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param \think\Request $request
     * @param int $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param int $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
