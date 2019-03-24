<?php
/**
 * Created by PhpStorm.
 * Author: 紫云沫雪こ
 * Email:email1946367301@163.com
 * Date: 2019/3/22 0022
 * Time: 10:41
 */
return [

    'name' => 'future-framework',

    'logo' => '<b>future</b>framework',

    'logo-mini' => '<b>fu</b>',

    'title' => 'Admin',

    'route' => [
        'prefix' => env('ADMIN_ROUTE_PREFIX', 'admin'),

        'namespace' => 'App\\Admin\\Controllers',

        'middleware' => ['web', 'admin'],
    ],

    'auth'      => [

        'controller' => App\Admin\Controllers\AuthController::class,

        'guards' => [
            'admin' => [
                'driver'   => 'session',
                'provider' => 'admin',
            ],
        ],

        'providers' => [
            'admin' => [
                'driver' => 'eloquent',
                'model'  => \Future\Admin\Auth\Database\Admin::class,
            ],
        ],

        // Add "remember me" to login form
        'remember'  => true,
    ],
    'directory' => app_path('Admin'),

    'https' => env('ADMIN_HTTPS', false),

    'database' => [
        'connection'              => '',
        'admin_table'             => 'admin',
        'admin_log_table'         => 'admin_log',
        'attachment_table'        => 'attachment',
        'auth_group_table'        => 'auth_group',
        'auth_group_access_table' => 'auth_group_access',
        'auth_rule_table'         => 'auth_rule',
        'category_table'          => 'category',
        'config_table'            => 'config',
        'ems_table'               => 'ems',
        'sms_table'               => 'sms',
        'test_table'              => 'test',
        'user_table'              => 'user',
        'user_group_table'        => 'user_group',
        'user_money_log_table'    => 'user_money_log',
        'user_rule_table'         => 'user_rule',
        'user_score_log_table'    => 'user_score_log',
        'user_token_table'        => 'user_token',
        'version_table'           => 'version',

        'admin_model'             => \Future\Admin\Auth\Database\Admin::class,
        'admin_log_model'         => \Future\Admin\Auth\Database\AdminLog::class,
        'attachment_model'        => \Future\Admin\Auth\Database\attachment::class,
        'auth_group_model'        => \Future\Admin\Auth\Database\AuthGroup::class,
        'auth_group_access_model' => \Future\Admin\Auth\Database\AuthGroupAccess::class,
        'auth_rule_model'         => \Future\Admin\Auth\Database\AuthRule::class,
        'category_model'          => \Future\Admin\Auth\Database\Category::class,
        'config_model'            => \Future\Admin\Auth\Database\Config::class,
        'ems_model'               => \Future\Admin\Auth\Database\Ems::class,
        'sms_model'               => \Future\Admin\Auth\Database\Sms::class,
        'test_model'              => \Future\Admin\Auth\Database\Test::class,
        'user_model'              => \Future\Admin\Auth\Database\User::class,
        'user_group_model'        => \Future\Admin\Auth\Database\UserGroup::class,
        'user_money_log_model'    => \Future\Admin\Auth\Database\UserMoneyLog::class,
        'user_rule_model'         => \Future\Admin\Auth\Database\UserRule::class,
        'user_score_log_model'    => \Future\Admin\Auth\Database\UserScoreLog::class,
        'user_token_model'        => \Future\Admin\Auth\Database\UserToken::class,
        'version_model'           => \Future\Admin\Auth\Database\Version::class,

    ],

    'upload' => [

        // Disk in `config/filesystem.php`.
        'disk'      => 'admin',

        // Image and file upload path under the disk above.
        'directory' => [
            'image' => 'images',
            'file'  => 'files',
        ],
    ],
];