<?php
// 这是系统自动生成的公共文件
function signAdminToken($data)
{
    $key = 'admin_key';
    $payload = [
        'iss' => 'http://example.org',	//签发者 可以为空
        'aud' => 'http://example.com', 	//面象的用户，可以为空
        'iat' => time(), 				//签发时间
        'nbf' => time(),  				//在什么时候jwt开始生效
//        "exp" => time() + 200, 			//token 过期时间
        //记录的userid的信息，这里是自已添加上去的，如果有其它信息，可以再添加数组的键值对
        'data'=>$data
    ];
    //  print_r($token);
    return \Firebase\JWT\JWT::encode($payload,$key,'HS256');
}