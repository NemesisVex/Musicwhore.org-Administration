@extends('ecommerce._form')

@section('page_title')
@stop

@section('section_header')
@stop

@section('section_label')
@stop

@section('content')
{{ Form::model( $ecommerce, array( 'route' => 'ecommerce.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post' ) ) }}
@parent
{{ Form::close() }}
@stop
