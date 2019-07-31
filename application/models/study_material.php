<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
   
use Illuminate\Database\Eloquent\Model as Eloquent;
class study_material extends Eloquent {
	public $timestamps = false;
	protected $table = 'study_material';
}
