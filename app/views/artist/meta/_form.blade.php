@extends('layout')

@section('content')
<div class="form-group">
	{{ Form::label( 'is_asian_name', 'Use Asian name format:', array( 'class' => 'col-sm-3' ) ) }}
	<div class="col-sm-9">
		<div class="radio">
			<label>
				{{ Form::radio( 'is_asian_name', 1, ($artist->meta->is_asian_name == 1) ) }} Yes
			</label>
		</div>
		<div class="radio">
			<label>
				{{ Form::radio( 'is_asian_name', 0, ($artist->meta->is_asian_name == 0) ) }} No
			</label>
		</div>
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'is_je_artist', 'J~E artist:', array( 'class' => 'col-sm-3' ) ) }}
	<div class="col-sm-9">
		<div class="radio">
			<label>
				{{ Form::radio( 'is_je_artist', 1, ($artist->meta->is_je_artist == 1) ) }} Yes
			</label>
		</div>
		<div class="radio">
			<label>
				{{ Form::radio( 'is_je_artist', 0, ($artist->meta->is_je_artist == 0) ) }} No
			</label>
		</div>
	</div>
</div>

<div class="col-sm-offset-3 col-sm-9">
	{{ Form::submit( 'Save', array( 'class' => 'button' ) ) }}
</div>
@stop