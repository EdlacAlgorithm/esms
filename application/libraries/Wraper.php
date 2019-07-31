<?php

Class Wraper{}

Class Session{
	
	public function __construct()
	{
		$this->load->library('session');
	}


	protected function put($key, $value)
	{
		if ( ! is_array($key)) $key = array($key => $value);

		foreach ($key as $arrayKey => $arrayValue)
		{
			$this->session->set_userdata($arrayKey, $arrayValue);
		}
	}

	protected function has($name)
	{
		return ! is_null($this->get($name));
	}

	
	protected function get($name, $default = null)
	{	
		$session = $this->session->userdata($name);

		return is_null($session)?$default:$session;
	}

	protected function token()
	{
		return $this->security->get_csrf_hash();
	}

	protected function regenerateToken()
	{
		$this->put('_token',$this->security->get_csrf_hash());
	}

	public function __call($method,$arg)
	{
		return call_user_func_array(array($this,$method), $arg);
	}

	public static function  __callStatic($method,$arg)
	{
		$session = new Session();

		return call_user_func_array(array($session,$method), $arg);
	}

	public function __get($key)
	{
		return get_instance()->$key;
	}
}


Class Input{

	protected $fileName;

	protected function get($input=null)
	{	
		$postdata = file_get_contents("php://input");

	 	$request = json_decode($postdata,true);

	 	if(is_array($request))
	 	{
	 		$_POST = array_merge($_POST,$request);
	 		
	 		$_GET  = array_merge($_GET,$request);
	 	}

		return $this->input->post_get($input);	
	}

	protected function has($input)
	{
		if(null !== $this->get($input))
		{
			return true;
		}

		return false;
	}

	protected function isAjax()
	{
		return $this->input->is_ajax_request();
	}
	
	protected function all()
	{
		return $this->get();
	}

	protected function hasFile($fileName)
	{
		return $_FILES[$fileName]["error"] > 0 ?false:true;
	} 

	protected function file($fileName)
	{
		$this->fileName = $fileName;

		return $this;
	}

	public function getClientOriginalExtension()
    {	
    	$previousFileName = basename($_FILES[$this->fileName]["name"]);

        return pathinfo($previousFileName, PATHINFO_EXTENSION);
    }

	public function move($fileDir,$fileName)
	{	
		$pamanetFile = $fileDir . $fileName;

		move_uploaded_file($_FILES[$this->fileName]["tmp_name"],$pamanetFile);

		return $this;
	}

	public function __call($method,$arg)
	{
		return call_user_func_array(array($this,$method), $arg);
	}

	public static function __callStatic($method,$arg)
	{	
		$input = new Input();

		return call_user_func_array(array($input,$method), $arg);
	}

	public function __get($key)
	{
		return get_instance()->$key;
	}

}


Class Schema{

	public function __construct()
	{
		$this->load->database();
	}

	protected  function hasTable($tableName)
	{
		return $this->db->table_exists($tableName);
	}

	public  function __call($method,$arg)
	{
		return call_user_func_array(array($this,$method), $arg);
	}

	public static function __callStatic($method,$arg)
	{
		$schema = new Schema;

		return call_user_func_array(array($schema,$method), $arg);
	}

	public function __get($key)
	{
		return get_instance()->$key;
	}
	

}

Class DB{

	public static function table($tableName)
	{
		return Illuminate\Database\Capsule\Manager::table($tableName);
	}

	public static function select($selectedField)
	{
		return Illuminate\Database\Capsule\Manager::select($selectedField);
	}

	public static function raw($rawData)
	{
		return Illuminate\Database\Capsule\Manager::raw($rawData);
	}

	public static function unprepared($rawData)
	{
		return Illuminate\Database\Capsule\Manager::unprepared($rawData);
	}

}

class View{

	public  function _make($view, $vars = array(), $return = FALSE)
	{	
		$this->load->library('session');

		$errors = new Err();

		$this->session->set_flashdata(compact('errors'));

		$this->load->view($view, $vars, $return);
	}

	public static function __callStatic($method,$arg)
	{
		$view = new View;

		$method = '_'.$method;

		return call_user_func_array(array($view,$method), $arg);
	}

	public function __get($key)
	{
		return get_instance()->$key;
	}
	
}

Class Err{

	private $errors; 

	public function __construct(array $errors=array())
	{
		$this->errors = is_array($errors)?$errors:func_get_args(); 
	}

	public function first()
	{
		return reset($this->errors);
	}

	public function any()
	{
		return !empty($this->errors);
	}
}

class Redirect{

	private $url;

	private $error = null;

	public function __construct()
	{	
		$this->load->helper('url');
	}

	public  function _to($url)
	{
		$this->url = $url;

		return $this;
	}

	public function withErrors($error)
	{
		$this->error = $error;

		return $this;
	}

	public function __destruct()
	{
		if($this->error !== null)
		{	
			$errors = new Err($this->error);

			$this->session->set_flashdata(compact('errors'));
		}
      	
      	return redirect($this->url);
	}

	public static function __callStatic($method,$arg)
	{
		$redirect = new Redirect;
		$method = '_'.$method;
		return call_user_func_array(array($redirect,$method), $arg);
	}

	public function __get($key)
	{
		return get_instance()->$key;
	}

}


Class URL{

	private $ci;

	public function __construct()
	{	
		$this->ci =& get_instance();
		
		$this->ci->load->helper('url');
	}

	public  function _to($url='')
	{
		$rtrim = rtrim(base_url($url),'/');

		return $rtrim;
	}

	public  function _asset($url='')
	{
		return site_url($url);
	}

	public static function __callStatic($method,$arg)
	{
		$url = new URL;

		$method = '_'.$method;

		return call_user_func_array(array($url,$method), $arg);
	}
}

Class Hash{

	public static function make($value, array $options = array())
	{
		$cost = isset($options['rounds']) ? $options['rounds'] : 10;

		$hash = password_hash($value, PASSWORD_BCRYPT, array('cost' => $cost));

		if ($hash === false)
		{
			throw new \RuntimeException("Bcrypt hashing not supported.");
		}

		return $hash;
	}

	public static function check($value, $hashedValue, array $options = array())
   	{
   		return password_verify($value, $hashedValue);
   	}
}