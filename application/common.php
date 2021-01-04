<?php
/*
 * @Description: 
 * @Author: liutq
 * @Date: 2021-01-04 08:47:48
 * @LastEditTime: 2021-01-04 16:50:50
 * @LastEditors: liutq
 * @Reference: 
 */
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
if (!function_exists('encrypt_password')) {
    // 密码加密函数
    function encrypt_password($password)
    {
        $salt = 'asdfsfasa';
        return md5($salt . md5($password));
    }
}
