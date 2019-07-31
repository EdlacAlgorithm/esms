<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
   
use Illuminate\Database\Eloquent\Model as Eloquent;
class polls extends Eloquent {
	public $timestamps = false;
	protected $table = 'polls';
}