<?php

Class Auth implements ArrayAccess, JsonSerializable{ 

	use CustomPerm;

	public $user;

	protected $loggedOut = false;

	public $viaRemember = false;

	protected $table;

	protected $lastAttempted;

	protected $attributes = [];


	public function __construct()
	{	
		$this->load->database();

		$this->load->library('session');

		$this->load->helper('cookie');

		$this->config->load('auth');

		$this->table = $this->config->item('table');
	}

	protected function check()
	{
		return ! is_null($this->user());
	}

	/**
	 * Determine if the current user is a guest.
	 *
	 * @return bool
	 */
	protected function guest()
	{
		return ! $this->check();
	}
 
	/**
	 * Get the currently authenticated user.
	 */
	protected function user()
	{
		if ($this->loggedOut) return;

		if ( ! is_null($this->user))
		{
			return $this->user;
		}

		$id = $this->session->userdata($this->getName());

		$user = null;

		if ( ! is_null($id))
		{
			$query = $this->db->get_where($this->table,array('id'=>$id));

			if($query->num_rows() > 0)
			{	
				//$user = new Auth();

				//$user->setRawAttributes($query->row_array());

				//$user->user = $user;
				$this->setRawAttributes($query->row_array());

				$this->setUser($this);
			}	
		}

		$recaller = $this->getRecaller();

		if (is_null($this->user) && ! is_null($recaller))
		{
			$this->user = $this->getUserByRecaller($recaller);

			//$user->user = $user;

			//$this->viaRemember = true;
		}

		return $this->user;
	}

	protected function once(array $credentials = array())
	{
		if ($this->validate($credentials))
		{
			$this->setUser($this->lastAttempted);

			return true;
		}

		return false;
	}

	/**
	 * Validate a user's credentials.
	 *
	 * @param  array  $credentials
	 * @return bool
	 */
	public function validate(array $credentials = array())
	{
		return $this->attempt($credentials, false, false);
	}

	protected function attempt(array $credentials = array(), $remember = false, $login = true)
	{	
		$user = null;

		$password = $credentials['password'];

		unset($credentials['password']);

		$query = $this->db->get_where($this->table,$credentials);

		if($query->num_rows()>0)
		{
			$this->lastAttempted = $user = $query->row();
		}

		if($user !== null)
		{
			if(password_verify($password,$user->password))
				{
					if ($login) $this->login($user, $remember);
		
					return true;	
				}
		}

		return false;
	}

	protected function login( $user, $remember = false)
	{
		$this->session->set_userdata($this->getName(),$user->id);

		if ($remember)
		{	
			$data['remember_token'] = $this->random(60);

			$this->refreshRememberToken($user,$data);

			$this->setRecallerCookie($data['remember_token']);
		}

		$this->setUser($user);
	}

	protected function logout()
	{ 
		$user = $this->user();

		$this->session->sess_destroy();

		delete_cookie($this->getRecallerName(),'localhost','/','mycookie_');

		if ( ! is_null($this->user))
		{	
			$data['remember_token'] = $this->random(60);

			$this->refreshRememberToken($user,$data);
		}

		$this->user = null;

		$this->loggedOut = true;
	}

	public function setUser($user)
	{
		$this->user = $user;

		$this->loggedOut = false;
	}

	public function setRawAttributes($attributes)
	{
		$this->attributes = $attributes;
	}

	public function getLastAttempted()
	{
		return $this->lastAttempted;
	}

	/**
	 * Get a unique identifier for the auth session value.
	 *
	 * @return string
	 */
	public function getName()
	{
		return 'login_'.md5(get_class($this));
	}


	/**
	 * Determine if the user was authenticated via "remember me" cookie.
	 *
	 * @return bool
	 */
	public function viaRemember()
	{
		return $this->viaRemember;
	}

	public function __get($key)
	{	
		if(in_array($key, array('load','db','config','session')))
		{
			return get_instance()->$key;
		}

		return $this->attributes[$key];
	}

	protected function setRecallerCookie($token)
	{	
		$key = getRecallerName();
		$cookie = array(
                   'name'   => $key,
                   'value'  => $token,
                   'expire' => '86500',
                   'domain' => '.localhost',
                   'path'   => '/',
                   'prefix' => 'mycookie_', 
               );

		set_cookie($cookie);
	}

	protected function refreshRememberToken($user,$data)
	{
		$this->db->update($this->table,$data,array('id'=>$user->id));
	}

	/**
	 * Get the name of the cookie used to store the "recaller".
	 *
	 * @return string
	 */
	public function getRecallerName()
	{
		//return 'remember_'.md5(get_class($this));
		return "uejimi37494ki03kk";
	}

	/**
	 * Get the decrypted recaller cookie for the request.
	 *
	 * @return string|null
	 */
	protected function getRecaller()
	{
		return get_cookie($this->getRecallerName());
	}

	protected function getUserByRecaller($recaller)
	{
		$query = $this->db->get_where($this->table,array('remember_token'=>$recaller));

		if($query->num_rows() > 0)
		{	
			//$user = new Auth();

			//$user->setRawAttributes($query->row_array());
			//$user->viaRemember = true;

			$this->setRawAttributes($query->row_array());

			$this->viaRemember = true;

			return $this;
		}
	}

	protected  function random($length = 16)
	{
		if (function_exists('openssl_random_pseudo_bytes'))
		{
			$bytes = openssl_random_pseudo_bytes($length * 2);

			if ($bytes === false)
			{
				throw new \RuntimeException('Unable to generate random string.');
			}

			return substr(str_replace(array('/', '+', '='), '', base64_encode($bytes)), 0, $length);
		}

		return rand(1000,9000);
	}


	//ArrayAccess Implimentation

	public function offsetExists($offset)
	{
		return isset($this->attributes[$offset]);
	}

	public function offsetGet($offset)
	{
		return $this->attributes[$offset];
	}

	public function offsetSet($offset, $value)
	{
		$this->attributes[$offset] = $value;
	}

	public function offsetUnset($offset)
	{
		unset($this->attributes[$offset]);
	}

	//JsonSerialization implimentation
	public function jsonSerialize()
	{
		return $this->attributes;
	}

	//Dynamic method call
	public function __call($method,$arg)
	{
		return call_user_func_array(array($this,$method), $arg);
	}

	public static function __callStatic($method,$arg)
	{
		$auth = new Auth;

		return call_user_func_array(array($auth,$method), $arg);
	}
}