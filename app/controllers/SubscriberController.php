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
		$subscribers  = Subscriber::paginate(50);
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
        $validator = Validator::make(Input::all(),array('email'=>'required|email'));
        if (!$validator->fails()){
            $subscriber = new Subscriber(Input::all());
            if ($subscriber->save()){
                Session::flash('subscriber.create',trans('subscriber.messageCreate',array('id'=>$subscriber->id)));
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
		//
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
        if ($template->delete()){
            Session::flash('template.destroy',trans('subscriber.destroy',array('id'=>$id)));
            return Redirect::to(URL::action('SubscriberController@index'));
        }else{
            App::abort(500,trans('templates.errorDelete'));
        }
	}

}