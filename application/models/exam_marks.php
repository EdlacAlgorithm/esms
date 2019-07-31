<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
   
use Illuminate\Database\Eloquent\Model as Eloquent;
class exam_marks extends Eloquent {
	public $timestamps = false;
	protected $table = 'exam_marks';
}
