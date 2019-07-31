<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
   
use Illuminate\Database\Eloquent\Model as Eloquent;  
class academic_year extends Eloquent {
	public $timestamps = false;
	protected $table = 'academic_year';
}
