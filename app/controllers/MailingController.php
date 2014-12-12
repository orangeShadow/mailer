<?php

class MailingController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /mailing
	 *
	 * @return Response
	 */
	public function index()
	{
		$mailings = Mailing::paginate(20);
        return View::make('mailing.index')->with(compact('mailings'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /mailing/create
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('mailing.create');
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /mailing
	 *
	 * @return Response
	 */
	public function store()
	{
        $validator = Validator::make(Input::all(),array('title'=>'required','template_id'=>"required","group_id"=>'required','content'=>'required','from_email'=>"email"));

        if (!$validator->fails()){
            $groups = implode(',',Input::get('group_id'));
            $mailing = new Mailing(Input::except('group_id'));
            $mailing->groups=$groups;
            if ($mailing->save()){
                if(Input::hasFile('file_path')){
                    $path = base_path().'/public/files/';
                    $name = $filename = Str::random(20) . '.' . Input::file('file_path')->guessExtension();
                    Input::file('file_path')->move($path,$name);
                    $mailing->file_path = $path.$name;
                    $mailing->save();
                }
                Session::flash('mailing.create',trans('mailing.messageCreate',array('id'=>$mailing->id)));
                return Redirect::to(URL::action('MailingController@index'));
            }
        }else{
            return Redirect::to(URL::action('MailingController@create'))->withInput(Input::except('_token'))->withErrors($validator->errors());
        }
	}

	/**
	 * Display the specified resource.
	 * GET /mailing/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$mailing = Mailing::find($id);
        $template = Template::find($mailing->template_id);
        return View::make('mailing.show')->with(compact('mailing','template'));
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /mailing/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $mailing = Mailing::find($id);
        return View::make('mailing.edit')->with(compact('mailing'));
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /mailing/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        $validator = Validator::make(Input::all(),array('title'=>'required','template_id'=>"required","group_id"=>'required','content'=>'required','from_email'=>"email"));

        if (!$validator->fails()){
            $groups = implode(',',Input::get('group_id'));
            $mailing = Mailing::findOrFail($id);
            $mailing->title= Input::get('title');
            $mailing->template_id = Input::get('template_id');
            $mailing->content = Input::get('content');
            $mailing->comment = Input::get('comment');
            $mailing->from_email = Input::get('from_email');
            $mailing->groups=$groups;

            if ($mailing->save()){

                if($mailing->file_path){
                    unset($mailing->file_path);
                }

                if(Input::hasFile('file_path')){
                    $path = base_path().'/public/files/';
                    $name = $filename = Str::random(20) . '.' . Input::file('file_path')->guessExtension();
                    Input::file('file_path')->move($path,$name);
                    $mailing->file_path = $path.$name;
                    $mailing->save();
                }
                Session::flash('mailing.edit',trans('mailing.messageEdit',array('id'=>$id)));
                return Redirect::to(URL::action('MailingController@edit',array('id'=>$id)));
            }
        }else{
            return Redirect::to(URL::action('MailingController@edit',array('id'=>$id)))->withInput(Input::except('_token'))->withErrors($validator->errors());
        }
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /mailing/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $template = Mailing::findOrFail($id);
        if ($template->delete()){
            DB::delete("DELETE FROM sanding WHERE  mailing_id=".$id);
            //DB::table('sanding')->delete(array('mauling_id'=>$id));
            Session::flash('template.destroy',trans('mailing.destroy',array('id'=>$id)));
            return Redirect::to(URL::action('MailingController@index'));
        }else{
            App::abort(500,trans('mailing.errorDelete'));
        }
	}

}