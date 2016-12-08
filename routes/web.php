<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


Route::get('/', function () {

    return View::make('login') ;
});
Route::get('login', function () {
    return View::make('login');
});
Route::post('login', function () {

    if (Auth::attempt(array('email' => Input::get('email'), 'password' => Input::get('password')), true)) {
        return Redirect::to('/productBacklogs/0')->with('mensaje', 'Has iniciado sesión');
    } else {
        return Redirect::back()->with('mensaje', 'Los datos introducidos no son válidos');
    }

});

Route::group(['middleware' => 'auth'], function () {

    //Cerrar sesión
    Route::get('logout', function () {
        Auth::logout();
        return Redirect::to('/')
            ->with('mensaje', '¡Hasta pronto!');
    });

    Route::get('/', 'WelcomeController@index');
    Route::get('/productBacklogs/{project_id}', 'TaskController@productBacklogs');
    Route::get('/task/create', 'TaskController@create');
    Route::post('/task/store', 'TaskController@store');
    Route::post('/task/updateInProduct', 'TaskController@updateInProduct');


    Route::get('/task/changeState/{state}/{task_id}', 'TaskController@changeState');
    Route::post('/task/updateInSprint', 'TaskController@updateInSprint');

    Route::get('/sprintBacklogs/{project_id}', 'TaskController@sprintBacklogs');
    Route::get('/mySprintBacklogs/{project_id}', 'TaskController@mySprintBacklog');

    Route::get('/sprintBacklogs/burndown/{project_id}', 'TaskController@burndown');
    Route::get('/changes', 'ChangeController@lastChanges');
});

Route::get('/compareRedmine', 'TaskController@compareRedmine');