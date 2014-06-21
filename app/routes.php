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
	Route::get( '/artist-setting/musicbrainz/{artist}/lookup', array( 'as' => 'artist-setting.musicbrainz.lookup', 'uses' => 'ArtistMetaController@lookup_musicbrainz' ) );
	Route::get( '/artist-setting/discogs/{artist}/lookup', array( 'as' => 'artist-setting.discogs.lookup', 'uses' => 'ArtistMetaController@lookup_discogs' ) );
	Route::get( '/artist-setting/itunes/{artist}/lookup', array( 'as' => 'artist-setting.itunes.lookup', 'uses' => 'ArtistMetaController@lookup_itunes' ) );
	Route::post( '/artist-setting/discogs/search', array( 'as' => 'artist-setting.discogs.search', 'uses' => 'ArtistMetaController@search_discogs' ) );
	Route::post( '/artist-setting/itunes/{artist}/search', array( 'as' => 'artist-setting.itunes.serach', 'uses' => 'ArtistMetaController@search_itunes' ) );
	Route::resource('artist-setting', 'ArtistMetaController');

	// ArtistMusicbrainz
	Route::post( '/artist-musicbrainz/search', array( 'as' => 'artist-musicbrainz.search', 'uses' => 'ArtistMusicbrainzController@index' ) );
	Route::resource( 'artist-musicbrainz', 'ArtistMusicbrainzController' );

	// ArtistItunes
	Route::post( '/artist-itunes/search', array( 'as' => 'artist-itunes.search', 'uses' => 'ArtistItunesController@index' ) );
	Route::resource( 'artist-itunes', 'ArtistItunesController' );

	// ArtistItunes
	Route::post( '/artist-discogs/search', array( 'as' => 'artist-discogs.search', 'uses' => 'ArtistDiscogsController@index' ) );
	Route::resource( 'artist-discogs', 'ArtistDiscogsController' );

	// AmazonSearch
	Route::post( '/amazon/search', array( 'as' => 'amazon.search', 'uses' => 'AmazonSearchController@index' ) );
	Route::resource( 'amazon', 'AmazonSearchController' );

	// Personnel
	Route::model('personnel', 'Personnel');
	Route::get( '/personnel/{personnel}/delete', array( 'as' => 'personnel.delete', 'uses' => 'PersonnelController@delete' ) );
	Route::post( '/personnel/save-order', array( 'as' => 'personnel.save-order', 'before' => 'csrf', 'uses' => 'PersonnelController@save_order' ) );
	Route::resource('personnel', 'PersonnelController');

	// Album
	Route::model('album', 'Album');
	Route::get( '/album/{album}/delete', array( 'as' => 'album.delete', 'uses' => 'AlbumController@delete' ) );
	Route::resource('album', 'AlbumController');

	// AlbumMeta
	Route::model('album-meta', 'AlbumMeta');
	Route::get( '/album-setting/musicbrainz/{album}/lookup', array( 'as' => 'album-setting.musicbrainz.lookup', 'uses' => 'AlbumController@lookup_musicbrainz' ) );
	Route::get( '/album-setting/discogs/{album}/lookup', array( 'as' => 'album-setting.discogs.lookup', 'uses' => 'AlbumController@lookup_discogs' ) );
	Route::post( '/album-setting/musicbrainz/search', array( 'as' => 'album-setting.musicbrainz.search', 'uses' => 'AlbumController@search_musicbrainz' ) );
	Route::post( '/album-setting/discogs/search', array( 'as' => 'album-setting.discogs.search', 'uses' => 'AlbumController@search_discogs' ) );
	Route::resource('album-setting', 'AlbumMetaController');

	// AlbumMusicbrainz
	Route::post( '/album-musicbrainz/search', array( 'as' => 'album-musicbrainz.search', 'uses' => 'AlbumMusicbrainzController@index' ) );
	Route::resource( 'album-musicbrainz', 'AlbumMusicbrainzController' );

	// AlbumDiscogs
	Route::post( '/album-discogs/search', array( 'as' => 'album-discogs.search', 'uses' => 'AlbumDiscogsController@index' ) );
	Route::resource( 'album-discogs', 'AlbumDiscogsController' );

	// Release
	Route::model('release', 'Release');
	Route::get( '/release/{release}/delete', array( 'as' => 'release.delete', 'uses' => 'ReleaseController@delete' ) );
	Route::resource('release', 'ReleaseController');

	// ReleaseMeta
	Route::model('release-meta', 'ReleaseMeta');
	Route::get( '/release-setting/amazon/{release}/lookup', array( 'as' => 'release-setting.amazon.lookup', 'uses' => 'ReleaseMetaController@lookup_amazon' ) );
	Route::get( '/release-setting/itunes/{release}/lookup', array( 'as' => 'release-setting.itunes.lookup', 'uses' => 'ReleaseMetaController@lookup_itunes' ) );
	Route::get( '/release-setting/musicbrainz/{release}/lookup', array( 'as' => 'release-setting.musicbrainz.lookup', 'uses' => 'ReleaseMetaController@lookup_musicbrainz' ) );
	Route::get( '/release-setting/discogs/{release}/lookup', array( 'as' => 'release-setting.discogs.lookup', 'uses' => 'ReleaseMetaController@lookup_discogs' ) );
	Route::post( '/release-setting/amazon/search', array( 'as' => 'release-setting.amazon.search', 'uses' => 'ReleaseMetaController@search_amazon' ) );
	Route::post( '/release-setting/itunes/search', array( 'as' => 'release-setting.itunes.search', 'uses' => 'ReleaseMetaController@search_itunes' ) );
	Route::post( '/release-setting/musicbrainz/search', array( 'as' => 'release.musicbrainz.search', 'uses' => 'ReleaseMetaController@search_musicbrainz' ) );
	Route::post( '/release-setting/discogs/search', array( 'as' => 'release.discogs.search', 'uses' => 'ReleaseMetaController@search_discogs' ) );
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
