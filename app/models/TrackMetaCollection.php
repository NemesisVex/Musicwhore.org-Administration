<?php
/**
 * Created by PhpStorm.
 * User: gregbueno
 * Date: 6/9/14
 * Time: 10:59 PM
 */

class TrackMetaCollection extends MetaCollection {

	public $metaId;

	public function __construct(array $models = Array(), $metaId = null) {

		if (!empty($metaId)) {
			$this->metaId = $metaId;
		} else {
			$first_model = array_first($models, function ($key, $value) {
				return !empty($value->meta_track_id);
			});
			$this->metaId = (count($models) > 0) ? $first_model->meta_track_id : 0;
		}

		parent::__construct($models, array(
			'metaClassName' => 'TrackMeta',
			'metaClassId' => 'meta_track_id',
			'metaId' => $this->metaId,
		));
	}



} 