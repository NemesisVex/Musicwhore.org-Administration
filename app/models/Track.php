<?php
/**
 * Created by PhpStorm.
 * User: gregbueno
 * Date: 5/26/14
 * Time: 5:38 PM
 */

class Track extends Eloquent {

	protected $table = 'mw_albums_tracks';
	protected $primaryKey = 'track_id';
	protected $softDelete = true;
	protected $fillable = array(
		'track_release_id',
		'track_disc_num',
		'track_track_num',
		'track_song_title',
		'track_sort_title',
		'track_alt_title',
	);
	protected $guarded = array(
		'track_id',
		'track_deleted',
	);

	public function release() {
		return $this->belongsTo('Release', 'track_release_id', 'release_id');
	}

//	public function ecommerce() {
//		return $this->hasMany('Ecommerce', 'ecommerce_track_id', 'track_id');
//	}

	public function meta() {
		return $this->hasMany('TrackMeta', 'meta_track_id', 'track_id');
	}

	public function findReleaseTracks($release_id) {
		$tracks_formatted = array();
		$tracks = Track::where('track_release_id', $release_id)->orderBy('track_disc_num')->orderBy('track_track_num')->get();

		if (!empty($tracks)) {
			foreach ($tracks as $track) {
				$tracks_formatted[$track->track_disc_num][] = $track;
			}
		}

		return $tracks_formatted;
	}
}