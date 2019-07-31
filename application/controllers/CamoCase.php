<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//use Illuminate\Database\Capsule\Manager as Capsule;


class Jtest implements JsonSerializable{
	protected $arr =[];

	public function jsonSerialize()
	{
		return $this->arr;
	}

	public function __set($key,$value)
	{
		$this->arr[$key] = $value;
	}

	public function __get($key)
	{
		return $this->arr[$key];
	}

	public function __toString()
	{
		return implode(',', $arr);
	}

}

class CamoCase extends MyController {


	var $data = array();
	var $panelInit ;
	var $layout = 'dashboard';

	public function __construct(){
	    parent::__construct();
		$this->panelInit = new \DashboardInit();
		$this->data['panelInit'] = $this->panelInit;
		$this->data['breadcrumb']['Settings'] = \URL::to('/dashboard/languages');
		$this->data['users'] = Auth::user();
	}
	/*public function index()
	{
		$this->load->view('index');
	}*/
    public function index(){
       // echo "Hello there";
       echo json_encode("datafromajax"); 
    }

	public function v()
	{  //$users = User::where('id',1)->first();
		//$ss = User::get()->toArray();
        /*$users = Capsule::table('users')->where('id', '=', 1)->get();
		echo $users->fullName;
        echo "<br/>";
        echo $users->username;*/
        var_dump($this->search());
        //$d=['1','2','3'];
        //$us = User::get();
       //echo json_encode($ss);
        //return $users;
       // echo $d;	
	}

	public function search($page = 1)
	{	
		$searchQ = '';
		$searchC = 1;

		$toReturn = array();

		if($this->data['users']->role == "parent" ){
			$studentId = array();
			$parentOf = json_decode($this->data['users']->parentOf,true);
			if(is_array($parentOf)){
				while (list($key, $value) = each($parentOf)) {
					$studentId[] = $value['id'];
				}
			}
			if(count($studentId) > 0){
				$students = User::where('role','student')->where('activated','1')->whereIn('id', $studentId);
				if(isset($searchQ) AND $searchQ != "" AND $searchQ != "undefined"){
					$students = $students->where(function($query) use ($searchQ){
							                 $query->where('fullName','like','%'.$searchQ.'%')->orWhere('username','like','%'.$searchQ.'%')->orWhere('email','like','%'.$searchQ.'%');
							             });
				}
				if(isset($searchC) AND $searchC != "" AND $searchC != "undefined" AND $searchC != 0){
					$students = $students->where('studentClass',$searchC);
				}
				$toReturn['totalItems'] = $students->count();
				$students = $students->orderBy('studentRollId','ASC')->take('20')->skip(20* ($page - 1) )->get()->toArray();
			}else{
				$students = array();
				$toReturn['totalItems'] = 0;
			}
		}elseif($this->data['users']->role == "teacher" ){
			$classesList = array();
			$classes = classes::where('classAcademicYear',$this->panelInit->selectAcYear)->where('classTeacher','LIKE','%"'.$this->data['users']->id.'"%')->get()->toArray();
			while (list(, $value) = each($classes)) {
				$classesList[] = $value['id'];
			}

			if(count($classesList) > 0){
				$students = User::where('role','student')->whereIn('studentClass',$classesList)->where('activated','1');
				if(isset($searchQ) AND $searchQ != "" AND $searchQ != "undefined"){
					$students = $students->where(function($query) use ($searchQ){
							                 $query->where('fullName','like','%'.$searchQ.'%')->orWhere('username','like','%'.$searchQ.'%')->orWhere('email','like','%'.$searchQ.'%');
							             });
				}
				if(isset($searchC) AND $searchC != "" AND $searchC != "undefined" AND $searchC != 0){
					$students = $students->where('studentClass',$searchC);
				}
				$toReturn['totalItems'] = $students->count();
				$students = $students->orderBy('studentRollId','ASC')->take('20')->skip(20* ($page - 1) )->get()->toArray();
			}else{
				$students = array();
				$toReturn['totalItems'] = 0;
			}
		}else{
			$students = User::where('role','student')->where('activated','1');
			if(isset($searchQ) AND $searchQ != "" AND $searchQ != "undefined"){
				$students = $students->where(function($query) use ($searchQ){
										 $query->where('fullName','like','%'.$searchQ.'%')->orWhere('username','like','%'.$searchQ.'%')->orWhere('email','like','%'.$searchQ.'%');
									 });
			}
			if(isset($searchC) AND $searchC != "" AND $searchC != "undefined" AND $searchC != 0){
				$students = $students->where('studentClass',$searchC);
			}
			$toReturn['totalItems'] = $students->count();
			$students = $students->orderBy('studentRollId','ASC')->take('20')->skip(20* ($page - 1) )->get()->toArray();
		}

		$toReturn['classes'] = $classes = classes::where('classAcademicYear',$this->panelInit->selectAcYear)->get()->toArray();
		$classArray = array();
		while (list(, $value) = each($classes)) {
			$classArray[$value['id']] = $value['className'];
		}

		$toReturn['students'] = array();
		while (list(, $student) = each($students)) {
			$toReturn['students'][] = array('id'=>$student['id'],"studentRollId"=>$student['studentRollId'],"fullName"=>$student['fullName'],"username"=>$student['username'],"email"=>$student['email'],"isLeaderBoard"=>$student['isLeaderBoard'],"studentClass"=>isset($classArray[$student['studentClass']]) ? $classArray[$student['studentClass']] : "");
		}

		return $toReturn;
	}

	public function t()
	{
		//$auth = new Auth();
		//var_dump(Auth::test());
		$user = User::find(8);
	    //PaymentsController::generateInvoice($user);
		//StudentInfoHelper::generateInvoice($user);
		//var_dump(new student_academic_years());
		//echo $this->panelInit->selectAcYear;
		//echo "<br/>Finished";
		return $this->panelInit->apiOutput(true,$this->panelInit->language['addStudent'],$this->panelInit->language['studentCreatedSuccess'],$user->toArray());
	}

	public function sess()
	{
		Session::put('user','first user');
		var_dump(Session::get('user'));
		//var_dump(Session::has('hello'));
		//var_dump(Session::token());
		//$sess=new Session();
		//var_dump($sess->test());

	}

	public function form()
	{
		echo "<form method='post' action='http://localhost/nn/camocase/show' enctype='multipart/form-data'>
				<input type='text' name='name'/>
				<br/>
				<input type='file' name='user'/>
				<input type='submit' value='submit'/>
			</form>";
	}

	public function formv()
	{
		//$this->load->view('form');
		var_dump(uniqid());
	}

	public function show()
	{
		//$data = $this->input->post_get();
		//$data = Input::get();
		//var_dump($data);
		//var_dump($this->input->post('t'));
		//var_dump(Input::has('t'));
		//var_dump(Input::hasFile('user'));
		 $file = Input::file('user');
		//var_dump($file->getClientOriginalExtension());
		 $fileName = 'user'.'.'.$file->getClientOriginalExtension();
		 $file->move('upload/',$fileName);
		echo "Successfully Uploaded";
	}

	public function url()
	{
		//$this->load->helper('url');
		//echo base_url('up/v');
		//echo '</br>';
		//echo site_url('up/');

		echo URL::to('/schoo');
		echo "</br>";
		echo URL::asset('/');
	}

	public function schema()
	{
		//echo (Schema::hasTable('user'));
		//$users = Capsule::table('users')->where('id',1)->get();
		//$users = Capsule::select(Capsule::raw('select * from users'));
		//$users = DB::select(DB::raw('select * from users where id=1'));
		$data = DB::select(DB::raw("SELECT messages.id as id,messages.messageText as messageText,users.fullName as fullName FROM users LEFT JOIN  messages ON users.id=messages.fromId"));

		var_dump($data);
	}

	public function login()
	{
		Auth::attempt(array('username' => 'eagles', 'password' => 'password','activated'=>1));
		//var_dump(Auth::user());
		$user = Auth::user();
		echo $user['username'];
	}

	public function logout()
	{
		//Auth::logout();
		echo Redirect::to('/login');
	}

	public function set()
	{	$setingsArray=[];
		$settings = settings::get();
		foreach ($settings as $setting) {
			$settingsArray[$setting->fieldName] = $setting->fieldValue;
			//echo $setting->fieldName;
		}
		echo $settingsArray['layoutColor'];
		//var_dump($array);
	}

	public function hass()
	{
		echo hash('password');
	}

	public function redi()
	{
		//redirect('/');
		$d=['1','2'];
		var_dump(['1','2']);
		return $d[1];
	}

	public function view()
	{
		//return View::make('welcome_message');
		//echo View::make('welcome_message');
		return array();
	}

	public function redirect()
	{
		return Redirect::to('/camocase');
	}

	public function rwith()
	{
		return Redirect::to('/camocase/vwithdata')->withErrors('Welcome to edlac');
	}

	public function vwithdata()
	{	$this->load->library('wraper');
	
		return View::make('info');
	}

	public function err()
	{
		$err = new Err(array('error404'));
		if($err->any())
		{
			echo "Ok err available";
		}else
		{
			echo "No error";
		}
	}

	public function verr()
	{	
		$auth = new Auth();
		//$auth->getRecallerName();
		var_dump($auth);
		//View::make('info');
	}

	public function token()
	{
		//echo $this->security->get_csrf_hash();
		echo csrf_token();
	}

	public function formall()
	{
		echo "<form method='post' action='".URL::to('/')."/camocase/showform'>
				<input type='text' name='name'/>
				<br/>
				<input type='text' name='username'/>
				<input type='submit' value='submit'/>
			</form>";
	}

	public function showform()
	{	
		$d['1']= 2;
		$d['2'] = 3;
		//echo json_encode(Input::get());
		//echo $this->input->method();

		echo isset($d['5'])?$d['5']:'null';
		//echo null;
	}

	public function noth($s='')
	{
		//$d='Dont return ';
		//echo "Hello there ";
		//return array('ok');
		//View::make('welcome_message');
		$data = array('ok','Tell');
		$data = json_encode($data);
		if(is_array($data))
		{
			$data = json_encode($data);
		}
		echo $data;
	}

	public function check()
	{
		//$d = $this->noth();
		$p =[];
		$m = '__destruct';
		$d = call_user_func_array(['camocase',$m],$p );
		if($d ==null)
		{
			echo "Yes it work";

		}else
		{
			echo $d;
		}
	}

	public function rtest()
	{
		$obj = classes::get();
		if (is_array($obj)) {		

			echo "Yes is an array";
		}
		if(is_string($obj))
		{
			echo "Yes is string";
		}
		if (is_object($obj)) {
			echo "Yes is an Object";
			echo "<br/>";
		}
		if(method_exists($obj, '__toString'))
		{
			echo "Yes method exit";
		}
		echo null;



	}

	public function reg()
	{
		$str = 'path/to/{go}/{id}';
		$str2 = 'path/to/';

		$arr = explode('{', $str);
		var_dump($arr);
		foreach ($arr as $val) {
			if($val =='id}')
			echo "Yes is id";
		}
		echo count($arr);

	}

	public function apush()
	{	
		$hello = 'hello there';
		$a = [];
		array_push($a,['2']);
		var_dump($a);
		//echo $hello[4];
		echo '$hello\'';
		//echo "$hello[8] world \$a";
	}

	public function req()
	{
		$DashboardController = new StudentInfoHelper();
		$cl=$DashboardController->classesList('1');
		var_dump($cl);
		echo "Hello there";
	}

	public function debug()
	{	
		$page = 1;
		$user = 1;
		$messageId =1;
		
		$toReturn['totalItems'] = messages_list::where('userId',$user)->count();

		$toReturn['messageDet'] = DB::select(DB::raw("SELECT messages_list.id as id,messages_list.lastMessageDate as lastMessageDate,messages_list.userId as fromId,messages_list.toId as toId,users.fullName as fullName,users.id as userId,users.photo as photo from messages_list LEFT JOIN users ON users.id=messages_list.toId where messages_list.id='$messageId' AND messages_list.userId='".$user."' order by id DESC"));

		/*$toReturn['messages'] = DB::select(DB::raw("SELECT messages.id as id,messages.fromId as fromId,messages.messageText as messageText,messages.dateSent as dateSent,users.fullName as fullName,users.id as userId,users.photo as photo FROM messages LEFT JOIN users ON users.id=messages.fromId where messages.userId='".$user."' AND ( (messages.fromId='".$user."' OR messages.fromId='".$toReturn['messageDet']->toId."' ) AND (messages.toId='".$user"' OR messages.toId='".$toReturn['messageDet']->toId."' ) ) order by id DESC limit 20"))*/;

		var_dump($toReturn['messageDet']);
		//var_dump($toReturn['totalItems']);

	}

	public function angularDebug()
	{
		$str = " var xhr = new XMLHttpRequest();
		    xhr.open('GET', 'messages/'+id, false);
		    xhr.onload = function (e) {
		      if (xhr.readyState === 4){ 
		          if (xhr.status === 200){
		            //$rootScope.dashboardData = JSON.parse(xhr.responseText);
		            alert(xhr.responseText);
		          }
		      }
		    };

		    xhr.send(null)";
	}

	public function eod()
	{
		$err = <<<EOD
				"<div style="border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;">
				<h4>A PHP Error was encountered</h4>
				<p>Severity: Notice</p>
				<p>Message:  Trying to get property of non-object</p>
				<p>Filename: controllers/MessagesController.php</p>
				<p>Line Number: 36</p>
					<p>Backtrace:</p>
					
							<p style="margin-left:10px">
							File: C:\wamp\www\nn\application\controllers\MessagesController.php<br />
							Line: 36<br />
							Function: _error_handler			</p>
						
							<p style="margin-left:10px">
							File: C:\wamp\www\nn\index.php<br />
							Line: 316<br />
							Function: require_once			</p>	

				</div>
				<div style="border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;">

				<h4>A PHP Error was encountered</h4>

				<p>Severity: Notice</p>
				<p>Message:  Trying to get property of non-object</p>
				<p>Filename: controllers/MessagesController.php</p>
				<p>Line Number: 36</p>

					<p>Backtrace:</p>
								
							<p style="margin-left:10px">
							File: C:\wamp\www\nn\application\controllers\MessagesController.php<br />
							Line: 36<br />
							Function: _error_handler			</p>
						
							<p style="margin-left:10px">
							File: C:\wamp\www\nn\index.php<br />
							Line: 316<br />
							Function: require_once			</p>	

				</div>" 
EOD;
echo $err;
	}

	//protected $data = [];
	public function fetch()
	{	
		$messageId = 1;
		$page = 1;
		//$this->data['users'] = User::where('id',1)->first();
		$toReturn = array();
		$toReturn['user'] = $this->data['users'];
		$toReturn['messageDet'] = DB::select(DB::raw("SELECT messages_list.id as id,messages_list.lastMessageDate as lastMessageDate,messages_list.userId as fromId,messages_list.toId as toId,users.fullName as fullName,users.id as userId,users.photo as photo from messages_list LEFT JOIN users ON users.id=messages_list.toId where messages_list.id='$messageId' AND userId='".$this->data['users']->id."' order by id DESC"));
		if(count($toReturn['messageDet']) > 0){
			$toReturn['messageDet'] = $toReturn['messageDet'][0];
		}else{
			return json_encode(array("jsTitle"=>$this->panelInit->language['readMessage'],"jsStatus"=>"0","jsMessage"=>$this->panelInit->language['messageNotExist'] ));
			exit;
		}
		$toReturn['messages'] = DB::select(DB::raw("SELECT messages.id as id,messages.fromId as fromId,messages.messageText as messageText,messages.dateSent as dateSent,users.fullName as fullName,users.id as userId,users.photo as photo FROM messages LEFT JOIN users ON users.id=messages.fromId where messages.userId='".$this->data['users']->id."' AND ( (messages.fromId='".$this->data['users']->id."' OR messages.fromId='".$toReturn['messageDet']->toId."' ) AND (messages.toId='".$this->data['users']->id."' OR messages.toId='".$toReturn['messageDet']->toId."' ) ) order by id DESC limit 20"));
		$json = json_encode($toReturn);
		 //var_dump($toReturn);
		//var_dump($json);
		echo $json;
	}

	public function user()
	{	//var_dump($this->data['users']);
		//var_dump(Auth::user());
		$std = new stdClass();
		$std->name = "Gbolahan";
		$std->friend = "Biodun";
		//$json = json_encode($std);
		//$arr = ["1","2","3"];
		//$str = implode(',', $arr);
		//var_dump($str);
		//$j = new Jtest();
		//echo User::where('id',1)->first();
		//echo User::get();
		echo json_encode(User::get()->first());
		//var_dump(User::get()->toArray());

	}

	public function jsons()
	{
		$jtest = new Jtest();
		$jtest->name = "Olaitan Gbolahan";
		$jtest->title = "Engr";
		//var_dump($jtest);
		//echo json_encode($jtest);
		var_dump(json_encode(Auth::user()));
	}

	public function getreport()
	{	

		$param = ['examId'=>0, 'classId'=>0, 'panelInit'=>$this->panelInit];
		$this->load->library('Stdreport',$param);

		$test = $this->stdreport->marksheet(30);
		//$test = $this->stdreport->marksheet(4);
		//var_dump($test[1]);
		//print_r($test);
		//echo $test;
		return $test;

	}
	public function ex()
	{
		$examsList = exams_list::where('examAcYear',$this->panelInit->selectAcYear)->get();
		//var_dump($examsList);
		foreach ($examsList as $exam) {
			echo $exam->id."  ".$exam->examTitle;
			echo "<br/>";
		}
	}

	public function datec()
	{
		//$format = 'Y-m-d';
		$format = 'm/d/Y';
		$date = '11/28/2004';
		//$date = '2016-11-04';
		$d = DateTime::createFromFormat($format, $date);
		//$d->format('d/m/Y');
		//$d->setTime(0,0,0);
		$ts = abs($d->getTimestamp());
		var_dump($d->getTimestamp());

	}

	function unixToDate()
	{	
		$format = "d/m/Y";
		$timestamp ='1471903200';
		$currentTime = DateTime::createFromFormat( 'U', $timestamp);
		echo ( $currentTime->format( $format ));
	}


	function trm()
	{
		//$data ='08108013285';
		//echo (ltrim($data,'0'));

		/*$data=['Biodun','password','Off you go '];
		list($name,,$mess) = $data;

		echo $name.' '.$mess;*/
		var_dump(getDate());
	}
}