<?php
/**
 * Created by PhpStorm.
 * User: gregbueno
 * Date: 6/9/14
 * Time: 9:58 PM
 */

class ArtistMetaCollection extends MetaCollection {

	public $metaId;

	public function __construct(array $models = Array(), $metaId = null) {

		if (!empty($metaId)) {
			$this->metaId = $metaId;
		} else {
			$first_model = array_first($models, function ($key, $value) {
				return !empty($value->meta_artist_id);
			});
			$this->metaId = (count($models) > 0) ? $first_model->meta_artist_id : 0;
		}

		parent::__construct($models, array(
			'metaClassName' => 'ArtistMeta',
			'metaClassId' => 'meta_artist_id',
			'metaId' => $this->metaId,
		));
	}

} 