<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
   
use Illuminate\Database\Eloquent\Model as Eloquent;
class mob_notifications extends Eloquent {
	public $timestamps = false;
	protected $table = 'mob_notifications';
}
