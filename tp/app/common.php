<?php
// 应用公共文件
function jsonStatus($flag,$message,$data = null){
    if ($flag){
        return json([
            'code'=>200,
            'message'=>$message,
            'data'=>$data
        ]);
    }
    return json([
        'code'=>400,
        'message'=>$message,
        'data'=>$data
    ]);
}