<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
   
use Illuminate\Database\Eloquent\Model as Eloquent;
class book_library extends Eloquent {
	public $timestamps = false;
	protected $table = 'book_library';
}
