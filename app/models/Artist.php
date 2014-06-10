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
		return $this->hasMany('Personnel', 'member_parent_id', 'artist_id');
	}

	public function getArtistDisplayNameAttribute() {
		if (empty($this->attributes['artist_display_name'])) {
			if (empty($this->attributes['artist_first_name'])) {
				return !empty($this->attributes['artist_last_name']) ? $this->attributes['artist_last_name'] : null;
			} else {
				return ($this->meta->is_asian_name === true) ?
					$this->attributes['artist_last_name'] . ' ' . $this->attributes['artist_first_name'] :
					$this->attributes['artist_first_name'] . ' ' . $this->attributes['artist_last_name'];
			}
		} else {
			return !empty($this->attributes['artist_display_name']) ? $this->attributes['artist_display_name'] : null;
		}
	}

	public function getAllByInitialLetter() {
		$artist_list = DB::table($this->table)->select(DB::raw('Upper(Substring(artist_last_name From 1 For 1)) as nav'))->groupBy('nav')->orderBy('nav')->get();
		return $artist_list;
	}
}