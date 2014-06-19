@extends('artist._form')

@section('content')

@parent

<h4>Settings</h4>

<div class="form-group">
	{{ Form::label( 'musicbrainz_gid', 'Musicbrainz GID:', array( 'class' => 'col-sm-2 control-label' ) ) }}
	<div class="col-sm-10">
		{{ Form::text( 'musicbrainz_gid', $gid, array( 'class' => 'form-control' ) ) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'default_amazon_locale', 'Default Amazon locale:', array( 'class' => 'col-sm-2 control-label' ) ) }}
	<div class="col-sm-10">
		{{ Form::select( 'default_amazon_locale', Config::get( 'amazon.locales' ), $default_amazon_locale, array( 'class' => 'form-control' ) ) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'default_itunes_store', 'Default iTunes store:', array( 'class' => 'col-sm-2 control-label' ) ) }}
	<div class="col-sm-10">
		{{ Form::select( 'default_itunes_store', Config::get( 'itunes.locales' ), $default_itunes_store, array( 'class' => 'form-control' ) ) }}
	</div>
</div>

<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
		{{ Form::submit( 'Save', array( 'class' => 'btn btn-default' ) ) }}
	</div>
</div>

@stop