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
	Route::get( '/release/{release}/export-id3', array( 'as' => 'release.export-id3', 'before' => 'auth', 'uses' => 'ReleaseController@export_id3' ) );

	// Tracks
	Route::model('track', 'Track');
	Route::get( '/track/{track}/delete', array( 'as' => 'track.delete', 'before' => 'auth', 'uses' => 'TrackController@delete' ) );
	Route::post( '/track/save-order', array( 'as' => 'track.save-order', 'before' => 'auth|csrf', 'uses' => 'TrackController@save_order' ) );
	Route::resource('track', 'TrackController');

	// Audio
	Route::model('audio', 'Audio');
	Route::get( '/audio/{audio}/delete/', array( 'as' => 'audio.delete', 'before' => 'auth', 'uses' => 'AudioController@delete' ) );
	Route::resource('audio', 'AudioController');

	// Ecommerce
	Route::model('ecommerce', 'Ecommerce');
	Route::get( '/ecommerce/{ecommerce}/delete', array( 'as' => 'ecommerce.delete', 'before' => 'auth', 'uses' => 'EcommerceController@delete' ) );
	Route::post( '/ecommerce/save-order', array( 'as' => 'ecommerce.save-order', 'before' => 'auth|csrf', 'uses' => 'EcommerceController@save_order' ) );
	Route::resource('ecommerce', 'EcommerceController');
});



// Authentication
Route::get( '/login', array( 'as' => 'auth.login', 'uses' => 'AuthController@login') );
Route::get( '/logout', array( 'as' => 'auth.logout', 'uses' => 'AuthController@sign_out' ) );
Route::post( '/signin', array( 'as' => 'auth.signin', 'uses' => 'AuthController@sign_in' ) );
