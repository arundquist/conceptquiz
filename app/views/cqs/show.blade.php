@extends('layouts.master')
@section('css')
span.correct:hover
{ 
border:5px solid black;
}

@stop
@section('main')
<div style="font-size: 200%;">
{{$cq->question}}
<?php
$answers=[$cq->a1, $cq->a2, $cq->a3, $cq->a4];
shuffle($answers);
?>
<?php
$colors=['blue','red','green','yellow'];
$textcolors=['white', 'white', 'white', 'black'];
$correctkey=array_search($cq->a1, $answers);
?>

<ol>
@foreach ($answers AS $key=>$answer)
<li><span 
@if ($key==$correctkey)
class="correct" 
@endif
style="background-color: {{$colors[$key]}}; color: {{$textcolors[$key]}};font-weight:bold;">{{$answer}}</span></li>
@endforeach
</ol>
<div>
@if ($cq->graphic_id!=0)
{{$cq->graphic->img_link}}<br/>
@foreach ($cq->graphic->cqs AS $othercq)
	@if($othercq->id != $cq->id)
		{{link_to_route('cqs.show', $othercq->id,[$othercq->id])}}
	@endif
@endforeach
@endif
</div>

<hr/>
tags: 
@foreach ($cq->tags as $tag)
{{link_to_action('TagsController@show', "{$tag->tag}", [$tag->id])}}, 
@endforeach

</div>
{{link_to_route('cqs.edit', "edit", [$cq->id])}}
@stop