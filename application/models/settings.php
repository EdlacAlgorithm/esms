<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
   
use Illuminate\Database\Eloquent\Model as Eloquent;
class settings extends Eloquent {
	public $timestamps = false;
	protected $table = 'settings';
}