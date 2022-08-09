<?php


namespace app\index\controller;


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
        $jwt = JWT::decode($token,new Key('mini_key','HS256'));

        if($jwt){
            $this->openid = $jwt->data->openid;
        };
    }

}