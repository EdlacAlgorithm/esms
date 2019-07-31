<?php

Class StudentInfoHelper{

	public function classesList($academicYear = ""){
		$toReturn = array();
		$classesList = array();

		if(is_array($academicYear)){
			$classesList = classes::whereIn('classAcademicYear',$academicYear)->get()->toArray();
		}else{
			$classesList = classes::where('classAcademicYear',$academicYear)->get()->toArray();
		}

		$toReturn['classes'] = $classesList;

		$classesListIds = array();
		while (list($key, $value) = each($classesList)) {
			$classesListIds[] = $value['id'];
		}

		$sectionsList = array();
		if(count($classesListIds) > 0){
			$sections = sections::whereIn('classId',$classesListIds)->get()->toArray();
			while (list($key, $value) = each($sections)) {
				$sectionsList[$value['classId']][] = $value;
			}
		}
		$toReturn['sections'] = $sectionsList;

		return $toReturn;
	}


	public function sectionsList($classes = ""){
		$sectionsList = array();

		if(is_array($classes)){
			return sections::whereIn('classId',$classes)->get()->toArray();
		}else{
			return sections::where('classId',$classes)->get()->toArray();
		}
	} 

	public function subjectList($classes = ""){
		$subjectList = array();
		$classesCount = 1;

		if(is_array($classes)){
			$classes = classes::whereIn('id',$classes);
			$classesCount = count($classes);
		}else{
			$classes = classes::where('id',$classes);
		}

		$classes = $classes->get()->toArray();

		while (list(, $value) = each($classes)) {
			$value['classSubjects'] = json_decode($value['classSubjects'],true);
			if(is_array($value['classSubjects'])){
				while (list(, $value2) = each($value['classSubjects'])) {
					$subjectList[] = $value2;
				}
			}
		}

		if($classesCount == 1){
			$finalClasses = $subjectList;
		}else{
			$subjectList = array_count_values($subjectList);

			$finalClasses = array();
			while (list($key, $value) = each($subjectList)) {
				if($value == $classesCount){
					$finalClasses[] = $key;
				}
			}
		}

		if(count($finalClasses) > 0){
			$user = Auth::user();
			
			if($user->role == "teacher"){
				return subject::where('teacherId','LIKE','%"'.$user->id.'"%')->whereIn('id',$finalClasses)->get()->toArray();
			}else{
				return subject::whereIn('id',$finalClasses)->get()->toArray();
			}
		}

		return array();
	}


	public static function generateInvoice($user)
	{
		if($user->studentClass == "" || $user->studentClass == "0"){
			return;
		}

		$feeAllocationUser = fee_allocation::where('allocationType','student')->where('allocationId',$user->id);
		if($feeAllocationUser->count() > 0){
			$feeAllocationUser = $feeAllocationUser->first();
		}

		if(!isset($feeAllocationUser->allocationValues)){
			$feeAllocationUser = fee_allocation::where('allocationType','class')->where('allocationId',$user->studentClass);
		}
		if($feeAllocationUser->count() > 0){
			$feeAllocationUser = $feeAllocationUser->first();
		}

		if(!isset($feeAllocationUser->allocationValues)){
			return;
		}

		$feeTypesArray = array();
		$feeTypes = fee_type::get();
		foreach($feeTypes as $type){
			$feeTypesArray[$type->id] = $type->feeTitle;
		}

		$paymentDescription = array();
		$paymentAmount = 0;
		$allocationValues = json_decode($feeAllocationUser->allocationValues,true);
		while (list($key, $value) = each($allocationValues)) {
			if(isset($feeTypesArray[$key])){
				$paymentDescription[] = $feeTypesArray[$key];
				$paymentAmount += $value;
			}
		}

		$payments = new payments();
		$payments->paymentTitle = "School Fees";
		$payments->paymentDescription = implode(", ",$paymentDescription);
		$payments->paymentStudent = $user->id;
		$payments->paymentAmount = $paymentAmount;
		$payments->paymentStatus = "0";
		$payments->paymentDate = time();
		$payments->paymentUniqid = uniqid();
		$payments->save();

	}

}