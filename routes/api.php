<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', 'Creatint\ArrayImages\FieldController@index');
Route::post('/upload', 'Creatint\ArrayImages\FieldController@upload');
Route::post('/urls', 'Creatint\ArrayImages\FieldController@urls');
Route::delete('/delete', 'Creatint\ArrayImages\FieldController@delete');
