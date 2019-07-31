<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
   
use Illuminate\Database\Eloquent\Model as Eloquent;
class student_academic_years extends Eloquent {
	public $timestamps = false;
	protected $table = 'student_academic_years';
}
