<?php

class Graphic extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];
	
	public function cqs()
	{
		return $this->hasMany('Cq');
	}
	
	public function getImgLinkAttribute()
	{
		$raw=$this->filedata;
		$s= "<img src=\"data:image/jpeg;base64,";
		$s.=base64_encode($raw);
		$s.="\">";
		return $s;
	}

}