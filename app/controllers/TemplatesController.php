<?php

class TemplatesController extends \BaseController {

    public function __construct()
    {
        $this->beforeFilter('csrf', array('on' => array('post','put')));
    }


    /**
	 * Display a listing of the resource.
	 * GET /templates
	 *
	 * @return Response
	 */
	public function index()
	{
        $title = "Список шаблонов";
        $templates = Template::orderBy('id','desc')->paginate(20);
		return View::make('templates.index')->with(compact('title','templates'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /templates/create
	 *
	 * @return Response
	 */
	public function create()
	{
        Assets::add('//cdnjs.cloudflare.com/ajax/libs/ace/1.1.3/ace.js');
        $title = trans("templates.templateCreate");
        return View::make('templates.create')->with(compact('title'));
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /templates
	 *
	 * @return Response
	 */
	public function store()
	{
        $validator = Validator::make(Input::all(),array('title'=>'required'));
        if (!$validator->fails()){
            $template = new Template(Input::all());
            if ($template->save()){
                Session::flash('template.create',trans('messageCreate',array('id'=>$template->id)));
                return Redirect::to(URL::action('TemplatesController@index'));
            }
        }else{
            return Redirect::to(URL::action('TemplatesController@create'))->withInput(Input::except('_token'))->withErrors($validator->errors());
        }
	}

	/**
	 * Display the specified resource.
	 * GET /templates/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        Assets::reset();
		$template = Template::findOrFail(intval($id));
        return View::make('templates.show')->with(compact('template'));
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /templates/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        Assets::add('//cdnjs.cloudflare.com/ajax/libs/ace/1.1.3/ace.js');
        $title = trans("templates.templateEdit");
        $template = Template::findOrFail(intval($id));
        return View::make('templates.edit')->with(compact('template','title'));
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /templates/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        $validator = Validator::make(Input::all(),array('title'=>'required'));
        if (!$validator->fails()){
            $template = Template::findOrFail($id);
            $inputs = Input::except(array('_token','_method'));
            if ($template->update($inputs)){
                Session::flash('template.edit',trans('templates.messageEdit',array('id'=>$template->id)));
                return Redirect::to(URL::action('TemplatesController@edit',array('id'=>$template->id)));
            }
        }else{
            return Redirect::to(URL::action('TemplatesController@edit'))->withInput(Input::except('_token'))->withErrors($validator->errors());
        }
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /templates/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $template = Template::findOrFail($id);
		if ($template->delete()){
            Session::flash('template.destroy',trans('templates.destroy',array('id'=>$id)));
            return Redirect::to(URL::action('TemplatesController@index'));
        }else{
            App::abort(500,trans('templates.errorDelete'));
        }

	}

}