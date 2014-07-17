<?php

class GraphicsController extends \BaseController {

	/**
	 * Display a listing of graphics
	 *
	 * @return Response
	 */
	public function index()
	{
		$graphics = Graphic::all();

		return View::make('graphics.index', compact('graphics'));
	}

	/**
	 * Show the form for creating a new graphic
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('graphics.create');
	}

	/**
	 * Store a newly created graphic in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Graphic::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Graphic::create($data);

		return Redirect::route('graphics.index');
	}

	/**
	 * Display the specified graphic.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$graphic = Graphic::findOrFail($id);

		return View::make('graphics.show', compact('graphic'));
	}

	/**
	 * Show the form for editing the specified graphic.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$graphic = Graphic::find($id);

		return View::make('graphics.edit', compact('graphic'));
	}

	/**
	 * Update the specified graphic in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$graphic = Graphic::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Graphic::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$graphic->update($data);

		return Redirect::route('graphics.index');
	}

	/**
	 * Remove the specified graphic from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Graphic::destroy($id);

		return Redirect::route('graphics.index');
	}

}
