<?php
/**
 * Created by PhpStorm.
 * User: gregbueno
 * Date: 5/26/14
 * Time: 4:00 PM
 */

class Artist extends Eloquent {

	protected $table = 'mw_artists';
	protected $primaryKey = 'artist_id';
	protected $softDelete = true;
	protected $fillable = array(
		'artist_last_name',
		'artist_first_name',
		'artist_display_name',
		'artist_settings_mask',
		'artist_navigation_mask',
		'artist_biography',
		'artist_biography_more',
		'artist_bio_last_updated',
	);
	protected $guarded = array(
		'artist_id',
	);

	public function albums() {
		return $this->hasMany('Album', 'album_artist_id', 'artist_id')->orderBy('album_release_date');
	}

	public function meta() {
		return $this->hasMany('ArtistMeta', 'meta_artist_id', 'artist_id');
	}

	public function personnel() {
		return $this->hasMany('ArtistPersonnel', 'member_parent_id', 'artist_id');
	}

	public function getArtistDisplayNameAttribute() {
		if (empty($this->attributes['artist_display_name'])) {
			if (empty($this->attributes['artist_first_name'])) {
				return $this->attributes['artist_last_name'];
			} else {
				return ($this->attributes['artist_settings_mask'] & 2 == 2) ?
					$this->attributes['artist_last_name'] . ' ' . $this->attributes['artist_first_name'] :
					$this->attributes['artist_first_name'] . ' ' . $this->attributes['artist_last_name'];
			}
		} else {
			return $this->attributes['artist_display_name'];
		}
	}
}