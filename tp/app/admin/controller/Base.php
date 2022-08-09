<?php


namespace app\admin\controller;


use app\BaseController;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use think\App;

class Base extends BaseController
{
    public function __construct(App $app)
    {
        parent::__construct($app);
        $token = request()->header('Authorization');
        $jwt = JWT::decode($token,new Key('admin_key','HS256'));

        if($jwt){
//            dump($jwt);
            $this->id = $jwt->data->id;
            $this->powerid = $jwt->data->powerid;
        };
    }
}