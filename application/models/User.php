<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
   
use Illuminate\Database\Eloquent\Model as Eloquent;


class User extends Eloquent{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	public $timestamps = false;

	public $customPermissionsDecoded = "";

	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');



	public function customPermissionsAsJson()
	{
		if($this->customPermissionsDecoded == ""){
			$this->customPermissionsDecoded = json_decode($this->customPermissions);
		}
		return $this->customPermissionsDecoded;
	}

	public function hasThePerm($perm)
	{
		if($this->role == "admin" AND $this->customPermissionsType == "custom" AND is_array($this->customPermissionsAsJson()) AND !in_array($perm,$this->customPermissionsAsJson())){
			return false;
		}else{
			return true;
		}
	}
}
