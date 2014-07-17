@extends('layouts.master')
@section('head')
<script>
  $(function() {
    var availableTags = [
    <?php
    $tags=Tag::all();
    ?>
    @foreach ($tags AS $tag)  
    "{{$tag->tag}}",
    @endforeach
    ];
    function split( val ) {
      return val.split( /,\s*/ );
    }
    function extractLast( term ) {
      return split( term ).pop();
    }
 
    $( "#tags" )
      // don't navigate away from the field on tab when selecting an item
      .bind( "keydown", function( event ) {
        if ( event.keyCode === $.ui.keyCode.TAB &&
            $( this ).autocomplete( "instance" ).menu.active ) {
          event.preventDefault();
        }
      })
      .autocomplete({
        minLength: 0,
        source: function( request, response ) {
          // delegate back to autocomplete, but extract the last term
          response( $.ui.autocomplete.filter(
            availableTags, extractLast( request.term ) ) );
        },
        focus: function() {
          // prevent value inserted on focus
          return false;
        },
        select: function( event, ui ) {
          var terms = split( this.value );
          // remove the current input
          terms.pop();
          // add the selected item
          terms.push( ui.item.value );
          // add placeholder to get the comma-and-space at the end
          terms.push( "" );
          this.value = terms.join( ", " );
          return false;
        }
      });
  });
  </script>
@stop

{{Form::model($cq, ['action'=>['CqsController@update',$cq->id],'method' => 'put', 'files'=>true])}}
{{Form::textarea('question')}}<br/>
{{Form::text('a1')}}<br/>
{{Form::text('a2')}}<br/>
{{Form::text('a3')}}<br/>
{{Form::text('a4')}}<br/>
<div>
{{Form::label('tags', 'Tags')}}
{{Form::text('tags',implode(', ', $cq->tags()->lists('tag')),['size'=>'40'])}}
</div>
@if ($cq->graphic_id != 0)
<div>{{$cq->graphic->img_link}}
{{Form::label('imgdelete', 'delete image?')}}
{{Form::checkbox('imgdelete', '1')}}
</div>
@endif
<div>
{{Form::label('image', 'Image')}}
{{Form::file('image')}}
{{Form::label('imagedesc', 'Image description')}}
{{Form::textarea('imagedesc', '')}}
</div>
<h3>or choose an existing file</h3>
<?php
$allimages=Graphic::all();
?>
<table>
<tr>
<td>
{{Form::radio('addimage', "0", true)}}
</td>
<td>
none
</td>
</tr>
@foreach ($allimages AS $g)
<tr>
<td>
{{Form::radio('addimage', "$g->id")}}
</td>
<td>
<?php
$s= "<img src=\"data:image/jpeg;base64,";
		$s.=base64_encode($g->filedata);
		$s.="\" width='200'>";
echo $s;	
?>
</td>
@endforeach
</table>
{{Form::submit('submit')}}
{{Form::close()}}