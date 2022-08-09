<?php
declare (strict_types = 1);

namespace app\admin\controller;

use app\admin\model\returnschoolinfo;
use app\BaseController;
use think\Request;

class Returnschool extends BaseController
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
        array_push($where,['leave_status','=',0]);
        $model = new returnschoolinfo();
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
        $record = (new returnschoolinfo())->where('id', '=', $id)->find();
        if (empty($record)) {
            return json([
                'code' => 400,
                'message' => '查找不到该数据',
                'data' => []
            ]);
        }
        $data = $this->request->put();
        $new_data['leave_status'] = $data['leave_status'];
        $new_data['update_time'] =date('Y-m-d H:i:s');
        $new_data['explain'] = $data['explain'];
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
