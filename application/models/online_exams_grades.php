<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
   
use Illuminate\Database\Eloquent\Model as Eloquent;
class online_exams_grades extends Eloquent {
	public $timestamps = false;
	protected $table = 'online_exams_grades';
}
