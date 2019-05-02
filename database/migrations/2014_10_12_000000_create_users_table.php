<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type')->nullable();//账户类型
            $table->string('name');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();//邮箱验证
            $table->string('api_token', 80)
//                ->after('password') 开发环境mysql无法运行
                ->unique()
                ->nullable()
                ->default(null);
            $table->double('account')->default(0);//账户余额
            $table->integer('status')->default(1);
            $table->integer('admin_authority')->default(0);//管理员权限
            $table->timestamp('phone_validate_at')->nullable();//手机验证
            $table->timestamp('real_name_validate_at')->nullable();//实名验证
            $table->string('wechat_openid')->nullable();//微信绑定
            $table->string('weibo_openid')->nullable();//微博绑定
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
