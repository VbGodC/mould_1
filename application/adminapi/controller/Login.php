<?php
/*
 * @Description: 
 * @Author: liutq
 * @Date: 2021-01-04 13:40:38
 * @LastEditTime: 2021-01-04 17:58:58
 * @LastEditors: liutq
 * @Reference: 
 */

namespace app\adminapi\controller;

class Login extends BaseApi
{
    /**
     * 验证码接口
     * @description: 
     * @param {*}
     * @return {*}
     */
    public function captcha()
    {
        // 验证码唯一标识
        $uniqid = uniqid(mt_rand(100000, 999999));
        // 生成验证码地址
        $src =  captcha_src($uniqid);
        // 返回数据
        $res = [
            'src' => $src,
            'uniqid' => $uniqid
        ];
        $this->ok($res);
    }

    /**
     * 登录接口
     * @description: 
     * @param {*}
     * @return {*}
     */
    public function login()
    {
        // 接收参数
        $params = input();
        // 参数检测(表单验证)
        $validate = $this->validate($params, [
            'username|用户名' => 'require',
            'password|密码' => 'require',
            'code|验证码' => 'require',
            // 'code|验证码' => 'require|captcha:'.$params['uniqid'], //验证码自动校验
            'uniqid|验证码标识' => 'require'
        ]);
        if ($validate !== true) {
            // 参数验证失败
            $this->fail($validate, 401);
        }
        // 检验验证码 手动
        // 从缓存中根据uniqid获取session_id，设置session_id，用于验证码校验
        session_id(cache('session_id_' . $params['uniqid']));
        if (!captcha_check($params['code'], $params['uniqid'])) {
            // 验证码错误
            $this->fail('验证码错误', 402);
        }
        // 查询用户表进行认证
        $password = encrypt_password($params['password']);
        $info = \app\common\model\Admin::where('username', $params['username'])->where('password', $password)->find();
        if (empty($info)) {
            // 用户名或者密码错误
            $this->fail('用户名或者密码错误', 403);
        }
        // 生成token令牌
        $token = \tools\jwt\Token::getToken($info['id']);
        // 返回数据
        $data = [
            'token' => $token,
            'user_id' => $info['id'],
            'username' => $info['username'],
            'nickname' => $info['nickname'],
            'email' => $info['email']
        ];
        $this->ok($data);
    }
    /**
     * 退出
     * @description: 
     * @param {*}
     * @return {*}
     */
    public function logout()
    {
        // 记录token为已退出
        // 获取当前请求中的token
        $token = \tools\jwt\Token::getRequestToken();
        // 从缓存中取出 注销的token数组
        $delete_token = cache('delete_token') ?: [];
        // 将当前的token加入到数组中['dssfd','dsfds']
        $delete_token[] = $token;
        // 将新的数组 重新存到缓存中 缓存1天
        cache('delete_token', $delete_token, 86400);
        // 返回数据
    }
}
