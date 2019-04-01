<?php

/**
 * Created by PhpStorm.
 * Author: 紫云沫雪こ
 * Email:email1946367301@163.com
 * Date: 2019/3/21 0021
 * Time: 16:47
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


class CreateAdminTables extends Migration
{
    /**
     * 创建后台基础表
     */
    public function up()
    {
        $connection = config('admin.database.connection') ?: config('database.default');
        Schema::connection($connection)->create(config('admin.database.admin_table'), function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->string('username', 20)->comment('用户名');
            $table->string('nickname', 50)->comment('昵称');
            $table->string('password', 32)->comment('密码');
            $table->string('salt', 30)->comment('密码盐');
            $table->string('avatar', 100)->comment('头像');
            $table->string('email', 100)->comment('电子邮箱');
            $table->integer('loginfailure', false, false)->comment('失败次数');
            $table->integer('logintime', false, false)->comment('登录时间');
            $table->string('token', 59)->comment('Session标识');
            $table->string('status', 30)->default('normal')->comment('状态');
            $table->integer('updated_at',false,false)->comment('更新时间');
            $table->integer('created_at',false,false)->comment('添加时间');
            
        });
        Schema::connection($connection)->create(config('admin.database.admin_log_table'), function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->integer('admin_id', false, false)->comment('管理员ID');
            $table->string('username', 30)->comment('管理员名字');
            $table->string('url', 1500)->comment('操作页面');
            $table->string('title', 100)->comment('日志标题');
            $table->text('content')->comment('内容');
            $table->string('ip', 50)->comment('IP');
            $table->string('useragent', 255)->comment('User-Agent');
            $table->integer('updated_at',false,false)->comment('更新时间');
            $table->integer('created_at',false,false)->comment('添加时间');


        });
        Schema::connection($connection)->create(config('admin.database.attachment_table'), function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->integer('admin_id', false, false)->comment('管理员ID');
            $table->integer('user_id', false, false)->comment('会员ID');
            $table->string('url', 255)->comment('物理路径');
            $table->string('imagewidth', 30)->comment('宽度');
            $table->string('imageheight', 30)->comment('高度');
            $table->string('imagetype', 30)->comment('图片类型');
            $table->integer('imageframes', false, false)->comment('图片帧数');
            $table->integer('filesize', false, false)->comment('文件大小');
            $table->string('mimetype', 100)->comment('mime类型');
            $table->string('extparam', 255)->nullable()->comment('透传数据');
            $table->integer('uploadtime', false, false)->comment('上传时间');
            $table->string('storage', 100)->comment('存储位置');
            $table->string('sha1', 40)->comment('文件 sha1编码');
            $table->integer('updated_at',false,false)->comment('更新时间');
            $table->integer('created_at',false,false)->comment('添加时间');

        });
        Schema::connection($connection)->create(config('admin.database.auth_group_table'), function (Blueprint $table) {
            $table->increments('id')->comment('');
            $table->integer('pid', false, false)->comment('父组别');
            $table->string('name', 100)->comment('组名');
            $table->text('rules')->comment('规则ID');
            $table->string('status', 30)->comment('状态');
            $table->integer('updated_at',false,false)->comment('更新时间');
            $table->integer('created_at',false,false)->comment('添加时间');

        });
        Schema::connection($connection)->create(config('admin.database.auth_group_access_table'), function (Blueprint $table) {
            $table->integer('uid', false, false)->comment('会员ID');
            $table->integer('group_id', false, false)->comment('级别ID');
            $table->integer('updated_at',false,false)->comment('更新时间');
            $table->integer('created_at',false,false)->comment('添加时间');
        });
        Schema::connection($connection)->create(config('admin.database.auth_rule_table'), function (Blueprint $table) {
            $table->increments('id')->comment('');
            $table->enum('type', ['menu', 'file'])->comment('menu为菜单,file为权限节点');
            $table->integer('pid', false, false)->comment('父ID');
            $table->string('name', 100)->comment('规则名称');
            $table->string('title', 50)->comment('规则名称');
            $table->string('icon', 50)->comment('图标');
            $table->string('condition', 255)->comment('条件');
            $table->string('remark', 255)->comment('备注');
            $table->integer('ismenu', false, false)->comment('是否为菜单');
            $table->integer('weigh', false, false)->comment('权重');
            $table->string('status', 30)->comment('状态');
            $table->integer('updated_at',false,false)->comment('更新时间');
            $table->integer('created_at',false,false)->comment('添加时间');

        });
        Schema::connection($connection)->create(config('admin.database.category_table'), function (Blueprint $table) {
            $table->increments('id')->comment('');
            $table->integer('pid', false, false)->comment('父ID');
            $table->string('type', 30)->comment('栏目类型');
            $table->string('name', 30)->comment('');
            $table->string('nickname', 50)->comment('');
            $table->string('flag', 20)->comment('');
            $table->string('image', 100)->comment('图片');
            $table->string('keywords', 255)->comment('关键字');
            $table->string('description', 255)->comment('描述');
            $table->string('diyname', 30)->comment('自定义名称');
            $table->integer('weigh', false, false)->comment('权重');
            $table->string('status', 30)->comment('状态');
            $table->integer('updated_at',false,false)->comment('更新时间');
            $table->integer('created_at',false,false)->comment('添加时间');

        });
        Schema::connection($connection)->create(config('admin.database.config_table'), function (Blueprint $table) {
            $table->increments('id')->comment('');
            $table->string('name', 30)->comment('变量名');
            $table->string('group', 30)->comment('分组');
            $table->string('title', 100)->comment('变量标题');
            $table->string('tip', 100)->nullable(null)->comment('变量描述');
            $table->string('type', 30)->comment('类型:string,text,int,bool,array,datetime,date,file');
            $table->text('value')->comment('变量值');
            $table->text('content')->comment('变量字典数据');
            $table->string('rule', 100)->nullable()->comment('验证规则');
            $table->string('extend', 255)->nullable()->comment('扩展属性');
            $table->integer('updated_at',false,false)->comment('更新时间');
            $table->integer('created_at',false,false)->comment('添加时间');

        });
        Schema::connection($connection)->create(config('admin.database.ems_table'), function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->string('event', 30)->comment('事件');
            $table->string('email', 100)->comment('邮箱');
            $table->string('code', 10)->comment('验证码');
            $table->integer('times', false, false)->comment('验证次数');
            $table->string('ip', 30)->comment('IP');
            $table->integer('updated_at',false,false)->comment('更新时间');
            $table->integer('created_at',false,false)->comment('添加时间');

        });
        Schema::connection($connection)->create(config('admin.database.sms_table'), function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->string('event', 30)->comment('事件');
            $table->string('mobile', 20)->comment('手机号');
            $table->string('code', 10)->comment('验证码');
            $table->integer('times', false, false)->comment('验证次数');
            $table->string('ip', 30)->comment('IP');
            $table->integer('updated_at',false,false)->comment('更新时间');
            $table->integer('created_at',false,false)->comment('添加时间');

        });
        Schema::connection($connection)->create(config('admin.database.test_table'), function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->integer('admin_id', false, false)->comment('管理员ID');
            $table->integer('category_id', false, false)->comment('分类ID(单选)');
            $table->string('category_ids', 100)->comment('分类ID(多选)');
            $table->string('week', 20)->comment('星期(单选):monday=星期一,tuesday=星期二,wednesday=星期三');
            $table->string('flag', 20)->comment('标志(多选):hot=热门,index=首页,recommend=推荐');
            $table->string('genderdata', 20)->comment('性别(单选):male=男,female=女');
            $table->string('hobbydata', 20)->comment('爱好(多选):music=音乐,reading=读书,swimming=游泳');
            $table->string('title', 50)->comment('标题');
            $table->text('content')->comment('内容');
            $table->string('image', 100)->comment('图片');
            $table->string('images', 1500)->comment('图片组');
            $table->string('attachfile', 100)->comment('附件');
            $table->string('keywords', 100)->comment('关键字');
            $table->string('description', 255)->comment('描述');
            $table->string('city', 100)->comment('省市');
            $table->string('price', 10)->comment('价格');
            $table->integer('views', false, false)->comment('点击');
            $table->string('startdate', 20)->comment('开始日期');
            $table->string('activitytime', 20)->comment('活动时间(datetime)');
            $table->string('year', 4)->comment('年');
            $table->string('times', 20)->comment('时间');
            $table->integer('refreshtime', false, false)->comment('刷新时间(int)');
            $table->integer('weigh', false, false)->comment('权重');
            $table->integer('switch', false, false)->comment('开关');
            $table->string('status', 20)->comment('状态');
            $table->string('state', 0)->comment('状态值:0=禁用,1=正常,2=推荐');
            $table->integer('updated_at',false,false)->comment('更新时间');
            $table->integer('created_at',false,false)->comment('添加时间');

        });
        Schema::connection($connection)->create(config('admin.database.user_table'), function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->integer('group_id', false, false)->comment('组别ID');
            $table->string('username', 32)->comment('用户名');
            $table->string('nickname', 50)->comment('昵称');
            $table->string('password', 32)->comment('密码');
            $table->string('salt', 30)->comment('密码盐');
            $table->string('email', 100)->comment('电子邮箱');
            $table->string('mobile', 11)->comment('手机号');
            $table->string('avatar', 255)->comment('头像');
            $table->integer('level', false, false)->comment('等级');
            $table->integer('gender', false, false)->comment('性别');
            $table->string('birthday', 20)->comment('生日');
            $table->string('bio', 100)->comment('格言');
            $table->decimal('money', 10, 2)->comment('余额');
            $table->integer('score', false, false)->comment('积分');
            $table->integer('successions', false, false)->comment('连续登录天数');
            $table->integer('maxsuccessions', false, false)->comment('最大连续登录天数');
            $table->integer('prevtime', false, false)->comment('上次登录时间');
            $table->integer('logintime', false, false)->comment('登录时间');
            $table->string('loginip', 50)->comment('登录IP');
            $table->integer('loginfailure', false, false)->comment('失败次数');
            $table->string('joinip', 50)->comment('加入IP');
            $table->integer('jointime', false, false)->comment('加入时间');
            $table->string('token', 50)->comment('Token');
            $table->string('status', 30)->comment('状态');
            $table->string('verification', 255)->comment('验证');
            $table->integer('updated_at',false,false)->comment('更新时间');
            $table->integer('created_at',false,false)->comment('添加时间');

        });
        Schema::connection($connection)->create(config('admin.database.user_group_table'), function (Blueprint $table) {
            $table->increments('id')->comment('');
            $table->string('name', 50)->comment('组名');
            $table->text('rules')->comment('权限节点');
            $table->string('status', 20)->comment('状态');
            $table->integer('updated_at',false,false)->comment('更新时间');
            $table->integer('created_at',false,false)->comment('添加时间');

        });
        Schema::connection($connection)->create(config('admin.database.user_money_log_table'), function (Blueprint $table) {
            $table->increments('id')->comment('');
            $table->integer('user_id', false, false)->comment('会员ID');
            $table->decimal('money', 10, 2)->comment('变更余额');
            $table->decimal('before', 10, 2)->comment('变更前余额');
            $table->decimal('after', 10, 2)->comment('变更后余额');
            $table->string('memo', 255)->comment('备注');
            $table->integer('updated_at',false,false)->comment('更新时间');
            $table->integer('created_at',false,false)->comment('添加时间');

        });
        Schema::connection($connection)->create(config('admin.database.user_rule_table'), function (Blueprint $table) {
            $table->increments('id')->comment('');
            $table->integer('pid', false, false)->comment('父ID');
            $table->string('name', 50)->comment('名称');
            $table->string('title', 50)->comment('标题');
            $table->string('remark', 100)->comment('备注');
            $table->integer('ismenu', false, false)->comment('是否菜单');
            $table->integer('weigh', false, false)->comment('权重');
            $table->string('status', 20)->comment('状态');
            $table->integer('updated_at',false,false)->comment('更新时间');
            $table->integer('created_at',false,false)->comment('添加时间');

        });
        Schema::connection($connection)->create(config('admin.database.user_score_log_table'), function (Blueprint $table) {
            $table->increments('id')->comment('');
            $table->integer('user_id', false, false)->comment('会员ID');
            $table->integer('score', false, false)->comment('变更积分');
            $table->integer('before', false, false)->comment('变更前积分');
            $table->integer('after', false, false)->comment('变更后积分');
            $table->string('memo', 255)->comment('备注');
            $table->integer('updated_at',false,false)->comment('更新时间');
            $table->integer('created_at',false,false)->comment('添加时间');

        });
        Schema::connection($connection)->create(config('admin.database.user_token_table'), function (Blueprint $table) {
            $table->string('token', 50)->comment('Token');
            $table->integer('user_id', false, false)->comment('会员ID');
            $table->integer('updated_at',false,false)->comment('更新时间');
            $table->integer('created_at',false,false)->comment('添加时间');

        });
        Schema::connection($connection)->create(config('admin.database.version_table'), function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->string('oldversion', 30)->comment('旧版本号');
            $table->string('newversion', 30)->comment('新版本号');
            $table->string('packagesize', 30)->comment('包大小');
            $table->string('content', 500)->comment('升级内容');
            $table->string('downloadurl', 255)->comment('下载地址');
            $table->integer('enforce', false, false)->comment('强制更新');
            $table->integer('weigh', false, false)->comment('权重');
            $table->string('status', 30)->comment('状态');
            $table->integer('updated_at',false,false)->comment('更新时间');
            $table->integer('created_at',false,false)->comment('添加时间');

        });


    }

    protected function down()
    {
        $connection = config('admin.database.connection') ?: config('database.default');
        Schema::connection($connection)->dropIfExists(config('admin.database.admin_table'));
        Schema::connection($connection)->dropIfExists(config('admin.database.admin_log_table'));
        Schema::connection($connection)->dropIfExists(config('admin.database.attachment_table'));
        Schema::connection($connection)->dropIfExists(config('admin.database.auth_group_table'));
        Schema::connection($connection)->dropIfExists(config('admin.database.auth_group_access_table'));
        Schema::connection($connection)->dropIfExists(config('admin.database.auth_rule_table'));
        Schema::connection($connection)->dropIfExists(config('admin.database.category_table'));
        Schema::connection($connection)->dropIfExists(config('admin.database.config_table'));
        Schema::connection($connection)->dropIfExists(config('admin.database.ems_table'));
        Schema::connection($connection)->dropIfExists(config('admin.database.sms_table'));
        Schema::connection($connection)->dropIfExists(config('admin.database.test_table'));
        Schema::connection($connection)->dropIfExists(config('admin.database.user_table'));
        Schema::connection($connection)->dropIfExists(config('admin.database.user_group_table'));
        Schema::connection($connection)->dropIfExists(config('admin.database.user_money_log_table'));
        Schema::connection($connection)->dropIfExists(config('admin.database.user_rule_table'));
        Schema::connection($connection)->dropIfExists(config('admin.database.user_score_log_table'));
        Schema::connection($connection)->dropIfExists(config('admin.database.user_token_table'));
        Schema::connection($connection)->dropIfExists(config('admin.database.version_table'));


    }
}