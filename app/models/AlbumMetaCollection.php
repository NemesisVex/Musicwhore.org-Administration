<?php
/**
 * Created by PhpStorm.
 * User: gbueno
 * Date: 6/10/14
 * Time: 7:39 AM
 */

class AlbumMetaCollection extends MetaCollection {

	public $metaId;

	public function __construct(array $models = Array(), $metaId = null) {

		if (!empty($metaId)) {
			$this->metaId = $metaId;
		} else {
			$first_model = array_first($models, function ($key, $value) {
				return !empty($value->meta_album_id);
			});
			$this->metaId = (count($models) > 0) ? $first_model->meta_album_id : 0;
		}

		parent::__construct($models, array(
			'metaClassName' => 'AlbumMeta',
			'metaClassId' => 'meta_album_id',
			'metaId' => $this->metaId,
		));
	}
}