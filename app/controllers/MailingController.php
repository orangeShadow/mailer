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
        return View::make('mailing.index')->with('mailings');
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
        $validator = Validator::make(Input::all(),array('title'=>'required','template_id'=>"required","group_id"=>'required','content'=>'required'));

        if (!$validator->fails()){
            $groups = implode(',',Input::get('group_id'));
            $mailing = new Mailing(Input::except('group_id'));
            $mailing->groups=$groups;

            if ($mailing->save()){
                if(!empty($mailing->groups)){
                    $res = DB::select('select email FROM subscriber_group as sg
                                JOIN subscribers as s on (s.id = sg.subscriber_id and deleted_at is null)
                                WHERE sg.group_id in ('.$mailing->groups.')');

                    foreach($res as  $row){
                        $sanding = new Sanding();
                        $sanding->email = $row->email;
                        $sanding->mailing_id = $mailing->id;
                        $sanding->save();
                    }
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
		//
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
        $validator = Validator::make(Input::all(),array('title'=>'required','template_id'=>"required","group_id"=>'required','content'=>'required'));

        if (!$validator->fails()){
            $groups = implode(',',Input::get('group_id'));
            $mailing = Mailing::findOrFail($id);
            $mailing->groups=$groups;

            if ($mailing->save()){
                if(!empty($mailing->groups)){
                    $res = DB::select('select email FROM subscriber_group as sg
                                JOIN subscribers as s on (s.id = sg.subscriber_id and deleted_at is null)
                                WHERE sg.group_id in ('.$mailing->groups.')');

                    foreach($res as  $row){
                        $sanding = new Sanding();
                        $sanding->email = $row->email;
                        $sanding->mailing_id = $mailing->id;
                        $sanding->save();
                    }
                }
                Session::flash('mailing.edit',trans('mailing.messageEdit',array('id'=>$mailing->id)));
                return Redirect::to(URL::action('MailingController@edit',array('id'=>$id)));
            }
        }else{
            return Redirect::to(URL::action('MailingController@edit'))->withInput(Input::except('_token'))->withErrors($validator->errors());
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
		//
	}

}