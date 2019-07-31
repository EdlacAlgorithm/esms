<?php

Trait CustomPerm{ 

	public $customPermissionsDecoded = "";

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