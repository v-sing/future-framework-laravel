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
        Schema::connection($connection)->dropIfExists("admin");
        Schema::connection($connection)->create("admin", function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement()->comment('ID');
            $table->string('username', 20)->default('')->unique()->comment('用户名');
            $table->string('nickname', 50)->default('')->comment('昵称');
            $table->string('password', 32)->default('')->comment('密码');
            $table->string('salt', 30)->default('')->comment('密码盐');
            $table->string('avatar', 100)->default('')->comment('头像');
            $table->string('email', 100)->default('')->comment('电子邮箱');
            $table->tinyInteger('loginfailure')->default('0')->comment('失败次数');
            $table->unsignedInteger('logintime')->default('0')->comment('登录时间');
            $table->unsignedInteger('createtime')->default('0')->comment('创建时间');
            $table->unsignedInteger('updatetime')->default('0')->comment('更新时间');
            $table->string('token', 59)->default('')->comment('Session标识');
            $table->string('status', 30)->default('normal')->comment('状态');
        });
        Schema::connection($connection)->dropIfExists("admin_log");
        Schema::connection($connection)->create("admin_log", function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement()->comment('ID');
            $table->unsignedInteger('admin_id')->default('0')->comment('管理员ID');
            $table->string('username', 30)->default('')->comment('管理员名字');
            $table->string('url', 1500)->default('')->comment('操作页面');
            $table->string('title', 100)->default('')->comment('日志标题');
            $table->text('content')->comment('内容');
            $table->string('ip', 50)->default('')->comment('IP');
            $table->string('useragent', 255)->default('')->comment('User-Agent');
            $table->unsignedInteger('createtime')->default('0')->comment('操作时间');
        });
        Schema::connection($connection)->dropIfExists("attachment");
        Schema::connection($connection)->create("attachment", function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement()->comment('ID');
            $table->unsignedInteger('admin_id')->default('0')->comment('管理员ID');
            $table->unsignedInteger('user_id')->default('0')->comment('会员ID');
            $table->string('url', 255)->default('')->comment('物理路径');
            $table->string('imagewidth', 30)->default('')->comment('宽度');
            $table->string('imageheight', 30)->default('')->comment('高度');
            $table->string('imagetype', 30)->default('')->comment('图片类型');
            $table->unsignedInteger('imageframes')->default('0')->comment('图片帧数');
            $table->unsignedInteger('filesize')->default('0')->comment('文件大小');
            $table->string('mimetype', 100)->default('')->comment('mime类型');
            $table->string('extparam', 255)->default('')->comment('透传数据');
            $table->unsignedInteger('createtime')->default('0')->comment('创建日期');
            $table->unsignedInteger('updatetime')->default('0')->comment('更新时间');
            $table->unsignedInteger('uploadtime')->default('0')->comment('上传时间');
            $table->string('storage', 100)->default('local')->comment('存储位置');
            $table->string('sha1', 40)->default('')->comment('文件 sha1编码');
        });
        Schema::connection($connection)->dropIfExists("auth_group");
        Schema::connection($connection)->create("auth_group", function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement()->comment('');
            $table->unsignedInteger('pid')->default('0')->comment('父组别');
            $table->string('name', 100)->default('')->comment('组名');
            $table->text('rules')->comment('规则ID');
            $table->unsignedInteger('createtime')->default('0')->comment('创建时间');
            $table->unsignedInteger('updatetime')->default('0')->comment('更新时间');
            $table->string('status', 30)->default('')->comment('状态');
        });
        Schema::connection($connection)->dropIfExists("auth_group_access");
        Schema::connection($connection)->create("auth_group_access", function (Blueprint $table) {
            $table->unsignedInteger('uid')->autoIncrement()->comment('会员ID');
            $table->unsignedInteger('group_id')->autoIncrement()->comment('级别ID');
        });
        Schema::connection($connection)->dropIfExists("auth_rule");
        Schema::connection($connection)->create("auth_rule", function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement()->comment('');
            $table->enum('type', ['menu', 'file'])->default('file')->comment('menu为菜单,file为权限节点');
            $table->unsignedInteger('pid')->default('0')->comment('父ID');
            $table->string('name', 100)->default('')->unique()->comment('规则名称');
            $table->string('title', 50)->default('')->comment('规则名称');
            $table->string('icon', 50)->default('')->comment('图标');
            $table->string('condition', 255)->default('')->comment('条件');
            $table->string('remark', 255)->default('')->comment('备注');
            $table->tinyInteger('ismenu')->default('0')->comment('是否为菜单');
            $table->unsignedInteger('createtime')->default('0')->comment('创建时间');
            $table->unsignedInteger('updatetime')->default('0')->comment('更新时间');
            $table->unsignedInteger('weigh')->default('0')->comment('权重');
            $table->string('status', 30)->default('')->comment('状态');
        });
        Schema::connection($connection)->dropIfExists("category");
        Schema::connection($connection)->create("category", function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement()->comment('');
            $table->unsignedInteger('pid')->default('0')->comment('父ID');
            $table->string('type', 30)->default('')->comment('栏目类型');
            $table->string('name', 30)->default('')->comment('');
            $table->string('nickname', 50)->default('')->comment('');
            $table->enum('flag', ['hot', 'index', 'recommend'])->default('')->comment('');
            $table->string('image', 100)->default('')->comment('图片');
            $table->string('keywords', 255)->default('')->comment('关键字');
            $table->string('description', 255)->default('')->comment('描述');
            $table->string('diyname', 30)->default('')->comment('自定义名称');
            $table->unsignedInteger('createtime')->default('0')->comment('创建时间');
            $table->unsignedInteger('updatetime')->default('0')->comment('更新时间');
            $table->unsignedInteger('weigh')->default('0')->comment('权重');
            $table->string('status', 30)->default('')->comment('状态');
        });
        Schema::connection($connection)->dropIfExists("config");
        Schema::connection($connection)->create("config", function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement()->comment('');
            $table->string('name', 30)->default('')->comment('变量名');
            $table->string('group', 30)->default('')->comment('分组');
            $table->string('title', 100)->default('')->comment('变量标题');
            $table->string('tip', 100)->default('')->comment('变量描述');
            $table->string('type', 30)->default('')->comment('类型:string,text,int,bool,array,datetime,date,file');
            $table->text('value')->comment('变量值');
            $table->text('content')->comment('变量字典数据');
            $table->string('rule', 100)->default('')->comment('验证规则');
            $table->string('extend', 255)->default('')->comment('扩展属性');
            $table->mediumInteger('s')->nullable()->comment('');
        });
        Schema::connection($connection)->dropIfExists("ems");
        Schema::connection($connection)->create("ems", function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement()->comment('ID');
            $table->string('event', 30)->default('')->comment('事件');
            $table->string('email', 100)->default('')->comment('邮箱');
            $table->string('code', 10)->default('')->comment('验证码');
            $table->unsignedInteger('times')->default('0')->comment('验证次数');
            $table->string('ip', 30)->default('')->comment('IP');
            $table->unsignedInteger('createtime')->nullable()->default('0')->comment('创建时间');
        });
        Schema::connection($connection)->dropIfExists("migrations");
        Schema::connection($connection)->create("migrations", function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement()->comment('');
            $table->string('migration', 255)->comment('');
            $table->unsignedInteger('batch')->comment('');
        });
        Schema::connection($connection)->dropIfExists("sms");
        Schema::connection($connection)->create("sms", function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement()->comment('ID');
            $table->string('event', 30)->default('')->comment('事件');
            $table->string('mobile', 20)->default('')->comment('手机号');
            $table->string('code', 10)->default('')->comment('验证码');
            $table->unsignedInteger('times')->default('0')->comment('验证次数');
            $table->string('ip', 30)->default('')->comment('IP');
            $table->unsignedInteger('createtime')->nullable()->default('0')->comment('创建时间');
        });
        Schema::connection($connection)->dropIfExists("test");
        Schema::connection($connection)->create("test", function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement()->comment('ID');
            $table->unsignedInteger('admin_id')->default('0')->comment('管理员ID');
            $table->unsignedInteger('category_id')->default('0')->comment('分类ID(单选)');
            $table->string('category_ids', 100)->comment('分类ID(多选)');
            $table->enum('week', ['monday', 'tuesday', 'wednesday'])->comment('星期(单选):monday=星期一,tuesday=星期二,wednesday=星期三');
            $table->enum('flag', ['hot', 'index', 'recommend'])->default('')->comment('标志(多选):hot=热门,index=首页,recommend=推荐');
            $table->enum('genderdata', ['male', 'female'])->default('male')->comment('性别(单选):male=男,female=女');
            $table->enum('hobbydata', ['music', 'reading', 'swimming'])->comment('爱好(多选):music=音乐,reading=读书,swimming=游泳');
            $table->string('title', 50)->default('')->comment('标题');
            $table->text('content')->comment('内容');
            $table->string('image', 100)->default('')->comment('图片');
            $table->string('images', 1500)->default('')->comment('图片组');
            $table->string('attachfile', 100)->default('')->comment('附件');
            $table->string('keywords', 100)->default('')->comment('关键字');
            $table->string('description', 255)->default('')->comment('描述');
            $table->string('city', 100)->default('')->comment('省市');
            $table->float('price', 10, 2)->default('0.00')->comment('价格');
            $table->unsignedInteger('views')->default('0')->comment('点击');
            $table->date('startdate')->nullable()->comment('开始日期');
            $table->dateTime('activitytime')->nullable()->comment('活动时间(datetime)');
            $table->year('year')->nullable()->comment('年');
            $table->time('times')->nullable()->comment('时间');
            $table->unsignedInteger('refreshtime')->default('0')->comment('刷新时间(int)');
            $table->unsignedInteger('createtime')->default('0')->comment('创建时间');
            $table->unsignedInteger('updatetime')->default('0')->comment('更新时间');
            $table->unsignedInteger('weigh')->default('0')->comment('权重');
            $table->tinyInteger('switch')->default('0')->comment('开关');
            $table->enum('status', ['normal', 'hidden'])->default('normal')->comment('状态');
            $table->enum('state', ['0', '1', '2'])->default('1')->comment('状态值:0=禁用,1=正常,2=推荐');
        });
        Schema::connection($connection)->dropIfExists("user");
        Schema::connection($connection)->create("user", function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement()->comment('ID');
            $table->unsignedInteger('group_id')->default('0')->comment('组别ID');
            $table->string('username', 32)->default('')->comment('用户名');
            $table->string('nickname', 50)->default('')->comment('昵称');
            $table->string('password', 32)->default('')->comment('密码');
            $table->string('salt', 30)->default('')->comment('密码盐');
            $table->string('email', 100)->default('')->comment('电子邮箱');
            $table->string('mobile', 11)->default('')->comment('手机号');
            $table->string('avatar', 255)->default('')->comment('头像');
            $table->tinyInteger('level')->default('0')->comment('等级');
            $table->tinyInteger('gender')->default('0')->comment('性别');
            $table->date('birthday')->nullable()->comment('生日');
            $table->string('bio', 100)->default('')->comment('格言');
            $table->decimal('money', 10, 2)->default('0.00')->comment('余额');
            $table->unsignedInteger('score')->default('0')->comment('积分');
            $table->unsignedInteger('successions')->default('1')->comment('连续登录天数');
            $table->unsignedInteger('maxsuccessions')->default('1')->comment('最大连续登录天数');
            $table->unsignedInteger('prevtime')->default('0')->comment('上次登录时间');
            $table->unsignedInteger('logintime')->default('0')->comment('登录时间');
            $table->string('loginip', 50)->default('')->comment('登录IP');
            $table->tinyInteger('loginfailure')->default('0')->comment('失败次数');
            $table->string('joinip', 50)->default('')->comment('加入IP');
            $table->unsignedInteger('jointime')->default('0')->comment('加入时间');
            $table->unsignedInteger('createtime')->default('0')->comment('创建时间');
            $table->unsignedInteger('updatetime')->default('0')->comment('更新时间');
            $table->string('token', 50)->default('')->comment('Token');
            $table->string('status', 30)->default('')->comment('状态');
            $table->string('verification', 255)->default('')->comment('验证');
        });
        Schema::connection($connection)->dropIfExists("user_group");
        Schema::connection($connection)->create("user_group", function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement()->comment('');
            $table->string('name', 50)->nullable()->default('')->comment('组名');
            $table->text('rules')->nullable()->comment('权限节点');
            $table->unsignedInteger('createtime')->nullable()->comment('添加时间');
            $table->unsignedInteger('updatetime')->nullable()->comment('更新时间');
            $table->enum('status', ['normal', 'hidden'])->nullable()->comment('状态');
        });
        Schema::connection($connection)->dropIfExists("user_money_log");
        Schema::connection($connection)->create("user_money_log", function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement()->comment('');
            $table->unsignedInteger('user_id')->default('0')->comment('会员ID');
            $table->decimal('money', 10, 2)->default('0.00')->comment('变更余额');
            $table->decimal('before', 10, 2)->default('0.00')->comment('变更前余额');
            $table->decimal('after', 10, 2)->default('0.00')->comment('变更后余额');
            $table->string('memo', 255)->default('')->comment('备注');
            $table->unsignedInteger('createtime')->default('0')->comment('创建时间');
        });
        Schema::connection($connection)->dropIfExists("user_rule");
        Schema::connection($connection)->create("user_rule", function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement()->comment('');
            $table->unsignedInteger('pid')->nullable()->comment('父ID');
            $table->string('name', 50)->nullable()->comment('名称');
            $table->string('title', 50)->nullable()->default('')->comment('标题');
            $table->string('remark', 100)->nullable()->comment('备注');
            $table->tinyInteger('ismenu')->nullable()->comment('是否菜单');
            $table->unsignedInteger('createtime')->nullable()->comment('创建时间');
            $table->unsignedInteger('updatetime')->nullable()->comment('更新时间');
            $table->unsignedInteger('weigh')->nullable()->default('0')->comment('权重');
            $table->enum('status', ['normal', 'hidden'])->nullable()->comment('状态');
        });
        Schema::connection($connection)->dropIfExists("user_score_log");
        Schema::connection($connection)->create("user_score_log", function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement()->comment('');
            $table->unsignedInteger('user_id')->default('0')->comment('会员ID');
            $table->unsignedInteger('score')->default('0')->comment('变更积分');
            $table->unsignedInteger('before')->default('0')->comment('变更前积分');
            $table->unsignedInteger('after')->default('0')->comment('变更后积分');
            $table->string('memo', 255)->default('')->comment('备注');
            $table->unsignedInteger('createtime')->default('0')->comment('创建时间');
        });
        Schema::connection($connection)->dropIfExists("user_token");
        Schema::connection($connection)->create("user_token", function (Blueprint $table) {
            $table->string('token', 50)->autoIncrement()->comment('Token');
            $table->unsignedInteger('user_id')->default('0')->comment('会员ID');
            $table->unsignedInteger('createtime')->default('0')->comment('创建时间');
            $table->unsignedInteger('expiretime')->default('0')->comment('过期时间');
        });
        Schema::connection($connection)->dropIfExists("version");
        Schema::connection($connection)->create("version", function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement()->comment('ID');
            $table->string('oldversion', 30)->default('')->comment('旧版本号');
            $table->string('newversion', 30)->default('')->comment('新版本号');
            $table->string('packagesize', 30)->default('')->comment('包大小');
            $table->string('content', 500)->default('')->comment('升级内容');
            $table->string('downloadurl', 255)->default('')->comment('下载地址');
            $table->tinyInteger('enforce')->default('0')->comment('强制更新');
            $table->unsignedInteger('createtime')->default('0')->comment('创建时间');
            $table->unsignedInteger('updatetime')->default('0')->comment('更新时间');
            $table->unsignedInteger('weigh')->default('0')->comment('权重');
            $table->string('status', 30)->default('')->comment('状态');
        });

    }

    protected function down()
    {
        $connection = config('admin.database.connection') ?: config('database.default');
        Schema::connection($connection)->dropIfExists("admin");
        Schema::connection($connection)->dropIfExists("admin_log");
        Schema::connection($connection)->dropIfExists("attachment");
        Schema::connection($connection)->dropIfExists("auth_group");
        Schema::connection($connection)->dropIfExists("auth_group_access");
        Schema::connection($connection)->dropIfExists("auth_rule");
        Schema::connection($connection)->dropIfExists("category");
        Schema::connection($connection)->dropIfExists("config");
        Schema::connection($connection)->dropIfExists("ems");
        Schema::connection($connection)->dropIfExists("migrations");
        Schema::connection($connection)->dropIfExists("sms");
        Schema::connection($connection)->dropIfExists("test");
        Schema::connection($connection)->dropIfExists("user");
        Schema::connection($connection)->dropIfExists("user_group");
        Schema::connection($connection)->dropIfExists("user_money_log");
        Schema::connection($connection)->dropIfExists("user_rule");
        Schema::connection($connection)->dropIfExists("user_score_log");
        Schema::connection($connection)->dropIfExists("user_token");
        Schema::connection($connection)->dropIfExists("version");


    }
}