<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
   
use Illuminate\Database\Eloquent\Model as Eloquent;
class subject extends Eloquent {
	public $timestamps = false;
	protected $table = 'subject';
}