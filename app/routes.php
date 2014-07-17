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


Route::resource('cqs', 'CqsController');
Route::resource('graphics', 'GraphicsController');
Route::resource('tags', 'TagsController');

Route::get('/', function()
{
	return View::make('hello');
});

Route::get('hithere', function()
	{
		return "hi there";
	});

Route::get('autocomplete', function()
{
    return View::make('autocomplete');
});

Route::get('autocompletemultiple', function()
{
	$tags=Tag::all();
	return View::make('autocompletemultiple', compact('tags'));
});

Route::get('getdata', function()
{
    $term = Str::lower(Input::get('term'));
    $tags=Tag::all();
    $data2=array();
    foreach ($tags AS $tag)
    {
    	    $data2[$tag->id]=$tag->tag;
    };
    $data = array(
        'R' => 'Red',
        'O' => 'Orange',
        'Y' => 'Yellow',
        'G' => 'Green',
        'B' => 'Blue',
        'I' => 'Indigo',
        'V' => 'Violet',
    );
    $return_array = array();

    foreach ($data2 as $k => $v) {
        if (strpos(Str::lower($v), $term) !== FALSE) {
            $return_array[] = array('value' => $v, 'id' =>$k);
        }
    }
    return Response::json($return_array);
});


