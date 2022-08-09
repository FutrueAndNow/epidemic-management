<?php
declare (strict_types = 1);

namespace app\admin\controller;

use app\admin\model\tripreportinfo;
use app\BaseController;
use think\Request;

class Tripreport extends BaseController
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
        $model = new tripreportinfo();
        $result = $model->where($where)->paginate([
            'query' => $this->request->param('page'), //url额外参数
            'fragment' => '', //url锚点
            'var_page' => 'page', //分页变量
            'list_rows' => $nums, //每页数量
        ]);
        return json([
            'code' => 200,
            'message' => '数据获取成功',
            'name' => $name,
            'data' => $result
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
    public function save(Request $request)
    {
        //
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
        $record = (new tripreportinfo())->where('id', '=', $id)->find();
        if (empty($record)) {
            return json([
                'code' => 400,
                'message' => '查找不到该个人数据',
                'data' => []
            ]);
        }
        $data = $this->request->put();
        $new_data['temperature'] = $data['temperature'];
        (int) $new_data['from_address'] = $data['from_address'];
        $new_data['address'] = $data['address'];
        $new_data['symptom'] = $data['symptom'];
        (int) $new_data['is_disease'] = $data['is_disease'];
        $new_data['is_covid'] = $data['is_covid'];
        (int) $new_data['is_higharea'] = $data['is_higharea'];
        (int) $new_data['is_touch'] = $data['is_touch'];
        $new_data['update_time'] =date('Y-m-d H:i:s');
        if ($record->save($new_data)){
            return json([
                'code' => 200,
                'message' => '修改成功',
                'data' => $record
            ]);
        }
        return json([
            'code' => 400,
            'message' => '修改失败',
            'data' => $record
        ]);
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
