<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class MyController extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		if (Auth::guest())
		{
			Redirect::to('/login');
		}
	}

}