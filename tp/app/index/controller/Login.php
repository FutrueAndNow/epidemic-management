<?php


namespace app\index\controller;


use app\index\model\stuinfo;

class Login
{
    protected $appid = 'wx8753acafdfe099bb';
    protected $appsecret = '8735be62013b0f64e2e4f0a7e64fc24c';

    public function getOpenidByCode($code)
    {
        //缓存access_token  open_id
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid=" . $this->appid . "&secret=" . $this->appsecret . "&js_code=" . $code . "&grant_type=authorization_code";
        $weixin = file_get_contents($url);//通过code换取网页授权access_token
        $jsondecode = json_decode($weixin, true); //对JSON格式的字符串进行编码
        $openid = $jsondecode['openid'];//输出openid
        return $openid;
    }

    public function Stulogin($code,$invite_openid = '')
    {
        $openId = $this->getOpenidByCode($code);
        $model = new stuinfo();
        $record = $model->where('openid', '=', $openId)->find();

        // 如果数据库中没有带有openid的数据即新增一条
        if (empty($record)) {
            $data['openid'] = $openId;
            $data['password'] = password_hash('123456', PASSWORD_DEFAULT);
            $data['in_school_status'] = 1;
            $data['create_time'] = date('Y-m-d H:i:s');
            $data['update_time'] = date('Y-m-d H:i:s');
            $flag = $model->save($data);
            if ($flag) {
                if (!empty($invite_openid)){
                    $in_openid = (new stuinfo())->where('openid','=',$invite_openid)->find();
                    if (!empty($in_openid)){
                        Db::name('pointsinfo')->save(['uid'=>$in_openid['uid'],'point'=>+10]);
                    }
                }
                $token['token'] = signToken($openId);
                return jsonStatus(true, '首次登录成功。请完善数据', $token);
            } else {
                return jsonStatus(false, '数据出现错误。无法保存');
            }
        }
        $record['token'] = signToken($openId);
        if (empty($record['faculty_id']) || empty($record['classnumber']) || empty($record['uid']) || empty($record['name']) || empty($record['grade'])) {
            return jsonStatus(true, '登陆成功。但是未完善数据。请尽快完善', ['token' => $record['token']]);
        }
        return jsonStatus(true, '登陆成功', $record);


    }
}