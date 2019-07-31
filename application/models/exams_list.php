<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
   
use Illuminate\Database\Eloquent\Model as Eloquent;
class exams_list extends Eloquent {
	public $timestamps = false;
	protected $table = 'exams_list';
}
