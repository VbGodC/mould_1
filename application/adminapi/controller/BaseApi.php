<?php
/*
 * @Author: your name
 * @Date: 2021-01-04 09:41:58
 * @LastEditTime: 2021-01-04 18:11:55
 * @LastEditors: liutq
 * @Description: In User Settings Edit
 * @FilePath: \tmesd:\phpStudy\PHPTutorial\WWW\mould_1\application\adminapi\controller\BaseApi.php
 */

namespace app\adminapi\controller;

use think\Controller;

class BaseApi extends Controller
{
    //无需登录的请求数组
    protected $no_login = ['login/captcha', 'login/login'];
    // 控制器的初始化方法(和 直接写构造方法 二选一)
    protected function _initialize()
    {
        parent::_initialize();
        // 初始化代码
        // 处理跨域请求
        //允许的源域名
        header("Access-Control-Allow-Origin: *");
        //允许的请求头信息
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
        //允许的请求类型
        header('Access-Control-Allow-Methods: GET, POST, PUT,DELETE,OPTIONS,PATCH');

        try {
            //登录检测
            //获取当前请求的控制器方法名称
            $path = strtolower($this->request->controller()) . '/' . $this->request->action();
            if (!in_array($path, $this->no_login)) {
                //需要做登录检测
                $user_id = \tools\jwt\Token::getUserId();
                if (empty($user_id)) {
                    $this->fail('token验证失败', 403);
                }
                //将得到的用户id 放到请求信息中去  方便后续使用
                $this->request->get('user_id', $user_id);
                $this->request->post('user_id', $user_id);
            }
        } catch (\Exception $e) {
            //token解析失败
            $this->fail('token解析失败', 404);
        }
    }
    /**
     * 通用的响应
     * @description: 
     * @param {*} $code 错误码
     * @param {*} $msg 错误信息
     * @param {*} $data 返回数据
     * @return {*}
     */
    protected function response($code = 200, $msg = 'success', $data = [])
    {
        $res = [
            'code' => $code,
            'msg' => $msg,
            'data' => $data
        ];
        // 原生php寫法
        echo json_encode($res, JSON_UNESCAPED_UNICODE);die();
        // 框架写法
        // return json($res)->send();
    }
    /**
     * 成功的响应
     * @description: 
     * @param {*} $data 返回数据
     * @param {*} $code 错误码
     * @param {*} $msg 错误信息
     * @return {*}
     */
    protected function ok($data = [], $code = 200, $msg = 'success')
    {
        $this->response($code, $msg, $data);
    }
    /**
     * 失败的响应
     * @description: 
     * @param {*} $msg 错误信息
     * @param {*} $code 错误码
     * @param {*} $data 返回数据
     * @return {*}
     */
    protected function fail($msg, $code = 500, $data = [])
    {
        $this->response($code, $msg, $data);
    }
}
