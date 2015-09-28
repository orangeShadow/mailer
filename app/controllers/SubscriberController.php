<?php

class SubscriberController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /subscriber
	 *
	 * @return Response
	 */
	public function index()
	{
        if(Input::get('email',false)){
            $subscribers  = Subscriber::where('email','like','%'.Input::get('email').'%')->withTrashed()->paginate(100);
        }else{
            $subscribers  = Subscriber::paginate(100);
        }

        $title = trans('subscriber.title');
        return View::make('subscriber.index')->with(compact('subscribers','title'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /subscriber/create
	 *
	 * @return Response
	 */
	public function create()
	{
	    $title = trans('subscriber.createSubscriber');
        return View::make('subscriber.create')->with(compact('title'));
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /subscriber
	 *
	 * @return Response
	 */
	public function store()
	{

        $validator = Validator::make(Input::except('group_id'),array('email'=>'required|email|unique:subscribers'));
        if (!$validator->fails()){
            $subscriber = new Subscriber(Input::except('group_id'));

            if ($subscriber->save()){
                Session::flash('subscriber.create',trans('subscriber.messageCreate',array('id'=>$subscriber->id)));
                $groups = Input::get('group_id',null);
                if(!empty($groups)){
                    foreach($groups as $gr_id){
                        DB::table('subscriber_group')->insert(array('subscriber_id'=>$subscriber->id,'group_id'=>$gr_id));
                    }
                }
                return Redirect::to(URL::action('SubscriberController@index'));
            }

        }else{
            return Redirect::to(URL::action('SubscriberController@create'))->withInput(Input::except('_token'))->withErrors($validator->errors());
        }
	}

	/**
	 * Display the specified resource.
	 * GET /subscriber/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /subscriber/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /subscriber/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        $el = Subscriber::find($id)->withTrashed()->restore();
        Session::flash('template.success','Пользователь восстановлен');
        return Redirect::to(URL::action('SubscriberController@index'));
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /subscriber/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $template = Subscriber::findOrFail($id);
        DB::table('subscriber_group')->where("subscriber_id",'=',$id)->delete();
        if ($template->delete()){
            Session::flash('template.destroy',trans('subscriber.destroy',array('id'=>$id)));
            return Redirect::to(URL::action('SubscriberController@index'));
        }else{
            App::abort(500,trans('templates.errorDelete'));
        }
	}

}