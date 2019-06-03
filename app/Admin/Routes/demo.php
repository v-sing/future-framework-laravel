<?php
/**
 * Created by PhpStorm.
 * Author: 紫云沫雪こ
 * Email:email1946367301@163.com
 * Date: 2019/3/25 0025
 * Time: 10:31
 */

Route::get('demo', 'DemoController@index');
Route::get('database', 'DemoController@database');
Route::get('demo/logs', 'DemoController@logs');

Route::get('quchong','DemoController@quchong');