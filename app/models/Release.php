<?php
/**
 * Created by PhpStorm.
 * User: gregbueno
 * Date: 5/26/14
 * Time: 5:31 PM
 */

class Release extends Eloquent {

	protected $table = 'mw_albums_releases';
	protected $primaryKey = 'release_id';
	protected $softDelete = true;
	protected $fillable = array(
		'release_album_id',
		'release_ean_num',
		'release_catalog_num',
		'release_format_id',
		'release_alt_title',
		'release_country_name',
		'release_label',
		'release_release_date',
		'release_image',
	);
	protected $guarded = array(
		'release_id',
		'release_date_modified',
		'release_deleted',
	);

	public function album() {
		return $this->belongsTo('Album', 'release_album_id', 'album_id');
	}

	public function tracks() {
		return $this->hasMany('Track', 'track_release_id', 'release_id');
	}

	public function format() {
		return $this->hasOne('ReleaseFormat', 'format_id', 'release_format_id');
	}

	public function meta() {
		return $this->hasMany('ReleaseMeta', 'meta_release_id', 'release_id');
	}

}