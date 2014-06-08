<?php
/**
 * Created by PhpStorm.
 * User: gregbueno
 * Date: 5/26/14
 * Time: 5:26 PM
 */

class Album extends Eloquent {

	protected $table = 'mw_albums';
	protected $primaryKey = 'album_id';
	protected $softDelete = true;
	protected $fillable = array(
		'album_artist_id',
		'album_format_id',
		'album_title',
		'album_sort_title',
		'album_alt_title',
		'album_label',
		'album_release_date',
		'album_image',
	);
	protected $guarded = array(
		'album_id',
	);

	public function artist() {
		return $this->belongsTo('Artist', 'album_artist_id', 'artist_id');
	}

	public function releases() {
		return $this->hasMany('Release', 'release_album_id', 'album_id');
	}

	public function meta() {
		return $this->hasMany('AlbumMeta', 'meta_album_id', 'album_id');
	}

	public function format() {
		return $this->hasOne('AlbumFormat', 'format_id', 'album_format_id');
	}
}