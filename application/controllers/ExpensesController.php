<?php

class ExpensesController extends MyController {

	var $data = array();
	var $panelInit ;
	var $layout = 'dashboard';

	public function __construct(){
	    parent::__construct();
		$this->panelInit = new \DashboardInit();
		$this->data['panelInit'] = $this->panelInit;
		$this->data['breadcrumb']['Settings'] = \URL::to('/dashboard/languages');
		$this->data['users'] = \Auth::user();
		if($this->data['users']->role != "admin") exit;

		if(!$this->data['users']->hasThePerm('accounting')){
			exit;
		}
	}

	public function listAll()
	{
		$toReturn = array();
		$expenses = expenses::get()->toArray();

		while (list(, $value) = each($expenses)) {
			$toReturn[date('F',$value['expenseDate'])][] = $value;
		}

		return $toReturn;
	}

	public function delete($id){
		if ( $postDelete = expenses::where('id', $id)->first() )
        {
            $postDelete->delete();
            return $this->panelInit->apiOutput(true,$this->panelInit->language['delExpense'],$this->panelInit->language['expenseDeleted']);
        }else{
            return $this->panelInit->apiOutput(false,$this->panelInit->language['delExpense'],$this->panelInit->language['expenseNotExist']);
        }
	}

	public function create(){
		$expenses = new expenses();
		$expenses->expenseDate = $this->panelInit->dateToUnix(Input::get('expenseDate'));
		$expenses->expenseTitle = Input::get('expenseTitle');
		$expenses->expenseAmount = Input::get('expenseAmount');
		if(Input::has('expenseNotes')){
			$expenses->expenseNotes = Input::get('expenseNotes');
		}
		$expenses->save();

		$expenses->month = date('F',$expenses->expenseDate);

		return $this->panelInit->apiOutput(true,$this->panelInit->language['addExpense'],$this->panelInit->language['expenseAdded'],$expenses->toArray() );
	}

	function fetch($id){
		$expenses = expenses::where('id',$id)->first();
		return $expenses;
	}

	function edit($id){
		$expenses = expenses::find($id);
		$expenses->expenseDate = $this->panelInit->dateToUnix(Input::get('expenseDate'));
		$expenses->expenseTitle = Input::get('expenseTitle');
		$expenses->expenseAmount = Input::get('expenseAmount');
		if(Input::has('expenseNotes')){
			$expenses->expenseNotes = Input::get('expenseNotes');
		}
		$expenses->save();

		$expenses->month = date('F',$expenses->expenseDate);

		return $this->panelInit->apiOutput(true,$this->panelInit->language['editExpense'],$this->panelInit->language['expenseUpdated'],$expenses->toArray() );
	}
}
