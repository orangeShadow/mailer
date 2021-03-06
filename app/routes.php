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

    Route::get('/group/fromAPI',function(){
        return View::make('group.api');
    });
    Route::post('/group/fromAPI',function(){
        $type =Input::get('type',null);
        $groups = Input::get('groups',null);
        $group_id = Input::get('group_id',null);
        if(isset($type) && !isset($groups)){
            if(Input::get('type')==0){
                $res = \MyLibraries\CRoumingu::getKopilkaGroups();
            }if(Input::get('type')==1){
                $res = \MyLibraries\CRoumingu::getContragentsGroups();
            }if(Input::get('type')==2){
                $std = new stdClass();
                $std->groupID=100;
                $std->groupName="Все";
                $res = new stdClass();
                $res->data_array = array($std);
            }
            $html = '<div class="form-group">';
            $html.= '<label  class="col-sm-2 control-label">Выберите группу из API:</label>';
            $html.= '<div class="col-sm-10"><div class="checkbox">';
            foreach($res->data_array as $item){
                $html.= '<label>';
                $html.= Form::checkbox('groups[]',$item->groupID);
                $html.= $item->groupName;
                $html.="</label><br>";

            }
            $html.= Form::hidden('type',$type);
            $html.= '</div></div></div>';

            $html.= '<div class="form-group">';
            $html.= '<label  class="col-sm-2 control-label">Выберите целевую группу:</label>';
            $html.= '<div class="col-sm-10">';
            $html.= Form::select('group_id',Group::lists('title','id'),false,array('class'=>'form-control'));
            $html.= '</div>';
            $html.= '</div>';
            $resp = new StdClass();
            $resp->error= 0;
            $resp->type='group';
            $resp->html = $html;
            return json_encode($resp,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
        }elseif(isset($type) && isset($groups) && isset($group_id)){
            if(Input::get('type')==0){
                $res = \MyLibraries\CRoumingu::getKopilkaEmails(implode(',',$groups));
            }elseif(Input::get('type')==1){
                $res = \MyLibraries\CRoumingu::getContragentsEmails(implode(',',$groups));
            }
            else{
                $res = \MyLibraries\CRoumingu::getCorpclientsEmails();
            }
            $resp = new stdClass();
            if($res->error == 1){
                $resp->error =1;
                $resp->html ="Выбранные группы пусты";
            }else{
                $emails = array();
                if(!empty($res->data_array)){
                    $resp->count = count($res->data_array );
                    foreach($res->data_array as $item)
                    {

                        $emails[] ="'".$item->email."'";
                    }
                    $resEmail = DB::select(DB::raw('SELECT id,email FROM subscribers where LOWER (email) in ('.implode(',',$emails).')'));
                    $emailsClean = array();
                    $emailsCleanID = array();
                    foreach($resEmail as $item){
                        $emailsClean[] = $item->email;
                        $emailsCleanID[] = $item->id;
                    }
                    if(!empty($emailsCleanID)) {
                        DB::delete(DB::raw("DELETE FROM subscriber_group WHERE subscriber_id in(". implode(',', $emailsCleanID).")"));
                    }
                    foreach($emails  as $email){
                        $email = trim($email,"'");
                        $lemail = strtolower($email);
                        if(!in_array($email,$emailsClean) && !in_array($lemail,$emailsClean)){
                            try{
                                $id = DB::table('subscribers')->insertGetId(array('email'=>$email,'place'=>'api'));
                            }catch(Exception $e){
                                $list = DB::select(DB::raw('SELECT id FROM subscribers WHERE email like "%'.$email.'%"'));
                                if(!empty($list[0])){
                                    $id = $list[0]->id;
                                }
                            }

                            $emailsCleanID[] = $id;
                        }
                    }
                    $emailsCleanID =array_unique($emailsCleanID);
                    foreach($emailsCleanID as $sid){
                            DB::table('subscriber_group')->insert(array('subscriber_id'=>$sid,'group_id'=>$group_id));
                    }
                    $resp->error =0;
                    $resp->type='complite';
                    $resp->html = 'Готово';
                }

            }
            return json_encode($resp,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
        }
    });

    Route::get('/mailing/start',function(){
        $id=Input::get('id',false);
        if($id){
            try{
                $mailing = Mailing::findOrFail($id);
                $count = DB::table('sanding')->where(array('mailing_id'=>$mailing->id))->count('*');
                if($count>0){
                    DB::table('sanding')->where(array('mailing_id'=>$mailing->id))->update(array('stop'=>0));
                    Session::flash('template.message',trans('mailing.start',array('id'=>$id)));
                    return Redirect::to(URL::action('MailingController@index'));
                }else{
                    if(!empty($mailing->groups)){
                        $dt = new DateTime();
                         $query ='INSERT INTO sanding (email,sendAfter,mailing_id,stop)
                                    SELECT email,"'.$dt->format('Y-m-d H:i:s').'" as sendAfter,'.$mailing->id.' as mailing_id, 0 as stop
                                    FROM subscriber_group as sg
                                    JOIN subscribers as s on (s.id = sg.subscriber_id and deleted_at is null)
                                    WHERE sg.group_id in('.$mailing->groups.')';
                        DB::insert($query);

                        Session::flash('template.message',trans('mailing.newStart',array('id'=>$id)));
                        return Redirect::to(URL::action('MailingController@index'));
                    }
                }

            }catch(Exception $e){
                $resp = new StdClass();
                $resp->error = 1;
                $resp->message = 'Mailing not found';
                echo json_encode($resp,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
                return ;
            }

        }
    });
    Route::get('/mailing/stop',function(){
        $id=Input::get('id',false);
        if($id){
            try{
                $mailing = Mailing::findOrFail($id);
                DB::table('sanding')->where(array('mailing_id'=>$mailing->id))->update(array('stop'=>1));
                Session::flash('template.message',trans('mailing.stop',array('id'=>$id)));
                return Redirect::to(URL::action('MailingController@index'));
            }catch(Exception $e){
                $resp = new StdClass();
                $resp->error = 1;
                $resp->message = 'Mailing not found';
                echo json_encode($resp,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
                return ;
            }
        }
    });
    Route::get('/mailing/clean',function(){
        $id=Input::get('id',false);
        if($id){
            try{
                $mailing = Mailing::findOrFail($id);
                DB::delete("DELETE FROM sanding WHERE  mailing_id=".$mailing->id);
                Session::flash('template.message',trans('mailing.clean',array('id'=>$id)));
                return Redirect::to(URL::action('MailingController@index'));
            }catch(Exception $e){
                $resp = new StdClass();
                $resp->error = 1;
                $resp->message = 'Mailing not found';
                echo json_encode($resp,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
                return ;
            }
        }
    });

    Route::get('/group/fromCSV',function()
    {
        return View::make('group.csv');
    });
    Route::post('/group/fromCSV',function()
    {
        set_time_limit(0);
        if (Input::hasFile('csv'))
        {
            $file = Input::file('csv');
            $h = fopen($file->getRealPath(),'r');

            if(Input::has('clean')) {
                DB::delete(DB::raw("DELETE FROM subscriber_group WHERE group_id =".Input::get('group_id')));
            }

            while($row = fgets($h)){
                try{
                    $validator = Validator::make(array("email"=>trim($row)),array("email"=>"email"));

                    if($validator->fails()) continue;

                    $res = DB::select(DB::raw('SELECT * FROM subscribers WHERE email="'.trim($row).'" or email like "%'.trim($row).'%"') );
                    if(!empty($res[0])){
                        $id = $res[0]->id;
                    }else{
                        $dt = new DateTime();
                        $id = DB::table('subscribers')->insertGetId(array('email'=>$row,'created_at'=>$dt->format("Y-m-d H:i:s"),'place'=>'csv'));
                    }
                    if(!empty($id)){
                        DB::table('subscriber_group')->insert(array('subscriber_id'=>$id,'group_id'=>Input::get('group_id')));
                    }
                }catch(Exception $e){
                    echo $e->GetMessage();
                }
            }
            fclose($h);
        }
        Session::flash('subscriber.csv',trans('subscriber.messageCSV'));
        return Redirect::to(URL::action('SubscriberController@index'));
    });

    Route::post('/group/user_remove',function(){
        $id = Input::get('id');
        $group_id = Input::get('group_id');
        DB::table('subscriber_group')->where(array('subscriber_id'=>$id,'group_id'=>$group_id))->delete();
        return "Y";
    });

    Route::controller('filemanager', 'FilemanagerLaravelController');
    Route::resource('templates', 'TemplatesController');
    Route::resource('group', 'GroupController');
    Route::resource('mailing', 'MailingController');
    Route::resource('subscriber', 'SubscriberController');

    Route::get('mailing/{id}/removeFile/',function($id){
        $mailing = Mailing::find($id);
        \File::delete($mailing->file_path);
        $mailing->file_path=null;
        $mailing->save();
    });


    Route::get('/groupToSubscribe',function()
    {
        $groups = Group::all();
        $subscriber = Subscriber::all();
        return View::make('group.subscriber')->with(compact('groups','subscriber'));
    });
    Route::post('/groupToSubscribe',function()
    {
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

    /**
     * Читска адресов
     */
    Route::get('/cleanEmail',function()
    {
        $badID = array();
        $k =0;
        $skip = 14000;
        //while($skip<240000){
            $subscribers  = Subscriber::skip($skip)->take(2000)->get();
            if(!empty($subscribers)){
                foreach($subscribers as $item){
                    list($user, $domain) = explode("@", trim($item->email), 2);
                    if (!checkdnsrr($domain,"MX") && !checkdnsrr($domain,"A")) {
                        $badID[] = $item->id;
                    }
                    $k++;
                }
            }
        if(count($badID)>0){
            Subscriber::destroy($badID);
        }
            //$skip+=10000;
        //}
        echo "Всего: ".$k."<br>";
        count($badID);
        return;
    });

    /**
     * SQL запрос
     **/
    Route::get('/sql',function()
    {
       return View::make('sql');
    });
    Route::post('/sql',function()
    {
        $error=null;
        if(Input::get('q',false)){
            try{
                if(Input::get('d',false)){
                    $data = DB::delete(DB::raw(Input::get('q'))->getValue());
                }elseif(Input::get('u',false)){
                    $data = DB::update(DB::raw(Input::get('q'))->getValue());
                }else{
                    $data = DB::select(DB::raw(Input::get('q'))->getValue());
                }
            }catch(Exception $e){
                $error =$e;
            }
        }
        return View::make('sql')->with(compact('data','error'));
    });
});

Route::get('/unsubscribe',function(){
    $resp = new stdClass();
    if(Input::get('email',false)){
        $email = Input::get('email');
        $res = DB::table('subscribers')->where('email','like',$email."%")->where('deleted_at',null)->select('id','email')->first();
        if(!empty($res->id)){
            $sub = Subscriber::find($res->id);
            DB::table('subscriber_group')->where("subscriber_id",'=',$res->id)->delete();
            $sub->delete();
            $resp->error = 0;
        }else{
            $resp->error =1 ;
            $resp->message = 'Not Found';
        }
    }else{
        $resp->error =1 ;
        $resp->message = 'Not Found';
    }
    echo json_encode($resp,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
    return;
});

Route::get('addemail',function(){
    $validator = Validator::make(Input::except('group_id'),array('email'=>'required|email|unique:subscribers'));
    if (!$validator->fails()){
        $subscriber = new Subscriber(Input::except('group_id'));
        if ($subscriber->save()){
            Session::flash('subscriber.create',trans('subscriber.messageCreate',array('id'=>$subscriber->id)));
            DB::table('subscriber_group')->insert(array('subscriber_id'=>$subscriber->id,'group_id'=>2));
            $mes = new stdClass();
            $mes->error =0;
            return json_encode($mes);
        }
    }else{
        if(Input::get('email',null)) {
            $subs = Subscriber::where('email',Input::get('email',null))->withTrashed()->get()->first();
            $subs->restore();
            $mes = new stdClass();
            $mes->error =0;
            return json_encode($mes);
        }else{
            return $validator->errors()->toJson();
        }
    }
});