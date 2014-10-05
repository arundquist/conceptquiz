<?php

class CqsController extends \BaseController {

	/**
	 * Display a listing of cqs
	 *
	 * @return Response
	 */
	 
	public function __construct()
	{
		$this->beforeFilter('auth.basic', array('only' => ['edit', 'create']));
	
	}
	 
	public function index()
	{
		$cqs = Cq::orderBy('id','DESC')->get();

		return View::make('cqs.index', compact('cqs'));
	}

	/**
	 * Show the form for creating a new cq
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('cqs.create');
	}

	/**
	 * Store a newly created cq in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Cq::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		//Cq::create($data);
		$tagids=array();
		$tags=explode(',', Input::get('tags'));
		// for the moment it might or might not end with a comma
		// so you might have a blank tag at the end. 
		// I guess I can just look to see if it's blank
		foreach ($tags AS $tag)
		{
			if ($tag != ' ')
			{
				$tag=trim($tag);
				$t=Tag::firstOrCreate(['tag'=>$tag]);
				$tagids[]=$t->id;
			};
		};
		
		
		$cq=Cq::create($data);
		if (Input::hasFile('image'))
		{
			$graphic=new Graphic;
			$graphic->filename=Input::file('image')->getClientOriginalName();
			$graphic->filesize=Input::file('image')->getSize();
			$graphic->filetype=Input::file('image')->getMimeType();
			$graphic->filedata=file_get_contents(Input::file('image')->getRealPath());
			$graphic->comments=Input::get('imagedesc');
			$graphic->save();
		
			$graphic->cqs()->save($cq);
		};
		$cq->tags()->sync($tagids);
		
		if (Input::get('addimage') != 0)
			$cq->graphic_id=Input::get('addimage');
		$cq->save();

		return Redirect::route('cqs.index');
		
	}

	/**
	 * Display the specified cq.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$cq = Cq::findOrFail($id);

		return View::make('cqs.show', compact('cq'));
	}

	/**
	 * Show the form for editing the specified cq.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$cq = Cq::find($id);

		return View::make('cqs.edit', compact('cq'));
	}

	/**
	 * Update the specified cq in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$cq = Cq::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Cq::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$cq->update($data);
		
		$tagids=array();
		$tags=explode(',', Input::get('tags'));
		// for the moment it might or might not end with a comma
		// so you might have a blank tag at the end. 
		// I guess I can just look to see if it's blank
		foreach ($tags AS $tag)
		{
			if ($tag != ' ')
			{
				$tag=trim($tag);
				$t=Tag::firstOrCreate(['tag'=>$tag]);
				$tagids[]=$t->id;
			};
		};
		$cq->tags()->sync($tagids);
		if (Input::get('imgdelete'))
			$cq->graphic_id = 0;
		if (Input::hasFile('image'))
		{
			$graphic=new Graphic;
			$graphic->filename=Input::file('image')->getClientOriginalName();
			$graphic->filesize=Input::file('image')->getSize();
			$graphic->filetype=Input::file('image')->getMimeType();
			$graphic->filedata=file_get_contents(Input::file('image')->getRealPath());
			$graphic->comments=Input::get('imagedesc');
			$graphic->save();
		
			$graphic->cqs()->save($cq);
		};
		
		if (Input::get('addimage') != 0)
			$cq->graphic_id=Input::get('addimage');
		$cq->save();
		return Redirect::route('cqs.show',[$cq->id]);
	}

	/**
	 * Remove the specified cq from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Cq::destroy($id);

		return Redirect::route('cqs.index');
	}

}
