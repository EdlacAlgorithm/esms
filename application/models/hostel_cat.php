<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
   
use Illuminate\Database\Eloquent\Model as Eloquent;
class hostel_cat extends Eloquent {
	public $timestamps = false;
	protected $table = 'hostel_cat';
}
