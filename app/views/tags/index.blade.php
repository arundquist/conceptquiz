<ul>
@foreach ($tags as $tag)
<li>{{link_to_action('TagsController@show', "{$tag->tag}", [$tag->id])}}({{$tag->cqs()->count()}}) </li>
@endforeach
</ul>