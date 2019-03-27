<?php
/**
 * Created by PhpStorm.
 * Author: 紫云沫雪こ
 * Email:email1946367301@163.com
 * Date: 2019/3/27 0027
 * Time: 15:35
 */

Route::get('/', 'IndexController@index');
Route::get('index', 'IndexController@index');
Route::get('index/index', 'IndexController@index');
Route::any('login','IndexController@login');
