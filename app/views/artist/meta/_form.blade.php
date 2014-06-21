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

<div class="form-group">
	{{ Form::label( 'is_classical_artist', 'Classical artist:', array( 'class' => 'col-sm-3' ) ) }}
	<div class="col-sm-9">
		<div class="radio">
			<label>
				{{ Form::radio( 'is_classical_artist', 1, ($artist->meta->is_classical_artist == 1) ) }} Yes
			</label>
		</div>
		<div class="radio">
			<label>
				{{ Form::radio( 'is_classical_artist', 0, ($artist->meta->is_classical_artist == 0) ) }} No
			</label>
		</div>
	</div>
</div>

<h4>Navigation display</h4>

<div class="form-group">
	{{ Form::label( 'nav_profile', 'Profile:', array( 'class' => 'col-sm-3' ) ) }}
	<div class="col-sm-9">
		<div class="radio">
			<label>
				{{ Form::radio( 'nav_profile', 1, ($artist->meta->nav_profile == 1) ) }} Yes
			</label>
		</div>
		<div class="radio">
			<label>
				{{ Form::radio( 'nav_profile', 0, ($artist->meta->nav_profile == 0) ) }} No
			</label>
		</div>
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'nav_discography', 'Discography:', array( 'class' => 'col-sm-3' ) ) }}
	<div class="col-sm-9">
		<div class="radio">
			<label>
				{{ Form::radio( 'nav_discography', 1, ($artist->meta->nav_discography == 1) ) }} Yes
			</label>
		</div>
		<div class="radio">
			<label>
				{{ Form::radio( 'nav_discography', 0, ($artist->meta->nav_discography == 0) ) }} No
			</label>
		</div>
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'nav_posts', 'Posts:', array( 'class' => 'col-sm-3' ) ) }}
	<div class="col-sm-9">
		<div class="radio">
			<label>
				{{ Form::radio( 'nav_posts', 1, ($artist->meta->nav_posts == 1) ) }} Yes
			</label>
		</div>
		<div class="radio">
			<label>
				{{ Form::radio( 'nav_posts', 0, ($artist->meta->nav_posts == 0) ) }} No
			</label>
		</div>
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'nav_shop', 'Shop:', array( 'class' => 'col-sm-3' ) ) }}
	<div class="col-sm-9">
		<div class="radio">
			<label>
				{{ Form::radio( 'nav_shop', 1, ($artist->meta->nav_shop == 1) ) }} Yes
			</label>
		</div>
		<div class="radio">
			<label>
				{{ Form::radio( 'nav_shop', 0, ($artist->meta->nav_shop == 0) ) }} No
			</label>
		</div>
	</div>
</div>

<h4>Ecommerce and external services</h4>

<div class="form-group">
	{{ Form::label( 'default_amazon_locale', 'Default Amazon locale:', array( 'class' => 'col-sm-3' ) ) }}
	<div class="col-sm-9">
		{{ Form::select( 'default_amazon_locale', Config::get('amazon.locales'), $artist->meta->default_amazon_locale, array( 'class' => 'form-control' ) ) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'default_itunes_store', 'Default iTunes store:', array( 'class' => 'col-sm-3' ) ) }}
	<div class="col-sm-9">
		{{ Form::select( 'default_itunes_store', Config::get('itunes.locales'), $artist->meta->default_itunes_store, array( 'class' => 'form-control' ) ) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'itunes_id', 'iTunes ID:', array( 'class' => 'col-sm-3' ) ) }}
	<div class="col-sm-7">
		{{ Form::text( 'itunes_id', $artist->meta->itunes_id, array( 'class' => 'form-control' ) ) }}
	</div>
	<div class="col-sm-2">
		<a href="{{ route( 'artist-itunes.index', array( 'artist' => $artist->artist_id ) ) }}" class="btn btn-default btn-sm">Look up</a>
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'discogs_artist_id', 'Discogs ID:', array( 'class' => 'col-sm-3' ) ) }}
	<div class="col-sm-9">
		{{ Form::text( 'discogs_artist_id', $artist->meta->discogs_artist_id, array( 'class' => 'form-control' ) ) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'musicbrainz_gid', 'Musicbrainz GID:', array( 'class' => 'col-sm-3' ) ) }}
	<div class="col-sm-7">
		{{ Form::text( 'musicbrainz_gid', $artist->meta->musicbrainz_gid, array( 'class' => 'form-control' ) ) }}
	</div>
	<div class="col-sm-2">
		<a href="{{ route( 'artist-musicbrainz.index', array( 'artist' => $artist->artist_id ) ) }}" class="btn btn-default btn-sm">Look up</a>
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'yesasia_id', 'YesAsia ID:', array( 'class' => 'col-sm-3' ) ) }}
	<div class="col-sm-9">
		{{ Form::text( 'yesasia_id', $artist->meta->yesasia_id, array( 'class' => 'form-control' ) ) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label( 'emusic_cjsku', 'eMusic SKU:', array( 'class' => 'col-sm-3' ) ) }}
	<div class="col-sm-9">
		{{ Form::text( 'emusic_cjsku', $artist->meta->emusic_cjsku, array( 'class' => 'form-control' ) ) }}
	</div>
</div>

<div class="col-sm-offset-3 col-sm-9">
	{{ Form::submit( 'Save', array( 'class' => 'btn btn-default' ) ) }}
</div>
@stop