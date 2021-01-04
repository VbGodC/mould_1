<?php
/*
 * @Author: your name
 * @Date: 2021-01-04 09:00:19
 * @LastEditTime: 2021-01-04 16:51:04
 * @LastEditors: liutq
 * @Description: In User Settings Edit
 * @FilePath: \tmesd:\phpStudy\PHPTutorial\WWW\mould_1\application\adminapi\controller\Index.php
 */

namespace app\adminapi\controller;

class Index extends BaseApi
{
    public function index()
    {
        echo encrypt_password('123456');
        // 测试Token工具类
        $token = \tools\jwt\Token::getToken(100);
        dump($token);
        // 解析token得到的用户id
        $user_id = \tools\jwt\Token::getUserId($token);
        dump($user_id);
        // 测试响应方法
        // $this->response();
        // $this->response(200,'success',['id'=>100,'name'=>'cwb']);
        // $this->response(400,'参数错误');
        // die();
        //测试数据库配置
        // $goods = \think\Db::table('sp_user')->find();
        // dump($goods);
        // die();
        // return 'hello';
    }
}
