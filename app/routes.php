<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
    if(Auth::check()){
        $title = 'Рабочий стол';
        return View::make('hello')->with(compact('title'));
    }else{
        return View::make('auth.login');
    }
});


//Authentificate
Route::post('/login',array('as'=>'login',function()
{
    $email = Input::get('email');
    $password = Input::get('password');
    $remember = Input::has('remember') ? true:false;
    if (Auth::attempt(array('email' => $email, 'password' => $password),$remember)) {
        return Redirect::to('/')->with('success', 'You have been logged in');
    }
    else {
        return Redirect::to('/')->withErrors(array('login'=>'Логин или пароль введен не верно.'));
    }

    return View::make('auth.login');
}));

//Logout
Route::get('/logout',array('as'=>'logout',function() {
    Auth::logout();
    return Redirect::to('/')->with('success', 'You have successfully logged out');
}));

//auth
Route::group(array('before' => 'auth'), function(){
    Route::controller('filemanager', 'FilemanagerLaravelController');
    Route::resource('templates', 'TemplatesController');
    Route::resource('group', 'GroupController');
    Route::resource('mailing', 'MailingController');
    Route::resource('subscriber', 'SubscriberController');

    Route::get('/groupToSubscribe',function(){
        $groups = Group::all();
        $subscriber = Subscriber::all();
        return View::make('group.subscriber')->with(compact('groups','subscriber'));
    });

    Route::post('/groupToSubscribe',function(){
        $group_id = Input::get('group_id');
        $subscribers= Input::get('subscriber_id',array());

        foreach($subscribers as $item){
            $subscriberGroups = new SubscriberGroup();
            $subscriberGroups->group_id = $group_id;
            $subscriberGroups->subscriber_id = $item;
            try{
                $subscriberGroups->save();
            }catch(Exception $e){
                continue;
            }

        }
        return Redirect::to(URL::action("SubscriberController@index"));
    });

    Route::get('/addSubscriberCSV',function(){
        return View::make('group.addsubscriberCSV');
    });

    Route::post('/addSubscriberCSV',function(){
        if (Input::hasFile('csv'))
        {
            $file = Input::file('csv');
            $h = fopen($file->getRealPath(),'r');
            while($row = fgets($h)){
                try{
                    $id = DB::table('subscribers')->insertGetId(array('email'=>$row,'place'=>'csv'));
                    DB::table('subscriber_group')->insert(array('subscriber_id'=>$id,'group_id'=>Input::get('group_id')));
                    exit();
                }catch(Exception $e){
                    continue;
                }
            }
            fclose($h);

        }
        Session::flash('subscriber.csv',trans('subscriber.messageCSV'));
        return Redirect::to(URL::action('SubscriberController@index'));
    });
    Route::get('/sql',function(){
       return View::make('sql');
    });
    Route::post('/sql',function(){
        if(Input::get('q',false)){
            $data = DB::select(DB::raw(Input::get('q'))->getValue());
        }
        return View::make('sql')->with(compact('data'));
    });
});