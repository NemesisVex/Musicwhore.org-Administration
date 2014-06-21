@extends('layout')

@section('content')

<div class="form-group">
	{{ Form::label( 'member_parent_id', 'Parent artist:', array( 'class' => 'col-sm-2 control-label' ) ) }}
	<div class="col-sm-10">
		{{ Form::select( 'member_parent_id', $artists, $member->member_parent_id, array( 'class' => 'form-control' ) ) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'member_artist_id', 'Artist:', array( 'class' => 'col-sm-2 control-label', 'id' => 'member-artist-label', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Associate an artist currently in the database' ) ) }}
	<div class="col-sm-10">
		{{ Form::select( 'member_artist_id', $artists, $member->member_artist_id, array( 'class' => 'form-control' ) ) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'member_last_name', 'Last name:', array( 'class' => 'col-sm-2 control-label' ) ) }}
	<div class="col-sm-10">
		{{ Form::text( 'member_last_name', $member->member_last_name, array( 'class' => 'form-control' ) ) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'member_first_name', 'First name:', array( 'class' => 'col-sm-2 control-label' ) ) }}
	<div class="col-sm-10">
		{{ Form::text( 'member_first_name', $member->member_first_name, array( 'class' => 'form-control' ) ) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'member_display_name', 'Display name:', array( 'class' => 'col-sm-2 control-label' ) ) }}
	<div class="col-sm-10">
		{{ Form::text( 'member_display_name', $member->member_display_name, array( 'class' => 'form-control' ) ) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'member_order', 'Order:', array( 'class' => 'col-sm-2 control-label' ) ) }}
	<div class="col-sm-10">
		{{ Form::text( 'member_order', $member->member_order, array( 'class' => 'form-control' ) ) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'member_instruments', 'Instruments:', array( 'class' => 'col-sm-2 control-label' ) ) }}
	<div class="col-sm-10">
		{{ Form::text( 'member_instruments', $member->member_instruments, array( 'class' => 'form-control' ) ) }}
	</div>
</div>

<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
		{{ Form::submit( 'Save', array( 'class' => 'btn btn-default' ) ) }}
	</div>
</div>

<script type="text/javascript">
	(function ($) {
		$(function () {
			$('#member_parent_id').chosen();
			$('#member_artist_id').chosen();
			$('#member-artist-label').tooltip();
		});
	})(jQuery);
</script>

@stop