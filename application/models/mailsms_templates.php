<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
   
use Illuminate\Database\Eloquent\Model as Eloquent;
class mailsms_templates extends Eloquent {
	public $timestamps = false;
	protected $table = 'mailsms_templates';
}
