<?php

Route::get('/', 'TopicsController@index')->name('root');

// Auth::routes();
// 此处是 Laravel 的用户认证路由，可以在 vendor/laravel/framework/src/Illuminate/Routing/Router.php 中搜索关键词 LoginController 即可找到定义的地方，以上等同于：

// // 用户身份验证相关的路由
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// // 用户注册相关路由
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// // 密码重置相关路由
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// // Email 认证相关路由
Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::post('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

// php artisan ui:auth 命令为我们生成了 resources/views/auth 下几个文件：
// 视图名称 	说明
// register.blade.php 	注册页面视图
// login.blade.php 	登录页面视图
// verify.blade.php 	邮箱认证视图
// passwords/email.blade.php 	提交邮箱发送邮件的视图
// passwords/reset.blade.php 	重置密码的页面视图

Route::resource('users', 'UsersController', ['only' => ['show', 'update', 'edit']]);
// 上面代码将等同于：
// Route::get('/users/{user}', 'UsersController@show')->name('users.show');
// Route::get('/users/{user}/edit', 'UsersController@edit')->name('users.edit');
// Route::patch('/users/{user}', 'UsersController@update')->name('users.update');


Route::resource('topics', 'TopicsController', ['only' => ['index', 'create', 'store', 'update', 'edit', 'destroy']]);

Route::resource('categories', 'CategoriesController', ['only' => ['show']]);

Route::post('upload_image', 'TopicsController@uploadImage')->name('topics.upload_image');
// 图片上传

Route::get('topics/{topic}/{slug?}', 'TopicsController@show')->name('topics.show');

Route::resource('replies', 'RepliesController', ['only' => ['store', 'destroy']]);

Route::resource('notifications', 'NotificationsController', ['only' => ['index']]);

Route::get('permission-denied', 'PagesController@permissionDenied')->name('permission-denied');