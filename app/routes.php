<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::group(array('before' => 'auth'), function () {
	Route::get('/', array( 'as' => 'admin.home', 'uses' => 'HomeController@index' ));

	// Artist
	Route::model('artist', 'Artist');
	Route::get( '/artist/{artist}/delete', array( 'as' => 'artist.delete', 'uses' => 'ArtistController@delete' ) );
	Route::resource('artist', 'ArtistController');

	// ArtistMeta
	Route::model('artist-meta', 'ArtistMeta');
	Route::resource('artist-setting', 'ArtistMetaController');

	// Personnel
	Route::model('personnel', 'Personnel');
	Route::get( '/personnel/{personnel}/delete', array( 'as' => 'personnel.delete', 'uses' => 'PersonnelController@delete' ) );
	Route::post( '/personnel/save-order', array( 'as' => 'personnel.save-order', 'before' => 'csrf', 'uses' => 'PersonnelController@save_order' ) );
	Route::resource('personnel', 'PersonnelController');

	// Album
	Route::model('album', 'Album');
	Route::get( '/album/{album}/delete', array( 'as' => 'album.delete', 'uses' => 'AlbumController@delete' ) );
	Route::get( '/album/musicbrainz/{album}/lookup', array( 'as' => 'album.musicbrainz.lookup', 'uses' => 'AlbumController@lookup_musicbrainz' ) );
	Route::get( '/album/discogs/{album}/lookup', array( 'as' => 'album.discogs.lookup', 'uses' => 'AlbumController@lookup_discogs' ) );
	Route::post( '/album/musicbrainz/{album}/search', array( 'as' => 'album.musicbrainz.serach', 'before' => 'csrf', 'uses' => 'AlbumController@lookup_musicbrainz' ) );
	Route::post( '/album/discogs/{album}/serach', array( 'as' => 'album.discogs.search', 'before' => 'csrf', 'uses' => 'AlbumController@lookup_discogs' ) );
	Route::resource('album', 'AlbumController');

	// AlbumMeta
	Route::model('album-meta', 'AlbumMeta');
	Route::resource('album-setting', 'AlbumMetaController');

	// Release
	Route::model('release', 'Release');
	Route::resource('release', 'ReleaseController');
	Route::get( '/release/{release}/delete', array( 'as' => 'release.delete', 'uses' => 'ReleaseController@delete' ) );

	// ReleaseMeta
	Route::model('release-meta', 'ReleaseMeta');
	Route::resource('release-setting', 'ReleaseMetaController');

	// Tracks
	Route::model('track', 'Track');
	Route::get( '/track/{track}/delete', array( 'as' => 'track.delete', 'uses' => 'TrackController@delete' ) );
	Route::post( '/track/save-order', array( 'as' => 'track.save-order', 'before' => 'csrf', 'uses' => 'TrackController@save_order' ) );
	Route::resource('track', 'TrackController');

	// TrackMeta
	Route::model('track-meta', 'TrackMeta');
	Route::resource('track-setting', 'TrackMetaController');
});



// Authentication
Route::get( '/login', array( 'as' => 'auth.login', 'uses' => 'AuthController@login') );
Route::get( '/logout', array( 'as' => 'auth.logout', 'uses' => 'AuthController@sign_out' ) );
Route::post( '/signin', array( 'as' => 'auth.signin', 'uses' => 'AuthController@sign_in' ) );
