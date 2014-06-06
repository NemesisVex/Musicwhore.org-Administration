@extends('layout')

@section('section_head')
<h2>Login</h2>
@stop

@section('content')

<div class="col-md-8">
	{{ Form::open( array( 'action' => 'AuthController@sign_in' ) ) }}

	<div class="form-group">
		{{ Form::label('user_name', 'User name:' ) }}
		{{ Form::text('user_name', null, array( 'class' => 'form-control' ) ) }}
	</div>

	<div class="form-group">
		{{ Form::label('user_password', 'Password:' ) }}
		{{ Form::password('user_password', array( 'class' => 'form-control' ) ) }}
	</div>

	{{ Form::submit('Login', array( 'class' => 'btn btn-default' ) ) }}

	{{ Form::close() }}
</div>


@stop
