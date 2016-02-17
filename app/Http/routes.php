<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::post('oauth/access_token', function() {
    return Response::json(Authorizer::issueAccessToken());
});


Route::group(['middleware'=>'oauth'] , function(){

    Route::resource('client' , 'ClientController', ['except'=>['create','edit']]);

    Route::resource('project' , 'ProjectController', ['except'=>['create','edit']]);

    Route::group(['prefix'=>'project'] , function(){

        Route::resource('note' , 'ProjectNoteController', ['except'=>['create','edit']]);

        Route::resource('{id}/note' , 'ProjectNoteController', ['except'=>['create','edit']]);


        Route::post('{id}/file','ProjectFileController@store');


        /*
        Route::get('note' , 'ProjectNoteController@allNote');

        Route::get('{id}/note' , 'ProjectNoteController@index');

        Route::post('{id}/note' , 'ProjectNoteController@store');

        Route::put('{id}/note/{noteId}' , 'ProjectNoteController@update');

        Route::get('{id}/note/{noteId}' , 'ProjectNoteController@show');

        Route::delete('{id}/note/{$noteId}' , 'ProjectNoteController@destroy');

        */

    });




});



/*

Route::get('project/note' , 'ProjectNoteController@allNote');

Route::get('project/{id}/note' , 'ProjectNoteController@index');

Route::post('project/{id}/note' , 'ProjectNoteController@store');

Route::put('project/{id}/note/{noteId}' , 'ProjectNoteController@update');

Route::get('project/{id}/note/{noteId}' , 'ProjectNoteController@show');

Route::delete('project/{id}/note/{$noteId}' , 'ProjectNoteController@destroy');



Route::get('project' , 'ProjectController@index');

Route::post('project' , 'ProjectController@store');

Route::put('project/{id}' , 'ProjectController@update');

Route::get('project/{id}' , 'ProjectController@show');

Route::delete('project/{id}' , 'ProjectController@destroy');



Route::get('client' , ['middleware'=>'oauth','uses'=>'ClientController@index']);

Route::post('client' , 'ClientController@store');

Route::put('client/{id}' , 'ClientController@update');

Route::get('client/{id}' , 'ClientController@show');

Route::delete('client/{id}' , 'ClientController@destroy');



*/