<?php
declare (strict_types = 1);

namespace app\index\middleware;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class compareToken
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
//        dump($header);
        if (!isset($token) || empty($token)) {
            return json(['code'=>400,'message'=>'token不存在']);
        }
        $jwt = JWT::decode($token,new Key('mini_key','HS256'));

        if($jwt){
            return $next($request);
        };
    }


}
