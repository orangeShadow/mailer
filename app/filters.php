<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
    Assets::add(url('').'/css/bootstrap.min.css');
    Assets::add(url('').'/css/sb-admin-2.css');
    Assets::add(url('').'/css/plugins/metisMenu/metisMenu.min.css');
    Assets::add(url('').'/css/plugins/timeline.css');
    Assets::add(url('').'/css/plugins/morris.css');
    Assets::add(Config::get('app.url').'/font-awesome-4.1.0/css/font-awesome.min.css');


    Assets::add(url('').'/js/jquery-1.11.0.js');
    Assets::add(url('').'/js/bootstrap.min.js');
    Assets::add(url('').'/js/plugins/metisMenu/metisMenu.min.js');
    Assets::add(url('').'/tinymce/tinymce.min.js');
    Assets::add(url('').'/tinymce/tinymce_editor.js');

    //Morris Charts JavaScript
    /*
        Assets::addJs('plugins/morris/raphael.min.js');
        Assets::addJs('plugins/morris/morris.min.js');
        Assets::addJs('plugins/morris/morris-data.js');
    */
    Assets::add(url('').'/js/sb-admin-2.js');

    Assets::add(url('').'/js/script.js');

});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

/*Route::filter('before', function()
{

});*/


Route::filter('auth', function()
{
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			return Redirect::guest('/');
		}
	}
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});
