<?php
declare (strict_types = 1);

namespace app\admin\controller;

use app\admin\model\pointsinfo;
use app\BaseController;
use think\Request;

class Points extends BaseController
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function findall()
    {
        $nums = $this->request->get('page_nums');
        if (empty($nums)){
            $nums = 15;
        }
        $name = $this->request->get('stuname');
        $where = [];
        if (!empty($name)) {
            array_push($where, ['stuname', '=', $name]);
        }
        $model = new pointsinfo();
        $result = $model->where($where)->paginate([
            'query' => $this->request->param('page'), //url额外参数
            'fragment' => '', //url锚点
            'var_page' => 'page', //分页变量
            'list_rows' => $nums, //每页数量
        ]);
        return json([
            'code' => 200,
            'message' => '数据获取成功',
            'data' => $result
        ]);
    }



    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit()
    {
        $id = $this->request->route('id');
        if (empty($id)){
            return json([
                'code' => 400,
                'message' => '未获取数据id',
                'data' => []
            ]);
        }
        $record = (new pointsinfo())->where('id', '=', $id)->find();
        if (empty($record)) {
            return json([
                'code' => 400,
                'message' => '查找不到该数据',
                'data' => []
            ]);
        }
        $data = $this->request->put();
        $new_data['point'] = $data['point'];
        $new_data['update_time'] =date('Y-m-d H:i:s');
        $changepoint = $new_data['point'] - $record['point'];
        if ($record->save($new_data)){
            $record['changepoint'] = $changepoint;
            $record['remark'] = '管理员修改';
            return json([
                'code' => 200,
                'message' => '修改成功',
                'add_point_log'=>Pointlog::add($record),
                'data' => $record
            ]);
        }
        return json([
            'code' => 400,
            'message' => '修改失败',
            'data' => $record
        ]);
    }

}
