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
	Route::get( '/artist/musicbrainz/{album}/lookup', array( 'as' => 'artist.musicbrainz.lookup', 'uses' => 'ArtistController@lookup_musicbrainz' ) );
	Route::get( '/artist/discogs/{album}/lookup', array( 'as' => 'artist.discogs.lookup', 'uses' => 'ArtistController@lookup_discogs' ) );
	Route::post( '/artist/musicbrainz/search', array( 'as' => 'artist.musicbrainz.search', 'uses' => 'ArtistController@search_musicbrainz' ) );
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
	Route::post( '/album/musicbrainz/search', array( 'as' => 'album.musicbrainz.search', 'uses' => 'AlbumController@search_musicbrainz' ) );
	Route::post( '/album/discogs/search', array( 'as' => 'album.discogs.search', 'uses' => 'AlbumController@search_discogs' ) );
	Route::resource('album', 'AlbumController');

	// AlbumMeta
	Route::model('album-meta', 'AlbumMeta');
	Route::resource('album-setting', 'AlbumMetaController');

	// Release
	Route::model('release', 'Release');
	Route::get( '/release/{release}/delete', array( 'as' => 'release.delete', 'uses' => 'ReleaseController@delete' ) );
	Route::get( '/release/amazon/{release}/lookup', array( 'as' => 'release.amazon.lookup', 'uses' => 'ReleaseController@lookup_amazon' ) );
	Route::get( '/release/itunes/{release}/lookup', array( 'as' => 'release.itunes.lookup', 'uses' => 'ReleaseController@lookup_itunes' ) );
	Route::get( '/release/musicbrainz/{release}/lookup', array( 'as' => 'release.musicbrainz.lookup', 'uses' => 'ReleaseController@lookup_musicbrainz' ) );
	Route::get( '/release/discogs/{release}/lookup', array( 'as' => 'release.discogs.lookup', 'uses' => 'ReleaseController@lookup_discogs' ) );
	Route::post( '/release/amazon/search', array( 'as' => 'release.amazon.search', 'uses' => 'ReleaseController@search_musicbrainz' ) );
	Route::post( '/release/itunes/search', array( 'as' => 'release.itunes.search', 'uses' => 'ReleaseController@search_itunes' ) );
	Route::post( '/release/musicbrainz/search', array( 'as' => 'release.musicbrainz.search', 'uses' => 'ReleaseController@search_musicbrainz' ) );
	Route::post( '/release/discogs/search', array( 'as' => 'release.discogs.search', 'uses' => 'ReleaseController@search_discogs' ) );
	Route::resource('release', 'ReleaseController');

	// ReleaseMeta
	Route::model('release-meta', 'ReleaseMeta');
	Route::resource('release-setting', 'ReleaseMetaController');

	// Tracks
	Route::model('track', 'Track');
	Route::get( '/track/{track}/delete', array( 'as' => 'track.delete', 'uses' => 'TrackController@delete' ) );
	Route::post( '/track/save-order', array( 'as' => 'track.save-order', 'before' => 'csrf', 'uses' => 'TrackController@save_order' ) );
	Route::get( '/track/amazon/{release}/lookup', array( 'as' => 'track.amazon.lookup', 'uses' => 'TrackController@lookup_amazon' ) );
	Route::get( '/track/itunes/{release}/lookup', array( 'as' => 'track.itunes.lookup', 'uses' => 'TrackController@lookup_itunes' ) );
	Route::get( '/track/musicbrainz/{release}/lookup', array( 'as' => 'track.musicbrainz.lookup', 'uses' => 'TrackController@lookup_musicbrainz' ) );
	Route::get( '/track/discogs/{release}/lookup', array( 'as' => 'track.discogs.lookup', 'uses' => 'TrackController@lookup_amazon' ) );
	Route::post( '/track/amazon/search', array( 'as' => 'track.amazon.search', 'uses' => 'TrackController@search_musicbrainz' ) );
	Route::post( '/track/itunes/search', array( 'as' => 'track.itunes.search', 'uses' => 'TrackController@search_itunes' ) );
	Route::post( '/track/musicbrainz/search', array( 'as' => 'track.musicbrainz.search', 'uses' => 'TrackController@search_musicbrainz' ) );
	Route::post( '/track/discogs/search', array( 'as' => 'track.discogs.search', 'uses' => 'TrackController@search_discogs' ) );
	Route::resource('track', 'TrackController');

	// TrackMeta
	Route::model('track-meta', 'TrackMeta');
	Route::resource('track-setting', 'TrackMetaController');
});



// Authentication
Route::get( '/login', array( 'as' => 'auth.login', 'uses' => 'AuthController@login') );
Route::get( '/logout', array( 'as' => 'auth.logout', 'uses' => 'AuthController@sign_out' ) );
Route::post( '/signin', array( 'as' => 'auth.signin', 'uses' => 'AuthController@sign_in' ) );
