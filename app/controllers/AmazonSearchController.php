<?php

use ApaiIO\Configuration\GenericConfiguration;
use ApaiIO\Operations\Search;
use ApaiIO\ApaiIO;

class AmazonSearchController extends \BaseController {

	private $layout_variables = array();
	private $amazon_config;
	private $associate_suffixes;
	private $country_codes;
	private $associate_tag_base;

	public function __construct() {
		global $config_url_base;

		$this->layout_variables = array(
			'config_url_base' => $config_url_base,
		);

		$this->amazon_config = new GenericConfiguration();
		$this->amazon_config->setAccessKey(ACCESS_KEY_ID)->setSecretKey(SECRET_ACCESS_KEY);
		$this->associate_suffixes = Config::get('amazon.associate_suffixes');
		$this->country_codes = Config::get('amazon.country_codes');
		$this->associate_tag_base = Config::get( 'amazon.tag_base' );

		$this->beforeFilter('csrf', array( 'only' => array( 'store', 'update', 'destroy' ) ) );
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$q = Input::get( 'q' );

		$category = Input::get( 'category' );
		if (empty($category)) { $category = 'All'; }

		$locale = Input::get( 'locale' );
		if (empty($locale)) { $locale = 'us'; }

		$page = Input::get( 'page' );
		if (empty($page)) { $page = 1; }

		$results = null;
		$pagination = null;

		if (!empty($q)) {
			$associate_tag = $this->associate_tag_base . $this->associate_suffixes[$locale];
			$this->amazon_config->setAssociateTag($associate_tag);
			$this->amazon_config->setCountry($this->country_codes[$locale]);

			$apaiIO = new ApaiIO($this->amazon_config);

			$search = new Search();
			$search->setCategory($category);
			$search->setKeywords($q);
			if ($page > 1) {
				$search->setPage($page);
			}
			$search->setResponseGroup(array('Large', 'Small'));

			$response = simplexml_load_string($apaiIO->runOperation($search));
			$results = json_decode(json_encode($response->Items));
			$total_results = $results->TotalResults > 100 ? 100 : $results->TotalResults;

			if (!empty($results->Item)) {
				$pagination = Paginator::make($results->Item, $total_results, 10 );
			}
		}

		$method_variables = array(
			'q' => $q,
			'category' => $category,
			'locale' => $locale,
			'results' => $results,
			'pagination' => $pagination,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('amazon.index', $data);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
