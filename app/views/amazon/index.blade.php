@extends('layout')

@section('page_title')
 &raquo; Amazon Search
@if (!empty($q))
 &raquo; {{ $q }}
@endif
@stop

@section('section_header')
<h2>Amazon Search</h2>
@stop

@section('section_label')
@if (!empty($q))
<h3>{{ $q }}</h3>
@endif
@stop

@section('content')

{{ Form::open( array( 'route' => 'amazon.index', 'method' => 'get', 'class' => 'form-horizontal' ) ) }}

<div class="form-group">
	{{ Form::label( 'q', 'Keywords', array( 'class' => 'col-md-2 control-label' ) ) }}
	<div class="col-md-10">
		{{ Form::text( 'q', $q, array( 'class' => 'form-control' ) ) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'category', 'Category', array( 'class' => 'col-md-2 control-label' ) ) }}
	<div class="col-md-10">
		{{ Form::select( 'category', Config::get( 'amazon.search_indexes' ), $category, array( 'class' => 'form-control' ) ) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'locale', 'Locale', array( 'class' => 'col-md-2 control-label' ) ) }}
	<div class="col-md-10">
		{{ Form::select( 'locale', Config::get( 'amazon.locales' ), $locale, array( 'class' => 'form-control' ) ) }}
	</div>
</div>

<div class="form-group">
	<div class="col-md-offset-2 col-md-10">
		{{ Form::submit( 'Search', array( 'class' => 'btn btn-default' ) ) }}
	</div>
</div>

{{ Form::close() }}

@if (!empty($results))

@if (!empty( $results->Request->Errors ))

<p>
	{{ $results->Request->Errors->Error->Message }}
</p>

@else
<table class="table">
	<thead>
	<tr>
		<th>ASIN</th>
		<th>Artist</th>
		<th>Title</th>
		<th>EAN</th>
		<th>UPC</th>
		<th>MPN</th>
	</tr>
	</thead>
	<tbody>
	@foreach ($results->Item as $result)
	<tr>
		<td><a href="{{ $result->DetailPageURL }}">{{ $result->ASIN }}</a></td>
		<td>
			@if (!empty($result->ItemAttributes->Artist))
			@if (is_array($result->ItemAttributes->Artist))
			<ul class="list-unstyled">
				@foreach ($result->ItemAttributes->Artist as $artist)
				<li>{{ $artist }}</pre></li>
				@endforeach
			</ul>
			@else
			{{ $result->ItemAttributes->Artist }}
			@endif
			@endif

			@if (!empty($result->ItemAttributes->Creator))
			@if (is_array($result->ItemAttributes->Creator))
			<ul class="list-unstyled">
				@foreach ($result->ItemAttributes->Creator as $creator)
				<li>{{ $creator }}</pre></li>
				@endforeach
			</ul>
			@else
			{{ $result->ItemAttributes->Creator }}
			@endif
			@endif

			@if (!empty($result->ItemAttributes->Author))
			@if (is_array($result->ItemAttributes->Author))
			<ul class="list-unstyled">
				@foreach ($result->ItemAttributes->Author as $author)
				<li>{{ $author }}</pre></li>
				@endforeach
			</ul>
			@else
			{{ $result->ItemAttributes->Author }}
			@endif
			@endif
		</td>
		<td>
			@if (!empty($result->ItemAttributes->Title))
			{{ $result->ItemAttributes->Title }}
			@endif
		</td>
		<td>
			@if (!empty($result->ItemAttributes->EAN))
			{{ $result->ItemAttributes->EAN }}
			@endif
		</td>
		<td>
			@if (!empty($result->ItemAttributes->UPC))
			{{ $result->ItemAttributes->UPC }}
			@endif
		</td>
		<td>
			@if (!empty($result->ItemAttributes->MPN))
			{{ $result->ItemAttributes->MPN }}
			@endif
		</td>
	</tr>
	@endforeach
	</tbody>
</table>

{{ $pagination->appends( array( 'q' => $q ) )->appends( array( 'category' => $category ) )->appends( array( 'locale' => $locale ) )->links() }}

@endif


@endif

@stop