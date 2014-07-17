<h1>{{$tag->tag}}</h1>
@foreach($tag->cqs as $cq)
{{link_to_action('CqsController@show', "{$cq->question}", [$cq->id])}}
<hr/>
@endforeach

