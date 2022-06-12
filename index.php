<?php
error_reporting(E_ALL & ~E_NOTICE);
//开启会话
Session_start();
//包含所有Composer的组件库
require('vendor/autoload.php');
require('class/cattree.php');

use NoahBuscher\Macaw\Macaw;

//进入仪表盘首页
Macaw::get('/', "admin\login@index");
Macaw::get('/admin', "admin\Index@index");

// 管理员路由
Macaw::get('/admin/adminuser', "admin\AdminUser@index");  //管理员列表
Macaw::any('/admin/adminuser/add', 'admin\AdminUser@add'); //添加
Macaw::get('/admin/adminuser/mod/(:num)', 'admin\AdminUser@mod'); //获取修改UI
Macaw::post('/admin/adminuser/doupdate', 'admin\AdminUser@doupdate'); //修改操作
Macaw::get('/admin/adminuser/del/(:num)', 'admin\AdminUser@del'); //删除
// 管理员登录和退出操作
Macaw::get('/admin/login', 'admin\login@index');
Macaw::get('/admin/login/vcode', 'admin\login@vcode');
Macaw::post('/admin/login/dologin', 'admin\login@dologin');
Macaw::get('/admin/login/logout', 'admin\login@logout');

// 客户管理路由
Macaw::get('/admin/client', "admin\Client@index");  //管理员列表
Macaw::any('/admin/client/add', 'admin\Client@add'); //添加
Macaw::get('/admin/client/mod/(:num)', 'admin\Client@mod'); //获取修改UI
Macaw::post('/admin/client/doupdate', 'admin\Client@doupdate'); //修改操作
Macaw::get('/admin/client/del/(:num)', 'admin\Client@del'); //删除
Macaw::get('/admin/client/detail/(:num)', 'admin\Client@detail'); //删除

// 商品分类管理路由
Macaw::get('/admin/category', "admin\Category@index");  //管理员列表
Macaw::any('/admin/category/add', 'admin\Category@add'); //添加
Macaw::get('/admin/category/mod/(:num)', 'admin\Category@mod'); //获取修改UI
Macaw::post('/admin/category/doupdate', 'admin\Category@doupdate'); //修改操作
Macaw::get('/admin/category/del/(:num)', 'admin\Category@del'); //删除

// 商品管理路由
Macaw::get('/admin/product', "admin\Product@index");  //列表
Macaw::any('/admin/product/add', 'admin\Product@add'); //添加
Macaw::get('/admin/product/mod/(:num)', 'admin\Product@mod'); //获取修改UI
Macaw::post('/admin/product/doupdate', 'admin\Product@doupdate'); //修改操作
Macaw::get('/admin/product/del/(:num)', 'admin\Product@del'); //删除


// 交易管理路由
Macaw::get('/admin/transaction', "admin\Transaction@index");  //列表
Macaw::any('/admin/transaction/add', 'admin\Transaction@add'); //添加
Macaw::get('/admin/transaction/mod/(:num)', 'admin\Transaction@mod'); //获取修改UI
Macaw::post('/admin/transaction/doupdate', 'admin\Transaction@doupdate'); //修改操作
Macaw::get('/admin/transaction/del/(:num)', 'admin\Transaction@del'); //删除
Macaw::get('/admin/transaction/return/(:num)', "admin\Transaction@return");  //退货
Macaw::get('/admin/transaction/cancelreturn/(:num)', "admin\Transaction@cancelreturn");  //取消退货
Macaw::get('/admin/transaction/(:num)', "admin\Transaction@detail");  //客户交易列表


// 供应商管理路由
Macaw::get('/admin/supplier', "admin\Supplier@index");  //列表
Macaw::any('/admin/supplier/add', 'admin\Supplier@add'); //添加
Macaw::get('/admin/supplier/mod/(:num)', 'admin\Supplier@mod'); //获取修改UI
Macaw::post('/admin/supplier/doupdate', 'admin\Supplier@doupdate'); //修改操作
Macaw::get('/admin/supplier/del/(:num)', 'admin\Supplier@del'); //删除
Macaw::get('/admin/supplier/detail/(:num)', "admin\Supplier@detail");  //客户交易列表
// 补货管理路由
Macaw::get('/admin/addProduct', "admin\AddProduct@index");  //列表
Macaw::any('/admin/addProduct/add', 'admin\AddProduct@add'); //添加
Macaw::get('/admin/addProduct/mod/(:num)', 'admin\AddProduct@mod'); //获取修改UI
Macaw::post('/admin/addProduct/doupdate', 'admin\AddProduct@doupdate'); //修改操作
Macaw::get('/admin/addProduct/del/(:num)', 'admin\AddProduct@del'); //删除

// 收支表路由
Macaw::get('/admin/report', "admin\Report@index");  //列表


Macaw::dispatch();

