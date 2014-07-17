<?php

class Cq extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = ['question', 'a1','a2','a3','a4'];
	
	public function graphic()
	{
		return $this->belongsTo('Graphic');
	}
	
	public function tags()
    {
        return $this->belongsToMany('Tag');
    }

}