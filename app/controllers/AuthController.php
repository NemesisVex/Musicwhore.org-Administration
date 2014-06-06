<?php
/**
 * Created by PhpStorm.
 * User: gregbueno
 * Date: 5/26/14
 * Time: 2:09 PM
 */

class AuthController extends BaseController {

	private $layout_variables = array();

	public function __construct() {
		global $config_url_base;

		$this->layout_variables = array(
			'config_url_base' => $config_url_base,
		);
	}

	public function login() {

		if (Auth::check() === true) {
			die();
			return Redirect::intended('/');
		}

		$method_variables = array();

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('auth.login', $data);
	}

	public function sign_in() {
		$user_name = Input::get('user_name');
		$user_password = Input::get('user_password');

		if (Auth::attempt( array( 'user_name' => $user_name, 'password' => $user_password ), true )) {
			return Redirect::intended('/');
		} else {
			return Redirect::to('/login')->with('error', "Sorry, we couldn't verify your credentials. Please try again.");
		}
	}

	public function sign_out() {
		Auth::logout();

		return Redirect::to('/login');
	}

} 