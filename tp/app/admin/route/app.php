<?php

use \think\facade\Route;

/**
 * return Student data
 * 学生信息
 */
Route::group('Student', function () {
    Route::get('/[:page]', 'Student/findall');
    Route::put('/:id', 'Student/update');

})->middleware(\app\admin\middleware\compareToken11::class);

/**
 * router Tripreport
 * 个人报备
 */
Route::group('Tripreport', function () {
    Route::get('/[:page]', 'Tripreport/findall');
    Route::put('/:id', 'Tripreport/edit');
//    Route::post('/health','Tripreport/health_img');
})->middleware(\app\admin\middleware\compareToken11::class);

/**
 * router Leaveschool
 * 出校记录
 */
Route::group('Leaveschool', function () {
    Route::get('/[:page]', 'Leaveschool/findall');
    Route::put('/:id', 'Leaveschool/edit');
//    Route::post('/health','Tripreport/health_img');
})->middleware(\app\admin\middleware\compareToken11::class);
Route::group('LeaveChange',function (){
    Route::get('/','LeaveChange/index');
})->middleware(\app\admin\middleware\compareToken11::class);

/**
 * router Returnschool
 * 返校校记录
 */
Route::group('Returnschool', function () {
    Route::get('/[:page]', 'Returnschool/findall');
    Route::put('/:id', 'Returnschool/edit');
//    Route::post('/health','Tripreport/health_img');
})->middleware(\app\admin\middleware\compareToken11::class);
Route::group('ReturnChange',function (){
    Route::get('/','ReturnChange/index');
})->middleware(\app\admin\middleware\compareToken11::class);

/**
 * router Points
 * 积分表
 */
Route::group('Points', function () {
    Route::get('/[:page]', 'Points/findall');
    Route::put('/:id', 'Points/edit');
//    Route::post('/health','Tripreport/health_img');
})->middleware(\app\admin\middleware\compareToken11::class);

/**
 * router Pointlog
 * 积分日志表
 */
Route::group('Pointlog', function () {
    Route::get('/[:page]', 'Pointlog/findall');
    Route::delete('/', 'Pointlog/clear');
//    Route::post('/health','Tripreport/health_img');
})->middleware(\app\admin\middleware\compareToken11::class);

/**
 * router Govdocument
 * 政府政策文件
 */
Route::group('Govdocument', function () {
    // 根据标题查询单条数据
    Route::get('/[:title]', 'Govdocument/findall');
    // 修改
    Route::put('/', 'Govdocument/edit');
    // 新增
    Route::post('/', 'Govdocument/add');
    // 删除
    Route::delete('/', 'Govdocument/delete');
})->middleware(\app\admin\middleware\compareToken11::class);

/**
 * router govdocument
 * 疫情防控小知识
 */
Route::group('Epknowledge', function () {
    // 根据标题查询单条数据
    Route::get('/[:title]', 'Epknowledge/findall');
    // 修改
    Route::put('/', 'Epknowledge/edit');
    // 新增
    Route::post('/', 'Epknowledge/add');
    // 删除
    Route::delete('/', 'Epknowledge/delete');
})->middleware(\app\admin\middleware\compareToken11::class);

Route::group('Pointrule', function () {
    // 根据标题查询单条数据
    Route::get('/', 'Pointrule/findall');
    // 修改
    Route::put('/', 'Pointrule/edit');
//    // 新增
//    Route::post('/', 'Epknowledge/add');
//    // 删除
//    Route::delete('/', 'Epknowledge/delete');

})->middleware(\app\admin\middleware\compareToken11::class);

Route::group('AdminLogin', function () {
    // 根据标题查询单条数据
    Route::post('/', 'AdminLogin/login');

});

Route::group('Admin', function () {
    Route::get('/', 'Admin/index');
    Route::put('/', 'Admin/edit');
    Route::post('/', 'Admin/add');
    Route::delete('/', 'Admin/premissonStatus');
})->middleware(\app\admin\middleware\compareToken11::class);

