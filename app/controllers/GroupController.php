<?php

class GroupController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /group
	 *
	 * @return Response
	 */
	public function index()
	{
        $title=trans('group.groupList');
        $groups = Group::all();
		return View::make('group.index')->with(compact('title','groups'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /group/create
	 *
	 * @return Response
	 */
	public function create()
	{
        $title=trans('groupAdd');
        return View::make('group.create')->with(compact('title'));
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /group
	 *
	 * @return Response
	 */
	public function store()
	{
        $validator = Validator::make(Input::all(),array('title'=>'required'));
        if (!$validator->fails()){
            $group = new Group(Input::all());
            $group->place = 'mailer';
            if ($group->save()){
                Session::flash('group.create',trans('group.messageCreate',array('id'=>$group->id)));
                return Redirect::to(URL::action('GroupController@index'));
            }
        }else{
            return Redirect::to(URL::action('GroupController@create'))->withInput(Input::except('_token'))->withErrors($validator->errors());
        }
	}

	/**
	 * Display the specified resource.
	 * GET /group/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $count = 0;
		$group = Group::findOrFail($id);
        $res = DB::select("SELECT count(*) as c FROM subscriber_group as sg LEFT JOIN subscribers as s  on s.id = sg.subscriber_id and deleted_at is null WHERE group_id=:id",array("id"=>$id));
        if(!empty($res)){
            $count = $res[0]->c;
        }
        $subscribers = Subscriber::whereIn("id",function($query) use ($id){
            $query->select('subscriber_id')
                ->from('subscriber_group')
                ->where('group_id',$id);
        })->paginate(50);
        return View::make('group.show')->with(compact('group','count','subscribers'));
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /group/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $title = trans("group.groupEdit");
        $group = Group::findOrFail(intval($id));
        return View::make('group.edit')->with(compact('group','title'));
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /group/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        $validator = Validator::make(Input::all(),array('title'=>'required'));

        if(Input::get('email_list',false)){
            $this->groupListUpdate(Input::get('email_list'),$id);
        }

        if (!$validator->fails()){
            $group = Group::findOrFail($id);
            $inputs = Input::except(array('_token','_method','email_list'));
            if ($group->update($inputs)){
                Session::flash('group.edit',trans('group.messageEdit',array('id'=>$group->id)));
                return Redirect::to(URL::action('GroupController@edit',array('id'=>$group->id)));
            }

        }else{
            return Redirect::to(URL::action('GroupController@edit'))->withInput(Input::except('_token'))->withErrors($validator->errors());
        }
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /group/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{

        if (Group::destroy($id)){
            Session::flash('group.destroy',trans('group.destroy',array('id'=>$id)));
            return Redirect::to(URL::action('GroupController@index'));
        }else{
            App::abort(500,trans('group.errorDelete'));
        }
	}


    /**
     * Update usergrouplist
     */
    private function groupListUpdate($userList,$group_id)
    {
        $array = explode("\n",$userList);

        foreach($array as $email){
            try{
                $email = trim($email);
                
                $res = DB::select(DB::raw('SELECT * FROM subscribers WHERE email="'.$email.'" or email like "%'.$email.'%"') );
                if(!empty($res[0])){
                    $id = $res[0]->id;
                }else{
                    $dt = new DateTime();
                    $id = DB::table('subscribers')->insertGetId(array('email'=>$email,'created_at'=>$dt->format("Y-m-d H:i:s"),'place'=>'csv'));
                }
                if(!empty($id)){
                    DB::table('subscriber_group')->insert(array('subscriber_id'=>$id,'group_id'=>$group_id));
                }
            }catch(Exception $e){
                continue;
            }
        }
    }
}