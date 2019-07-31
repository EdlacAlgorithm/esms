<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
   
use Illuminate\Database\Eloquent\Model as Eloquent;
class expenses extends Eloquent {
	public $timestamps = false;
	protected $table = 'expenses';
}
