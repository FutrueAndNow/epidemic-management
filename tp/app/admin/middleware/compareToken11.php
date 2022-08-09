<?php
declare (strict_types = 1);

namespace app\admin\middleware;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class compareToken11
{
    /**
     * 处理请求
     *
     * @param \think\Request $request
     * @param \Closure       $next
     * @return Response
     */
    public function handle($request, \Closure $next)
    {

        $token = request()->header('Authorization');

        if (!isset($token) || empty($token)) {
            return json(['code'=>400,'message'=>'token不存在']);
        }
        $jwt = JWT::decode($token,new Key('admin_key','HS256'));

        if($jwt){
//            dump($jwt);
            return $next($request);
        };
    }
}
