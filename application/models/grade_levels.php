<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
   
use Illuminate\Database\Eloquent\Model as Eloquent;
class grade_levels extends Eloquent {
	public $timestamps = false;
	protected $table = 'grade_levels';
}
