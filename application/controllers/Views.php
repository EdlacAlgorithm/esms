<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Views extends CI_Controller {

	public function template($template)
	{
		$this->load->view('templates/'.$template);
	}

	public function token()
	{
		//echo $this->security->get_csrf_hash();
		echo '8404f52eb4781ccafbfa7eaf6ad26f58';
	}

}
