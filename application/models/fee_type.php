<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
   
use Illuminate\Database\Eloquent\Model as Eloquent;
class fee_type extends Eloquent {
	public $timestamps = false;
	protected $table = 'fee_type';
}
