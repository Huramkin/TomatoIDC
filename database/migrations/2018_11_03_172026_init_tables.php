<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        //订单表
        Schema::create('orders', function (Blueprint $table) {//订单表
            $table->bigIncrements('id');//订单号
            $table->integer('goods_id')->nullable();//商品
            $table->string('title')->nullable();//订单名称
            $table->integer('user_id');
            $table->string('coupon')->nullable();//折扣代码
            $table->integer('status')->default(1);
            $table->string('type')->nullable();//类型
            $table->double('sale')->default(0);
            $table->double('price');
            $table->string('remark')->nullable();//备注
            $table->softDeletes();
            $table->timestamps();
        });

        //折扣代码
        Schema::create('coupons',function (Blueprint $table){
            $table->bigIncrements('id');//优惠ID
            $table->string('key');//折扣代码
            $table->string('type');//优惠类型
            $table->string('goods_id')->nullable();//是否限定商品，json存储
            $table->string('condition')->nullable();//使用条件
            $table->string('offer');//优惠，金额，百分比
            $table->integer('status')->default(1);//状态
            $table->dateTime('use_date');//启用日期
            $table->dateTime('deadline');//到期
            $table->timestamps();
        });

        //优惠卷
        Schema::create('vouchers', function (Blueprint $table) {
            $table->bigIncrements('id');//优惠ID
            $table->integer('user_id');//该优惠卷属于那个用户
            $table->string('type');//优惠类型
            $table->string('goods_id')->nullable();//是否限定商品，json存储
            $table->string('condition')->nullable();//使用条件
            $table->string('offer');//优惠，金额，百分比
            $table->integer('status')->default(1);//状态
            $table->dateTime('use_date');//启用日期
            $table->dateTime('deadline');//到期
            $table->timestamps();
        });

        //支付单
        Schema::create('pay', function (Blueprint $table) {
            $table->bigIncrements('id');//支付订单号
            $table->string('api_no');//第三方订单号
            $table->bigInteger('order_id');//订单号
            $table->string('payment')->nullable();
            $table->double('price');
            $table->integer('status')->default(1);
            $table->timestamps();
        });

        //设置表
        Schema::create('setups', function (Blueprint $table) { //设置
            $table->increments('id');
            $table->string('title');
            $table->longText('value')->nullable();
        });

        //新闻
        Schema::create('news', function (Blueprint $table) { //新闻
            $table->increments('id');
            $table->string('title');
            $table->longText('subtitle');
            $table->longText('description');
            $table->softDeletes();//软删除
            $table->integer('status')->default(1);
            $table->timestamps();
        });

        Schema::create('tickets', function (Blueprint $table) { //工单
            $table->increments('id');
            $table->integer('user_id');
            $table->string('order_no')->nullable();  //订单no
            $table->string('priority')->nullable();  //优先级
            $table->softDeletes();
            $table->string('title');
            $table->longText('content');
            $table->integer('status')->default(1);
            $table->timestamps();
        });

        Schema::create('tickets_reply', function (Blueprint $table) { //工单回复
            $table->string('ticket_id');
            $table->string('content');
            $table->integer('user_id');
            $table->integer('status')->default(1);
            $table->timestamps();
        });

        Schema::create('plugins', function (Blueprint $table) { //插件状态 暂无使用
            $table->increments('id');
            $table->string('title');
            $table->integer('status')->default(1);
            $table->timestamps();
        });

        //服务器表
        Schema::create('servers', function (Blueprint $table) { //服务器
            $table->increments('id');
            $table->string('title');
            $table->string('ip');
            $table->string('token')->nullable();
            $table->string('key')->nullable();
            $table->string('port')->nullable();
            $table->string('plugin')->nullable();
            $table->integer('categories_id')->nullable();
            $table->string('type')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });

        //主机列表
        Schema::create('hosts', function (Blueprint $table) { //主机信息
            $table->increments('id');
            $table->string('order_id');//订单
            $table->integer('user_id');
            $table->string('username');
            $table->string('password');
            $table->string('panel_id')->nullable();//第三方管理面板开通id
            $table->string('server_id')->nullable();
            $table->dateTime('deadline')->nullable();
            $table->string('remark')->nullable();
            $table->integer('status')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });


        Schema::create('goods', function (Blueprint $table) {//商品表
            $table->increments('id');
            $table->string('title');
//            $table->double('price');
            $table->string('type')->nullable();
            $table->string('level')->default(1);
            $table->integer('status')->default(1);
            $table->integer('display')->default(1);
            $table->string('domain_config')->default(0);//是否要配置域名，默认不配置
            $table->softDeletes();//软删除
            $table->integer('inventory')->nullable();//
            $table->integer('servers_categories_id')->nullable();//可以不使用单独服务器使用服务器组
            $table->integer('purchase_limit')->default(0);//限購
            $table->integer('upgrade')->default(0);//升级
            $table->integer('stock')->nullable();
            $table->integer('categories_id')->nullable();
            $table->longText('configure_id')->nullable();//配置 json/序列化存储
            $table->integer('server_id')->nullable();
            $table->longText('subtitle')->nullable();
            $table->longText('description')->nullable();
            $table->timestamps();
        });

        //商品组
        Schema::create('goods_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->softDeletes();//软删除
            $table->integer('display')->default(1);
            $table->string('level')->default(1);
            $table->string('content')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });

        //服务器分组
        Schema::create('servers_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->integer('display')->default(1);
            $table->integer('area_id')->nullable();
            $table->integer('status')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });

//        Schema::create('goods_configure', function (Blueprint $table) { //商品配置
//            $table->increments('id');
//            $table->string('title');
//            $table->string('type')->nullable();
//            $table->string('qps')->nullable();
//            $table->string('php_version')->nullable();
//            $table->string('subtemplete')->nullable();
//            $table->string('templete')->nullable();
//            $table->string('module')->nullable();
//            $table->string('mysql_version')->nullable();
//            $table->string('db_quota')->nullable();
//            $table->string('domain')->nullable();
//            $table->string('max_connect')->nullable();
//            $table->string('max_worker')->nullable();
//            $table->string('doc_root')->nullable();
//            $table->string('web_quota')->nullable();
//            $table->string('speed_limit')->nullable();
//            $table->string('log_handle')->nullable();
//            $table->string('subdir')->nullable();
//            $table->string('subdir_flag')->nullable();
//            $table->string('db_type')->nullable();
//            $table->string('flow_limit')->nullable();
//            $table->string('max_subdir')->nullable();
//            $table->string('ftp')->nullable();
//            $table->string('access')->nullable();
//            $table->string('hvmt')->nullable();
//            $table->string('group')->nullable();
//            $table->string('custommemory')->nullable();  //自定义内存
//            $table->string('overover')->nullable(); //
//            $table->string('custombandwidth')->nullable(); //自定义带宽
//            $table->string('time')->nullable();
//            $table->integer('status')->default(1);
//            $table->string('customcpunum')->nullable();  //CPU数量
//            $table->string('customdisk')->nullable();  //自定义硬盘大小
//            $table->longText('ip_list')->nullable(); //ip列表以,分割
//            $table->longText('mac')->nullable(); //ip列表以,分割
//            $table->longText('vnc')->nullable(); //开通vnc
//            $table->string('template')->nullable(); // 面板页面模板
//            $table->string('config_template')->nullable(); // 面板配置模板
//            $table->string('email_notice')->default(0); // 邮箱通知
//            $table->string('network_speed')->nullable(); // 网速限制
//            $table->string('free_domain')->nullable(); //免费二级域名
//            $table->string('language')->nullable(); //默认语言
//            $table->string('useregns')->nullable(); //是否为域使用注册的域名服务器。
//            $table->string('hasuseregns')->nullable(); //遗留参数
//            $table->string('forcedns')->nullable(); //是否使用新帐户的信息覆盖现有DNS区域
//            $table->string('reseller')->nullable(); //分销商
//            $table->string('maxsql')->nullable(); //最大开通数据库数量
//            $table->string('cgi')->nullable(); //CGi
//            $table->string('maxftp')->nullable(); //最大开通FTP数量
//            $table->string('maxpop')->nullable(); //帐户的最大电子邮件帐户数
//            $table->string('maxpark')->nullable(); //帐户的最大停放域数（别名）
//            $table->string('maxaddon')->nullable(); //帐户的最大插件域数。
//            $table->string('customip')->nullable(); //手动指定ip
//            $table->softDeletes();
//            $table->string('json_configure')->nullable();//使用json保存配置信息
//            $table->timestamps();
//        });


        Schema::create('goods_configure', function (Blueprint $table) { //商品配置
            $table->increments('id');
            $table->string('title');
            $table->string('status')->default(1);
            $table->string('type')->nullable();
            $table->string('template')->nullable();
            $table->longText('configure')->nullable();//保存配置信息
            $table->softDeletes();
            $table->timestamps();
        });

        //计费
        Schema::create('bills', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('time');
            $table->string('unit');
            $table->double('price');
            $table->string('status')->default(1);
            $table->string('renew')->default(1);
            $table->integer('goods_id');
            $table->string('type')->nullable();
//            $table->string('automatic')->default(1);
//            $table->string('content')->nullable();//备注
            $table->softDeletes();//软删除
            $table->timestamps();
        });


        //软件安装表
        Schema::create('software', function (Blueprint $table) {
            $table->increments('id');
            $table->string('path');//路径
            $table->string('params')->nullable();
            $table->string('title');//标题
            $table->string('content');//备注
            $table->string('version')->nullable();//版本
            $table->string('status')->default(1);
            $table->softDeletes();//软删除
            $table->timestamps();
        });

        //自定义页面
        Schema::create('diy_pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('hash');
            $table->longText('content');
            $table->integer('status')->default(1);
            $table->timestamps();
        });

        //服务器地区
        Schema::create('servers_area', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->longText('description')->nullable();
            $table->longText('content')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });

        //团队
        Schema::create('teams', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('subtitle');
            $table->longText('content');
            $table->string('type')->nullable();
            $table->string('status')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });

        //团队成员
        Schema::create('team_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('team_id');
            $table->string('type')->nullable();
            $table->string('level')->nullable();
            $table->string('status')->default(1);
            $table->timestamps();
        });
        //dns解析
        Schema::create('dns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('prefix');//前缀
            $table->string('type');//解析类型
            $table->integer('user_id');
            $table->integer('domain_id');
            $table->string('plugin')->nullable();//解析平台
            $table->integer('status')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
        //域名注册表
        Schema::create('domains', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('domain');//域名
            $table->string('api_no');//第三方id
            $table->string('plugin')->nullable();//平台
            $table->integer('user_id');
            $table->string('type')->nullable();
            $table->integer('status')->default(1);
            $table->softDeletes();
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
        Schema::dropIfExists('servers_area');
        Schema::dropIfExists('diy_pages');
        Schema::dropIfExists('software');
        Schema::dropIfExists('plugins');
        Schema::dropIfExists('goods');
        Schema::dropIfExists('goods_configure');
        Schema::dropIfExists('goods_categories');
        Schema::dropIfExists('servers_categories');
        Schema::dropIfExists('news');
        Schema::dropIfExists('setups');
        Schema::dropIfExists('tickets');
        Schema::dropIfExists('tickets_reply');
        Schema::dropIfExists('bills');
        Schema::dropIfExists('hosts');
        Schema::dropIfExists('dns');
        Schema::dropIfExists('domains');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('pay');
        Schema::dropIfExists('servers');
        Schema::dropIfExists('coupons');
        Schema::dropIfExists('vouchers');
        Schema::dropIfExists('teams');
        Schema::dropIfExists('team_user');
    }
}
