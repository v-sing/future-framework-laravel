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
        Schema::connection($connection)->create(config('admin.database.admin'), function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->string('username', 20)->comment('用户名');
            $table->string('nickname', 50)->comment('昵称');
            $table->string('password', 32)->comment('密码');
            $table->string('salt', 30)->comment('密码盐');
            $table->string('avatar', 100)->comment('头像');
            $table->string('email', 100)->comment('电子邮箱');
            $table->integer('loginfailure', 1)->comment('失败次数');
            $table->integer('logintime', 10)->comment('登录时间');
            $table->integer('createtime', 10)->comment('创建时间');
            $table->integer('updatetime', 10)->comment('更新时间');
            $table->string('token', 59)->comment('Session标识');
            $table->string('status', 30)->default('normal')->comment('状态');
            $table->timestamps();
        });
        Schema::connection($connection)->create(config('admin.database.admin_log'), function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->integer('admin_id', 10)->comment('管理员ID');
            $table->string('username', 30)->comment('管理员名字');
            $table->string('url', 1500)->comment('操作页面');
            $table->string('title', 100)->comment('日志标题');
            $table->text('content')->comment('内容');
            $table->string('ip', 50)->comment('IP');
            $table->string('useragent', 255)->comment('User-Agent');
            $table->integer('createtime', 10)->comment('操作时间');
            $table->timestamps();


        });
        Schema::connection($connection)->create(config('admin.database.attachment'), function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->integer('admin_id', 10)->comment('管理员ID');
            $table->integer('user_id', 10)->comment('会员ID');
            $table->string('url', 255)->comment('物理路径');
            $table->string('imagewidth', 30)->comment('宽度');
            $table->string('imageheight', 30)->comment('高度');
            $table->string('imagetype', 30)->comment('图片类型');
            $table->integer('imageframes', 10)->comment('图片帧数');
            $table->integer('filesize', 10)->comment('文件大小');
            $table->string('mimetype', 100)->comment('mime类型');
            $table->string('extparam', 255)->comment('透传数据');
            $table->integer('createtime', 10)->comment('创建日期');
            $table->integer('updatetime', 10)->comment('更新时间');
            $table->integer('uploadtime', 10)->comment('上传时间');
            $table->string('storage', 100)->comment('存储位置');
            $table->string('sha1', 40)->comment('文件 sha1编码');
            $table->timestamps();

        });
        Schema::connection($connection)->create(config('admin.database.auth_group'), function (Blueprint $table) {
            $table->increments('id')->comment('');
            $table->integer('pid', 10)->comment('父组别');
            $table->string('name', 100)->comment('组名');
            $table->text('rules')->comment('规则ID');
            $table->integer('createtime', 10)->comment('创建时间');
            $table->integer('updatetime', 10)->comment('更新时间');
            $table->string('status', 30)->comment('状态');
            $table->timestamps();

        });
        Schema::connection($connection)->create(config('admin.database.auth_group_access'), function (Blueprint $table) {
            $table->integer('uid')->comment('会员ID');
            $table->integer('group_id')->comment('级别ID');
            $table->timestamps();

        });
        Schema::connection($connection)->create(config('admin.database.auth_rule'), function (Blueprint $table) {
            $table->increments('id')->comment('');
            $table->enum('type', ['menu', 'file'])->comment('menu为菜单,file为权限节点');
            $table->integer('pid', 10)->comment('父ID');
            $table->string('name', 100)->comment('规则名称');
            $table->string('title', 50)->comment('规则名称');
            $table->string('icon', 50)->comment('图标');
            $table->string('condition', 255)->comment('条件');
            $table->string('remark', 255)->comment('备注');
            $table->integer('ismenu', 1)->comment('是否为菜单');
            $table->integer('createtime', 10)->comment('创建时间');
            $table->integer('updatetime', 10)->comment('更新时间');
            $table->integer('weigh', 10)->comment('权重');
            $table->string('status', 30)->comment('状态');
            $table->timestamps();

        });
        Schema::connection($connection)->create(config('admin.database.category'), function (Blueprint $table) {
            $table->increments('id')->comment('');
            $table->integer('pid', 10)->comment('父ID');
            $table->string('type', 30)->comment('栏目类型');
            $table->string('name', 30)->comment('');
            $table->string('nickname', 50)->comment('');
            $table->string('flag', 20)->comment('');
            $table->string('image', 100)->comment('图片');
            $table->string('keywords', 255)->comment('关键字');
            $table->string('description', 255)->comment('描述');
            $table->string('diyname', 30)->comment('自定义名称');
            $table->integer('createtime', 10)->comment('创建时间');
            $table->integer('updatetime', 10)->comment('更新时间');
            $table->integer('weigh', 10)->comment('权重');
            $table->string('status', 30)->comment('状态');
            $table->timestamps();

        });
        Schema::connection($connection)->create(config('admin.database.config'), function (Blueprint $table) {
            $table->increments('id')->comment('');
            $table->string('name', 30)->comment('变量名');
            $table->string('group', 30)->comment('分组');
            $table->string('title', 100)->comment('变量标题');
            $table->string('tip', 100)->comment('变量描述');
            $table->string('type', 30)->comment('类型:string,text,int,bool,array,datetime,date,file');
            $table->text('value')->comment('变量值');
            $table->text('content')->comment('变量字典数据');
            $table->string('rule', 100)->comment('验证规则');
            $table->string('extend', 255)->comment('扩展属性');
            $table->timestamps();

        });
        Schema::connection($connection)->create(config('admin.database.ems'), function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->string('event', 30)->comment('事件');
            $table->string('email', 100)->comment('邮箱');
            $table->string('code', 10)->comment('验证码');
            $table->integer('times', 10)->comment('验证次数');
            $table->string('ip', 30)->comment('IP');
            $table->integer('createtime', 10)->comment('创建时间');
            $table->timestamps();

        });
        Schema::connection($connection)->create(config('admin.database.sms'), function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->string('event', 30)->comment('事件');
            $table->string('mobile', 20)->comment('手机号');
            $table->string('code', 10)->comment('验证码');
            $table->integer('times', 10)->comment('验证次数');
            $table->string('ip', 30)->comment('IP');
            $table->integer('createtime', 10)->comment('创建时间');
            $table->timestamps();

        });
        Schema::connection($connection)->create(config('admin.database.test'), function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->integer('admin_id', 10)->comment('管理员ID');
            $table->integer('category_id', 10)->comment('分类ID(单选)');
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
            $table->integer('views', 10)->comment('点击');
            $table->string('startdate', 20)->comment('开始日期');
            $table->string('activitytime', 20)->comment('活动时间(datetime)');
            $table->string('year', 4)->comment('年');
            $table->string('times', 20)->comment('时间');
            $table->integer('refreshtime', 10)->comment('刷新时间(int)');
            $table->integer('createtime', 10)->comment('创建时间');
            $table->integer('updatetime', 10)->comment('更新时间');
            $table->integer('weigh', 10)->comment('权重');
            $table->integer('switch', 1)->comment('开关');
            $table->string('status', 20)->comment('状态');
            $table->string('state', 0)->comment('状态值:0=禁用,1=正常,2=推荐');
            $table->timestamps();

        });
        Schema::connection($connection)->create(config('admin.database.user'), function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->integer('group_id', 10)->comment('组别ID');
            $table->string('username', 32)->comment('用户名');
            $table->string('nickname', 50)->comment('昵称');
            $table->string('password', 32)->comment('密码');
            $table->string('salt', 30)->comment('密码盐');
            $table->string('email', 100)->comment('电子邮箱');
            $table->string('mobile', 11)->comment('手机号');
            $table->string('avatar', 255)->comment('头像');
            $table->integer('level', 1)->comment('等级');
            $table->integer('gender', 1)->comment('性别');
            $table->string('birthday', 20)->comment('生日');
            $table->string('bio', 100)->comment('格言');
            $table->decimal('money', 10, 2)->comment('余额');
            $table->integer('score', 10)->comment('积分');
            $table->integer('successions', 10)->comment('连续登录天数');
            $table->integer('maxsuccessions', 10)->comment('最大连续登录天数');
            $table->integer('prevtime', 10)->comment('上次登录时间');
            $table->integer('logintime', 10)->comment('登录时间');
            $table->string('loginip', 50)->comment('登录IP');
            $table->integer('loginfailure', 1)->comment('失败次数');
            $table->string('joinip', 50)->comment('加入IP');
            $table->integer('jointime', 10)->comment('加入时间');
            $table->integer('createtime', 10)->comment('创建时间');
            $table->integer('updatetime', 10)->comment('更新时间');
            $table->string('token', 50)->comment('Token');
            $table->string('status', 30)->comment('状态');
            $table->string('verification', 255)->comment('验证');

            $table->timestamps();

        });
        Schema::connection($connection)->create(config('admin.database.user_group'), function (Blueprint $table) {
            $table->increments('id')->comment('');
            $table->string('name', 50)->comment('组名');
            $table->text('rules')->comment('权限节点');
            $table->integer('createtime', 10)->comment('添加时间');
            $table->integer('updatetime', 10)->comment('更新时间');
            $table->string('status', 20)->comment('状态');

            $table->timestamps();

        });
        Schema::connection($connection)->create(config('admin.database.user_money_log'), function (Blueprint $table) {
            $table->increments('id')->comment('');
            $table->integer('user_id', 10)->comment('会员ID');
            $table->decimal('money', 10, 2)->comment('变更余额');
            $table->decimal('before', 10, 2)->comment('变更前余额');
            $table->decimal('after', 10, 2)->comment('变更后余额');
            $table->string('memo', 255)->comment('备注');
            $table->integer('createtime', 10)->comment('创建时间');

            $table->timestamps();

        });
        Schema::connection($connection)->create(config('admin.database.user_rule'), function (Blueprint $table) {
            $table->increments('id')->comment('');
            $table->integer('pid', 10)->comment('父ID');
            $table->string('name', 50)->comment('名称');
            $table->string('title', 50)->comment('标题');
            $table->string('remark', 100)->comment('备注');
            $table->integer('ismenu', 1)->comment('是否菜单');
            $table->integer('createtime', 10)->comment('创建时间');
            $table->integer('updatetime', 10)->comment('更新时间');
            $table->integer('weigh', 10)->comment('权重');
            $table->string('status', 20)->comment('状态');
            $table->timestamps();

        });
        Schema::connection($connection)->create(config('admin.database.user_score_log'), function (Blueprint $table) {
            $table->increments('id')->comment('');
            $table->integer('user_id', 10)->comment('会员ID');
            $table->integer('score', 10)->comment('变更积分');
            $table->integer('before', 10)->comment('变更前积分');
            $table->integer('after', 10)->comment('变更后积分');
            $table->string('memo', 255)->comment('备注');
            $table->integer('createtime', 10)->comment('创建时间');
            $table->timestamps();

        });
        Schema::connection($connection)->create(config('admin.database.user_token'), function (Blueprint $table) {
            $table->string('token', 50)->comment('Token');
            $table->integer('user_id', 10)->comment('会员ID');
            $table->integer('createtime', 10)->comment('创建时间');
            $table->integer('expiretime', 10)->comment('过期时间');
            $table->timestamps();

        });
        Schema::connection($connection)->create(config('admin.database.version'), function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->string('oldversion', 30)->comment('旧版本号');
            $table->string('newversion', 30)->comment('新版本号');
            $table->string('packagesize', 30)->comment('包大小');
            $table->string('content', 500)->comment('升级内容');
            $table->string('downloadurl', 255)->comment('下载地址');
            $table->integer('enforce', 1)->comment('强制更新');
            $table->integer('createtime', 10)->comment('创建时间');
            $table->integer('updatetime', 10)->comment('更新时间');
            $table->integer('weigh', 10)->comment('权重');
            $table->string('status', 30)->comment('状态');
            $table->timestamps();

        });


    }

    protected function down()
    {
        $connection = config('admin.database.connection') ?: config('database.default');
        Schema::connection($connection)->dropIfExists(config('admin.database.admin'));
        Schema::connection($connection)->dropIfExists(config('admin.database.admin_log'));
        Schema::connection($connection)->dropIfExists(config('admin.database.attachment'));
        Schema::connection($connection)->dropIfExists(config('admin.database.auth_group'));
        Schema::connection($connection)->dropIfExists(config('admin.database.auth_group_access'));
        Schema::connection($connection)->dropIfExists(config('admin.database.auth_rule'));
        Schema::connection($connection)->dropIfExists(config('admin.database.category'));
        Schema::connection($connection)->dropIfExists(config('admin.database.config'));
        Schema::connection($connection)->dropIfExists(config('admin.database.ems'));
        Schema::connection($connection)->dropIfExists(config('admin.database.sms'));
        Schema::connection($connection)->dropIfExists(config('admin.database.test'));
        Schema::connection($connection)->dropIfExists(config('admin.database.user'));
        Schema::connection($connection)->dropIfExists(config('admin.database.user_group'));
        Schema::connection($connection)->dropIfExists(config('admin.database.user_money_log'));
        Schema::connection($connection)->dropIfExists(config('admin.database.user_rule'));
        Schema::connection($connection)->dropIfExists(config('admin.database.user_score_log'));
        Schema::connection($connection)->dropIfExists(config('admin.database.user_token'));
        Schema::connection($connection)->dropIfExists(config('admin.database.version'));


    }
}