<?php


namespace app\admin\controller;


use app\admin\model\pointloginfo;
use app\BaseController;
use http\Client\Curl\User;
use think\facade\Db;

class Pointlog extends BaseController
{
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
        array_push($where,['none','=',1]);
        $model = new pointloginfo();
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

    public static function add($data)
    {
        $model = new pointloginfo();
        $new_data['stuname'] = $data['stuname'];
        $new_data['changepoint'] = $data['changepoint'];
        $new_data['nowpoint'] = $data['point'];
        $new_data['remark'] = $data['remark'];
        $new_data['create_time'] = date('Y-m-d H:i:s');
        $new_data['none'] = 1;
        if ($model->insert($new_data)){
            return 'success';
        }
        return 'error';
    }

    public function clear()
    {
        $data = ['none'=>0];
        $delete = Db::table('pointloginfo')->where('none',1)->update($data);
        if ($delete){
            return json([
                'code'=>200,
                'message'=>'删除成功',
            ]);
        }
        return json([
            'code'=>400,
            'message'=>'删除失败',
        ]);
    }
}