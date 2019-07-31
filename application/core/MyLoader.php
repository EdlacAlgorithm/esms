<?php

class MyLoader extends CI_Loader {

	public function __construct(){
     
    }
    public function controller($file_name){
        $CI = & get_instance();
     
        $file_path = APPPATH.'controllers/'.$file_name.'.php';
        $object_name = $file_name;
        $class_name = ucfirst($file_name);
     
        if(file_exists($file_path)){
            require $file_path;
         
            $CI->$object_name = new $class_name();
        }
        else{
            show_error("Unable to load the requested controller class: ".$class_name);
        }
    }




	public function view($view, $vars = array(), $return = FALSE)
	{	
		if(isset($_SESSION['errors'])) $vars['errors'] = $_SESSION['errors'];
		return $this->_ci_load(array('_ci_view' => $view, '_ci_vars' => $this->_ci_prepare_view_vars($vars), '_ci_return' => $return));
	}
}