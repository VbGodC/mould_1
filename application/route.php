<?php
/*
 * @Description: 
 * @Author: liutq
 * @Date: 2021-01-04 08:47:48
 * @LastEditTime: 2021-01-04 17:53:45
 * @LastEditors: liutq
 * @Reference: 
 */

use think\Route;

//后台接口域名路由 adminapi
Route::domain('adminapi', function () {
	//adminapi 模块首页路由
	Route::get('/', 'adminapi/index/index');
	//定义 域名下的其他路由
	//比如 以后定义路由   http://adminapi.cwb.com/goods  访问 adminapi模块Goods控制器index方法
	//Route::resource('goods','adminapi/goods');
	// 获取验证码
	Route::get('captcha/:id', "\\think\\captcha\\CaptchaController@index"); //访问图片需要
	Route::get('captcha', 'adminapi/login/captcha');
	// 登录接口
	Route::post('login', 'adminapi/login/login');
	// 退出接口
	Route::get('logout', 'adminapi/login/logout');
});
