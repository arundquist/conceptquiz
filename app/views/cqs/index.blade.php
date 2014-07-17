@foreach ($cqs as $cq)
{{link_to_action('CqsController@show', "{$cq->id}", [$cq->id])}}: {{$cq->question}}
<hr/>
@endforeach