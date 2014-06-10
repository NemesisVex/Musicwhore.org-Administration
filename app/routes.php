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
	Route::get( '/artist/{artist}/delete', array( 'as' => 'artist.delete', 'before' => 'auth', 'uses' => 'ArtistController@delete' ) );
	Route::resource('artist', 'ArtistController');

	// ArtistMeta
	Route::model('artist-meta', 'ArtistMeta');
	Route::resource('artist-setting', 'ArtistMetaController');

	// Personnel
	Route::model('personnel', 'Personnel');
	Route::get( '/personnel/{personnel}/delete', array( 'as' => 'personnel.delete', 'before' => 'auth', 'uses' => 'PersonnelController@delete' ) );
	Route::post( '/personnel/save-order', array( 'as' => 'personnel.save-order', 'before' => 'auth|csrf', 'uses' => 'PersonnelController@save_order' ) );
	Route::resource('personnel', 'PersonnelController');

	// Album
	Route::model('album', 'Album');
	Route::get( '/album/{album}/delete', array( 'as' => 'album.delete', 'before' => 'auth', 'uses' => 'AlbumController@delete' ) );
	Route::resource('album', 'AlbumController');

	// AlbumMeta
	Route::model('album-meta', 'AlbumMeta');
	Route::resource('album-setting', 'AlbumMetaController');

	// Release
	Route::model('release', 'Release');
	Route::resource('release', 'ReleaseController');
	Route::get( '/release/{release}/delete', array( 'as' => 'release.delete', 'before' => 'auth', 'uses' => 'ReleaseController@delete' ) );

	// ReleaseMeta
	Route::model('release-meta', 'ReleaseMeta');
	Route::resource('release-setting', 'ReleaseMetaController');

	// Tracks
	Route::model('track', 'Track');
	Route::get( '/track/{track}/delete', array( 'as' => 'track.delete', 'before' => 'auth', 'uses' => 'TrackController@delete' ) );
	Route::post( '/track/save-order', array( 'as' => 'track.save-order', 'before' => 'auth|csrf', 'uses' => 'TrackController@save_order' ) );
	Route::resource('track', 'TrackController');

	// ReleaseMeta
	Route::model('track-meta', 'TrackMeta');
	Route::resource('track-setting', 'TrackMetaController');
});



// Authentication
Route::get( '/login', array( 'as' => 'auth.login', 'uses' => 'AuthController@login') );
Route::get( '/logout', array( 'as' => 'auth.logout', 'uses' => 'AuthController@sign_out' ) );
Route::post( '/signin', array( 'as' => 'auth.signin', 'uses' => 'AuthController@sign_in' ) );
