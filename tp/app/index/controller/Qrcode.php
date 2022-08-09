<?php


namespace app\index\controller;


class Qrcode extends Base
{
    protected $appid = 'wx8753acafdfe099bb';
    protected $secret = '8735be62013b0f64e2e4f0a7e64fc24c';
    public function getAccess_token(){
        $get_url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$this->appid.'&secret='.$this->secret;
        $data = file_get_contents($get_url);
        $data = json_decode($data,true);
        return $data['access_token'];
    }

    public function getQrcode(){
        $data['scene'] = $this->openid;
//        $data['scene'] = '768676';
//        dump($data);
        $scene = json_encode($data);
        $access_token = $this->getAccess_token();
        $url = 'https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=' . $access_token;
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'POST');
        curl_setopt($ch,CURLOPT_POSTFIELDS,$scene);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,$url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $tmpInfo = curl_exec($ch);

        if (curl_error($ch)){
            return curl_error($ch);
        }
        $path = public_path() . 'static/image/wecode.png';
        return  jsonStatus(true,'图片生成成功',['url'=>'static/image/wecode.png']);
        $ret = file_put_contents($path,$tmpInfo);
        if ($ret){
            return  11;
        } else{
            return 22;
        }
    }
}