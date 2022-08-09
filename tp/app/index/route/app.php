<?php
use think\facade\Route;

/**
 * router Govdocument
 * 政府政策文件
 */
Route::group('Govdocument', function(){
    // 查询所有数据
    Route::get('/[:id]$','Govdocument/findall');
    // 根据标题查询单条数据
    Route::get('/t/:title','Govdocument/search');
});

/**
 * router govdocument
 * 疫情防控小知识
 */
Route::group('Epknowledge', function(){
    // 查询所有数据
    Route::get('/[:id]$','Epknowledge/findall');
    // 根据标题查询单条数据
    Route::get('/t/:title','Epknowledge/search');
});

/**
 * router Tripreport
 * 个人报备
 */
Route::group('Tripreport', function (){
    Route::post('/','Tripreport/add');
    Route::post('/health','Tripreport/health_img');
})->middleware(\app\index\middleware\compareToken::class);

/**
 * router Leaveschool
 * 出校申请
 */
Route::group('Leaveschool', function (){
    Route::get('/','Leaveschool/index');
    Route::post('/','Leaveschool/add');
})->middleware(\app\index\middleware\compareToken::class);

/**
 * router Leaveschool
 * 返校申请
 */
Route::group('Returnschool', function (){
    Route::get('/','Returnschool/index');
    Route::post('/','Returnschool/add');
})->middleware(\app\index\middleware\compareToken::class);

/**
 * router Student
 * 学生信息
 */
Route::group('Student', function (){
    Route::post('/','Student/save');
})->middleware(\app\index\middleware\compareToken::class);


Route::group('Points', function (){
    Route::put('/', 'Points/sign_in');
})->middleware(\app\index\middleware\compareToken::class);