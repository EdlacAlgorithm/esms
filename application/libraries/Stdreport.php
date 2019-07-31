<?php

Class Stdreport{

    protected $exam_id;

    protected $class_id;

    protected $panelInit ;

    protected $type ;

    function __construct($param)
    {   
        $this->load->database();

        $this->load->helper('url');

        $this->panelInit = $param['panelInit'];

        $this->exam_id = $param['examId'];

        $this->class_id = $param['classId'];

        $this->type = $param['type'];

        if(!Auth::user()->hasThePerm('students')){
            exit;
        }
    }


     function marksheetBulk(){
        
         if ($this->exam_id > 0 && $this->class_id > 0 ) {

            //$students = User::where('studentClass',$this->class_id)->get();

            // $students = DB::table('student_academic_years')
            //                 ->join('users', 'student_academic_years.studentId', '=', 'users.id')
            //                 ->get();

            $students = DB::table('student_academic_years')
                            ->join('users', 'student_academic_years.studentId', '=', 'users.id')
                            ->where('classId',$this->class_id)
                            ->where('academicYearId',$this->panelInit->selectAcYear)
                            ->get();
            
            $examsList = exams_list::where('id',$this->exam_id)->first();
            
            $content = "";
            foreach ($students as $student)
            {   
                $studentMarks = $this->marksheet($student->id);
                
                if(!isset($studentMarks[$this->exam_id]['data']))
                {
                    continue;
                }

                $count=0;
                $totalMarks=0;

                $headSection = $this->getReportHeadSection($student);
                
                $bodySection = $this->getReportBodySection($student,$studentMarks,$totalMarks,$count);
                
                if($count == 0)
                {
                    continue;
                }

                if($this->type =='print')
                {
                    $footerSection = $this->getReportFooterSectionFormat($student,$totalMarks,$count);
                }
                else
                {
                    $footerSection = $this->getReportFooterSection($student,$totalMarks,$count);
                }
                

                $content .="<div class='box' >
                                <div id='wrapper'>";          
                $content .= $headSection;
                if(!isset($studentMarks[$this->exam_id]['data'])){
                    $content .= "No report sheet";
                }else{
                    $content .= $bodySection;
                    $content .= "<br/><br/>";
                    $content .= $footerSection;
                }
                $content .=    "</div>
                            </div>";
            }

            $html = $this->getHtml($content);
                   
               //echo($html);
            return $html;
               // exit;
            }
        
    }

    function marksheetBulkPDF(){
           
         if ($this->exam_id > 0 && $this->class_id > 0 ) {

            $users = User::where('studentClass',$this->class_id)->get();
            $examsList = exams_list::where('id',$this->exam_id)->first();

            $content = "";
            //return $users;
            foreach ($users as $student) {
                $studentMarks = $this->marksheet($student->id);
                $count=0;
                $totalMarks=0;
                $headSection = $this->getReportHeadSection($student);
                $bodySection = $this->getReportBodySection($student,$studentMarks,$totalMarks,$count);

                if($count == 0)
                {
                    continue;
                }

                $footerSection = $this->getReportFooterSectionFormat($student,$totalMarks,$count);

                $content .="<page backtop='10mm' backbottom='10mm' backleft='10mm' backright='10mm' footer='date;heure;page'>
                        <br/>";          
                $content .= $headSection;
                if(!isset($studentMarks[$this->exam_id]['data'])){
                    $content .= "No report sheet";
                }else{
                    $content .= $bodySection;
                    $content .= "<br/><br/>";
                    $content .= $footerSection;
                }
                $content .= "</page>";
            }
            //$html = $this->getHtml($content);
                   
                //echo($html);
            return $content;
                
                //exit;
            }
        }

    function getReportHeadSection($student){
        return "<table cellspacing='0' style='padding: 1px; width: 100%; font-size: 11pt;'>
                    <tr>
                        <th style='width: 100%; text-align: center; '> <h3>MULTIGRACE SCHOOLS</h3> </th>
                    </tr>
                </table>              
                <table cellspacing='5' style='width: 100%; font-size: 12px;'>
                        <tr>
                            <td style='width: 20%; color: #444444;text-align: left;'>

                                <table cellspacing='0' style='width: 80%;text-align: left;'>
                                    <tr>
                                        <td style='width:100%; '>
                                            <img src='".$this->logo()."'/>   
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td style='width: 45%;text-align: left;'>

                                <table cellspacing='0' cellpadding='0' style='width: 100%;text-align: left;'>
                                    <tr>
                                        <td style='width:100%;text-align: left;' colspan='2'><b>School Information</b></td>
                                    </tr>
                                    <tr>
                                        <td style='width:20%;'>Address :</td>
                                        <td style='width:80%'>
                                            ".$this->panelInit->settingsArray['address']."
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style='width:20%;'>Session :</td>
                                        <td style='width:80%'>".$this->db->get_where('academic_year',array('id'=>$this->panelInit->selectAcYear))->row()->yearTitle."</td>
                                    </tr>
                                    <tr>
                                        <td style='width:20%;'> E-mail :</td>
                                        <td style='width:80%'>".$this->panelInit->settingsArray['systemEmail']."</td>
                                    </tr>
                                    <tr>
                                        <td style='width:20%;'> Phone :</td>
                                        <td style='width:80%'>".$this->panelInit->settingsArray['phoneNo']."</td>
                                    </tr>
                                </table>
                            </td>                           
                            <td style='width: 35%; color: #444444;text-align: left;'>
                                <table cellspacing='0' style='width: 100%;text-align: left;'>
                                    <tr>
                                        <td style='width:100%;text-align: left;' colspan='2'><b>Student Information</b></td>
                                    </tr>
                                    <tr>
                                        <td style='width:20%;'>Name :</td>
                                        <td style='width:80%;text-align: left;'>".$student->fullName."</td>
                                    </tr>
                                    <tr>
                                        <td style='width:20%; '>Class :</td>
                                        <td style='width:80%'>".$this->db->where('id',$this->class_id)->get('classes')->row()->className."</td>
                                    </tr>
                                    <tr>
                                        <td style='width:20%; '>Term :</td>
                                        <td style='width:80%'>".$this->getTerm()."</td>
                                    </tr>
                                    <tr>
                                        <td style='width:10%; '>E-mail:</td>
                                        <td style='width:90%'>".$student->email."</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>       
                    <table cellspacing='0' style='padding: 0px; width: 100%; font-size: 9pt; '>
                        <tr>
                            <th style='width:100%; text-align:center; '> <h5>STUDENT REPORT SHEET</h5></th>
                        </tr>
                    </table>";

    }


    function getReportBodySection($student,$studentMarks,&$totalMarks,&$count){
        $content="";
        $content = "<table cellspacing='0' style='padding: 0px;margin:0px; width: 100%; border: solid 1px black; '>
                        <tbody>
                            <tr>
                                <th style='width:28%;border: solid 1px #000000; padding:2px;'>Subject</th>
                                <th style='width:12%;border: solid 1px #000000; padding:2px;'>C.A(40)</th>
                                <th style='width:12%;border: solid 1px #000000; padding:2px;'>Exam(60)</th>
                                <th style='width:12%;border: solid 1px #000000; padding:2px;'>Total(100)</th>
                                <th style='width:12%;border: solid 1px #000000; padding:2px;'>GP</th>
                                <th style='width:12%;border: solid 1px #000000; padding:2px;'>ClassAve</th>
                                <th style='width:12%;border: solid 1px #000000; padding:2px;'>Position</th>
                            </tr>";
                          
        foreach ($studentMarks[$this->exam_id]['data'] as $value) { 
                if( 
                    (
                        $value['test_obtained'] == 0 && 
                        $value['mark_obtained'] == 0
                    ) 
                    || 
                    ( 
                        is_null($value['test_obtained']) || 
                        is_null($value['mark_obtained'])
                    )
                ) 
                {
                    continue;
                    /*$content .= "<tr>
                            <td style='border: solid 1px #000000;padding:2px;'>".@$value['subject_name']."</td>
                            <td style='border: solid 1px #000000;padding:2px;'>_</td>
                            <td style='border: solid 1px #000000;padding:2px;'>_</td>
                            <td style='border: solid 1px #000000;padding:2px;'>_</td>
                            <td style='border: solid 1px #000000;padding:2px;'>_</td>
                            <td style='border: solid 1px #000000;padding:2px;'>_</td>
                            <td style='border: solid 1px #000000;padding:2px;'>_</td>
                        </tr>";*/
                }
                /*else
                {*/

                    $count+=1;

                    $totalMarks += $value['test_obtained'] + $value['mark_obtained'];
                    $content .= "<tr>
                            <td style='border: solid 1px #000000;padding:2px;'>".@$value['subject_name']."</td>
                            <td style='border: solid 1px #000000;padding:2px;'>".@$value['test_obtained']."</td>
                            <td style='border: solid 1px #000000;padding:2px;'>".@$value['mark_obtained']."</td>
                            <td style='border: solid 1px #000000;padding:2px;'>".($value['test_obtained'] + $value['mark_obtained'])."</td>
                            <td style='border: solid 1px #000000;padding:2px;'>".@$value['grade_point']."</td>
                            <td style='border: solid 1px #000000;padding:2px;'>".@$value['class_average']."</td>
                            <td style='border: solid 1px #000000;padding:2px;'>".$this->position($value['test_obtained'] + $value['mark_obtained'],$value['subject_id'])."</td>
                        </tr>";
                //}
        }

        $content.=  "</tbody>
                   </table>";
        return $content;

    }

    function getReportFooterSection($student,$totalMarks,$count){
        return "<table cellspacing='0' style='padding: 1px; width: 100%; font-size: 10pt; '>
                   <tr>
                        <th style='width: 100%; text-align: center; '> Total marks : ".$totalMarks." - Average points : ".round($totalMarks / $count,1)."%"." </th>
                    </tr>
                </table>
                <br/><br/>
                <table cellspacing='5' style='width: 100%; font-size: 12px;'>
                    <tr>
                        <td style='width: 60%; color: #444444;'>
                            <table cellspacing='0' style='width: 80%;border: solid 1px #000;'>
                                <tr style='border-bottom: solid 1px #000'>
                                    <th style='width:40%;border-bottom: solid 1px #000'>Frequency</th>
                                    <th style='width:60%;border-bottom: solid 1px #000;border-left: solid 1px #000'>SchoolAttendance</th>
                                </tr>
                                <tbody>
                                <tr>
                                    <td style='border-bottom: solid 1px #000'>Time School Open</td>
                                    <td style='border-bottom: solid 1px #000;border-left: solid 1px #000;text_align:center;'>".$this->getTimesSchoolOpen()."</td>
                                </tr>
                                <tr>
                                    <td style='border-bottom: solid 1px #000'>Time Present</td>
                                    <td style='border-bottom: solid 1px #000;border-left: solid 1px #000'>
                                        <textarea  class='txtarea txta' data-id='".$student->id."' data-type='timesPresent' style='font-size: 14px;'>".$this->getPresent($student->id)."</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Time Absent</td>
                                    <td style='border-left: solid 1px #000' id='".$student->id."' data-schooltimes='".$this->getTimesSchoolOpen()."'>".$this->getAbsent($student->id)."</td>
                                </tr>
                                </tbody>
                            </table>
                            <br/><br/>
                            <table cellspacing='0' style='width: 80%;text-align: left;border: solid 1px #000;'>
                                <tr>
                                    <td style='width:40%;border-bottom: solid 1px #000'>Closing Date</td>
                                    <td style='width:60%;border-bottom: solid 1px #000;border-left: solid 1px #000'>".$this->getSchoolDate('closingDate')."</td>
                                </tr>
                                <tr>
                                    <td>Resumption Date</td>
                                    <td style='border-left: solid 1px #000;'>".$this->getSchoolDate('resumptionDate')."</td>
                                </tr>
                            </table>
                        </td>
                        <td style='width: 40%;text-align: left;'>
                            <table cellspacing='0' cellpadding='0' style='width: 100%;text-align: left;border: solid 1px #000;'>
                                <tr>
                                    <th style='width:40%;border-bottom: solid 1px #000;padding:1px;'>Skills</th>
                                    <th style='width:60%;border-bottom: solid 1px #000;border-left: solid 1px #000;padding:1px;'>Remark</th>
                                </tr>
                               <tr>
                                   <td style='border-bottom: solid 1px #000;padding:1px;'>Hand Writing</td>
                                   <td style='border-bottom: solid 1px #000;padding:1px;border-left: solid 1px #000'>
                                     <textarea class='txtarea txta' data-type='handWriting' data-id='".$student->id."'>".$this->getRemark($student->id,'handWriting')."</textarea>
                                   </td>
                               </tr>
                               <tr>
                                   <td style='border-bottom: solid 1px #000;padding:1px;'>Verbal Fluency</td>
                                   <td style='border-bottom: solid 1px #000;padding:1px;border-left: solid 1px #000'>
                                        <textarea  class='txtarea txta' data-type='verbalFluency' data-id='".$student->id."' >".$this->getRemark($student->id,'verbalFluency')."</textarea>
                                   </td>
                               </tr>
                               <tr>
                                   <td style='border-bottom: solid 1px #000;padding:1px;'>Sport</td>
                                   <td style='border-bottom: solid 1px #000;padding:1px;border-left: solid 1px #000'>
                                        <textarea  class='txtarea txta' data-id='".$student->id."' data-type='sport'>".$this->getRemark($student->id,'sport')."
                                        </textarea>
                                   </td>
                               </tr>
                               <tr>
                                   <td style='border-bottom: solid 1px #000;padding:1px;'>Handing tools</td>
                                   <td style='border-bottom: solid 1px #000;padding:1px;border-left: solid 1px #000'>
                                        <textarea  class='txtarea txta' data-id='".$student->id."' data-type='handingTools'>".$this->getRemark($student->id,'handingTools')."
                                        </textarea>
                                   </td>
                               </tr>
                               <tr>
                                   <td style='border-bottom: solid 1px #000;padding:1px;'>Drawing and Painting</td>
                                   <td style='border-bottom: solid 1px #000;padding:1px;border-left: solid 1px #000'>
                                        <textarea  class='txtarea txta' data-id='".$student->id."' data-type='drawingPainting'>".$this->getRemark($student->id,'drawingPainting')."
                                        </textarea>
                                   </td>
                               </tr>
                               <tr>
                                   <td style='padding:2px;'>Musical Skills</td>
                                   <td style='border-left: solid 1px #000;padding:1px;'>
                                        <textarea  class='txtarea txta' data-id='".$student->id."' data-type='musicalSkills'>".$this->getRemark($student->id,'musicalSkills')."
                                        </textarea>
                                   </td>
                               </tr>
                            </table>
                        </td>                           
                    </tr>
                </table>
                <br/>
                <table cellspacing='0' style='padding: 4px; width: 100%; font-size: 11pt;border: solid 1px #000'>
                    <tr>
                        <td>
                            <table cellspacing='0' style='padding: 1px; width: 100%; font-size: 11pt;margin-bottom:4px;'>
                                <tr>
                                    <td style='width: 15%;'>Teacher Remark: </td>
                                    <td style='width: 85%;text-align:left;'>
                                       <textarea data-id='".$student->id."' 
                                            data-type='teacherRemark' class='txtarea'>".$this->getRemark($student->id,'teacherRemark')." 
                                       </textarea>
                                    </td>
                                </tr>
                            </table> 
            
                            <table cellspacing='0' style='padding: 1px; width: 100%; font-size: 11pt;margin-bottom:6px;'>
                                <tr>
                                    <td style='width: 15%;'>Principal Remark: </td>
                                    <td style='width: 85%;text-align:left;'>
                                       <textarea  class='txtarea' data-id='".$student->id."' data-type='principalRemark'>".$this->getRemark($student->id,'principalRemark')."
                                       </textarea>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>";
    }

    function getReportFooterSectionFormat($student,$totalMarks,$count){
        return "<table cellspacing='0' style='padding: 1px; width: 100%; font-size: 10pt; '>
                   <tr>
                        <th style='width: 100%; text-align: center; '> Total marks : ".$totalMarks." - Average points : ".round($totalMarks / $count,1)."%"." </th>
                    </tr>
                </table>
                <br/><br/>
                <table cellspacing='5' style='width: 100%; font-size: 12px;'>
                    <tr>
                        <td style='width: 60%; color: #444444;'>
                            <table cellspacing='0' style='width: 80%;border: solid 1px #000;'>
                                <tr style='border-bottom: solid 1px #000'>
                                    <th style='width:40%;border-bottom: solid 1px #000'>Frequency</th>
                                    <th style='width:60%;border-bottom: solid 1px #000;border-left: solid 1px #000'>SchoolAttendance</th>
                                </tr>
                                <tbody>
                                <tr>
                                    <td style='border-bottom: solid 1px #000'>Time School Open</td>
                                    <td style='border-bottom: solid 1px #000;border-left: solid 1px #000;text_align:center;'>".$this->getTimesSchoolOpen()."</td>
                                </tr>
                                <tr>
                                    <td style='border-bottom: solid 1px #000'>Time Present</td>
                                    <td style='border-bottom: solid 1px #000;border-left: solid 1px #000'>
                                        ".$this->getPresent($student->id)."
                                    </td>
                                </tr>
                                <tr>
                                    <td>Time Absent</td>
                                    <td style='border-left: solid 1px #000' id='".$student->id."' data-schooltimes='".$this->getTimesSchoolOpen()."'>".$this->getAbsent($student->id)."</td>
                                </tr>
                                </tbody>
                            </table>
                            <br/><br/>
                            <table cellspacing='0' style='width: 80%;text-align: left;border: solid 1px #000;'>
                                <tr>
                                    <td style='width:40%;border-bottom: solid 1px #000'>Closing Date</td>
                                    <td style='width:60%;border-bottom: solid 1px #000;border-left: solid 1px #000'>".$this->getSchoolDate('closingDate')."</td>
                                </tr>
                                <tr>
                                    <td>Resumption Date</td>
                                    <td style='border-left: solid 1px #000;'>".$this->getSchoolDate('resumptionDate')."</td>
                                </tr>
                            </table>
                        </td>
                        <td style='width: 40%;text-align: left;'>
                            <table cellspacing='0' cellpadding='0' style='width: 100%;text-align: left;border: solid 1px #000;'>
                                <tr>
                                    <th style='width:40%;border-bottom: solid 1px #000;padding:1px;'>Skills</th>
                                    <th style='width:60%;border-bottom: solid 1px #000;border-left: solid 1px #000;padding:1px;'>Remark</th>
                                </tr>
                               <tr>
                                   <td style='border-bottom: solid 1px #000;padding:1px;'>Hand Writing</td>
                                   <td style='border-bottom: solid 1px #000;padding:1px;border-left: solid 1px #000'>
                                     ".$this->getRemark($student->id,'handWriting')."
                                   </td>
                               </tr>
                               <tr>
                                   <td style='border-bottom: solid 1px #000;padding:1px;'>Verbal Fluency</td>
                                   <td style='border-bottom: solid 1px #000;padding:1px;border-left: solid 1px #000'>
                                        ".$this->getRemark($student->id,'verbalFluency')."
                                   </td>
                               </tr>
                               <tr>
                                   <td style='border-bottom: solid 1px #000;padding:1px;'>Sport</td>
                                   <td style='border-bottom: solid 1px #000;padding:1px;border-left: solid 1px #000'>
                                        ".$this->getRemark($student->id,'sport')."
                                   </td>
                               </tr>
                               <tr>
                                   <td style='border-bottom: solid 1px #000;padding:1px;'>Handing tools</td>
                                   <td style='border-bottom: solid 1px #000;padding:1px;border-left: solid 1px #000'>
                                       ".$this->getRemark($student->id,'handingTools')."
                                   </td>
                               </tr>
                               <tr>
                                   <td style='border-bottom: solid 1px #000;padding:1px;'>Drawing and Painting</td>
                                   <td style='border-bottom: solid 1px #000;padding:1px;border-left: solid 1px #000'>
                                        ".$this->getRemark($student->id,'drawingPainting')."
                                   </td>
                               </tr>
                               <tr>
                                   <td style='padding:2px;'>Musical Skills</td>
                                   <td style='border-left: solid 1px #000;padding:1px;'>
                                        ".$this->getRemark($student->id,'musicalSkills')."
                                   </td>
                               </tr>
                            </table>
                        </td>                           
                    </tr>
                </table>
                <br/><br/>

                <table cellspacing='0' style='width: 100%;text-align: left;border: solid 1px #000;'>
                    <tr>
                        <td style='width:25%;border-bottom: solid 1px #000'>Teacher Remark</td>
                        <td style='width:75%;border-bottom: solid 1px #000;border-left: solid 1px #000'>".$this->getRemark($student->id,'teacherRemark')."</td>
                    </tr>
                    <tr>
                        <td>Principal Remark</td>
                        <td style='border-left: solid 1px #000;'>".$this->getRemark($student->id,'principalRemark')."</td>
                    </tr>
                </table>";
    }

    function getHtml($content){
        $html = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
                <html>
                <head>
                <link rel="shortcut icon" href="'.base_url().'assets/img/favicon.png">
                    <meta charset="utf-8">
                    <link rel="stylesheet" href="'.base_url().'assets/css/toastr.css">
                    <title>Report</title>  
                    <style>
                     * { padding: 0;
                         margin: 0; }
                     html { height: 100%;
                            /* Font size is needed to make the activity bar the correct size. */
                               font-size: 10px; }
                        body {width:100%;
                              height: 100%; }
                    .box{ max-width:992px;
                          height:889px;
                          margin:auto;
                          padding:30px;
                          border:1px solid #eee;
                          box-shadow:0 0 10px rgba(0, 0, 0, .15);
                          font-size:14px;      
                          font-family:Verdana;
                          color:#555;}
                    .box #wrapper{ max-width:889px;
                                   margin:auto;}
                    .txtarea{ font-size: 12pt;
                              border: 0;
                              border-bottom: 1px solid #000;
                              width: 100%;
                              height: 16px;
                              text-align: left !important;
                              overflow: hidden;
                              resize: none;} 
                     .txta{border:0px;}
                     textarea.spinner{background: url("'.base_url().'assets/img/loader-2.gif") right no-repeat !important;}
                    </style>
                    </head>
                     <body style="font-size:10pt;font-family:Verdana!important;" id="body" data-examid="'.$this->exam_id.'">';
               $html.= $content; 
               $html.= "<script src='".base_url()."assets/js/jquery.min.js'></script>
                        <script src='".base_url()."assets/js/toastr.js'></script>
                        <script>
                            function mess(message=''){
                                if(message!=''){
                                   toastr.success(message);}
                                else{
                                   toastr.success('An error occur!');}
                            }
                            
                            function updateAbsent(id,times_present,element){
                                var times_school_open = $('#'+id).data('schooltimes'),
                                    times_absent = '--';
                                    if(times_school_open != '--')
                                    {
                                        times_absent = times_school_open - times_present;
                                    }
                                    else
                                    {
                                        element.val('--');
                                    }
                                    
                                $('#'+id).html(times_absent);   
                            }

                          $(document).ready(function(){
                            
                            $('.txtarea').change(function(e){
                                var student_id = $(this).data('id'),
                                    type = $(this).data('type'),
                                    remark = $(this).val(),
                                    element = $(this),
                                    exam_id = $('#body').data('examid'),
                                    url = '".base_url()."students/saveRemark/'+student_id+'/'+type+'/'+exam_id;
                               $(this).addClass('spinner');
                               $.ajax({url: url,
                                       type: 'POST',
                                       data: {remark:remark},
                                       success: function(response){
                                            //console.log(response);
                                            element.removeClass('spinner');
                                            mess(response);
                                           
                                       }
                                       
                                });
                                if(type == 'timesPresent')
                                {
                                    updateAbsent(student_id,remark,element);
                                }
                            });
                          });
                        </script>";    
           $html.= "    </body>
                    </html>";                   
        return $html;       
    }


    /******REPORT CARD***/
    function gradePoint($total){
        if($total<40){
            return "F";
        }
        elseif ($total<50) {
            return "P";
        }
        elseif ($total<60) {
            return "C";
        }
        elseif ($total<70) {
            return "B";
        }
        else{
            return "A";
        }
    }

    function getMarks($subject_id){
        //$subject_id = $stdMarks['data']['subject_id'];
        //$examId = $stdMarks['examId'];
        //$subject_id=$this->db->where($where)->get('subject')->row()->subject_id;
        $this->db->where('classId',$this->class_id);
        $this->db->where('subjectId',$subject_id);
        $this->db->where('examId',$this->exam_id);
        $marks=$this->db->get('exam_marks')->result();
        return $marks;
    }

    function classAverage($subject_id){
        $marks=$this->getMarks($subject_id);
        $counter=count($marks);
        if($counter == 0 )
        {
            return 0;
        }
        $totalMarks=0;
        foreach ($marks as $mark) {
            $totalMarks+= $mark->examMark + $mark->attendanceMark;
            //$conter+=1;
        }
        $markAverage=$totalMarks;
        return round($markAverage / $counter,1);
    }

    function classHigh($subject_id){
        $marks=$this->getMarks($subject_id);
        $maxMark=0;
        foreach ($marks as $mark) {
            $tempMark=$mark->examMark + $mark->attendanceMark;
            if($tempMark > $maxMark)
                $maxMark=$tempMark;
        }
        return $maxMark;

    }

    function classLow($subject_id){
        $marks=$this->getMarks($subject_id);
        $minMark=111;
        foreach ($marks as $mark) {
           $tempMark=$mark->examMark + $mark->attendanceMark;
           if($minMark > $tempMark)
                $minMark=$tempMark;
        }
        return $minMark;
    }



    function position($total,$subject_id){
        //$sql = "SELECT DISTINCT mark_obtained+test_obtained as rank FROM mark WHERE class_id = ? AND subject_id = ? ORDER BY rank";
        //$where = array('class_id' =>$class ,'name'=>$subject );
        //$subject_id=$this->db->where($where)->get('subject')->row()->subject_id;
        $sql = "SELECT DISTINCT examMark+attendanceMark as rank FROM exam_marks WHERE classId = ? AND subjectId = ? AND examId = ? ORDER BY rank";
        $marks=$this->db->query($sql,array($this->class_id,$subject_id,$this->exam_id))->result();
            $position=0;
        foreach ($marks as $mark) {
            if ($mark->rank > $total)
                $position+=1;
        }
        $position++;
        $reminder = $position % 10;
        if($reminder == 1){
            if($position == 11){
                return $position.'th';
            }
            return $position.'st';
        }
        elseif ($reminder == 2) {
            if( $position == 12){
                return $position.'th';
            }
            return $position.'nd';
        }
         elseif ($reminder == 3) {
            if( $position == 13){
                return $position.'th';
            }
            return $position.'rd';
        }
        else{
            return $position.'th';   
        }
        
    }

    function getTerm(){
        $term = $this->db->get_where('exams_list',array('id'=>$this->exam_id))->row()->examTerm;
        if($term == 1)
        {
            $term = '1st';
        }
        elseif($term == 2)
        {
            $term = '2nd';
        }
        else
        {   
            $term = '3rd';
        }
        return $term;        
    }


    function marksheet($id){
       
        if($id == 0){
            $id = \Auth::user()->id;
        }
        $marks = array();
        $examIds = array();
        $examsList = exams_list::where('examAcYear',$this->panelInit->selectAcYear)->get();
        foreach ($examsList as $exam) {
            $marks[$exam->id] = array("title"=>$exam->examTitle,"examId"=>$exam->id,"studentId"=>$id);
            $examIds[] = $exam->id;
        }

        if(count($examIds) == 0){
            return $this->panelInit->apiOutput(false,$this->panelInit->language['Marksheet'],$this->panelInit->language['studentHaveNoMarks']);
            exit;
        }
        
        $examMarks = exam_marks::where('studentId',$id)->whereIn('examId',$examIds)->get();
        
        if(count($examMarks) == 0){
            return $this->panelInit->apiOutput(false,$this->panelInit->language['Marksheet'],$this->panelInit->language['studentHaveNoMarks']);
            exit;
        }
        $subject = subject::get();
        $gradeLevels = grade_levels::get();


        $examArray = array();
        foreach ($examsList as $exam) {
            $marks[$exam->id] = array("title"=>$exam->examTitle);
        }

        $subjectArray = array();
        foreach ($subject as $sub) {
            $subjectArray[$sub->id] = $sub->subjectTitle;
        }

        $gradeLevelsArray = array();
        foreach ($gradeLevels as $grade) {
            $gradeLevelsArray[$grade->gradeTitle] = array('from'=>$grade->gradeFrom,"to"=>$grade->gradeTo,"points"=>$grade->gradePoints);
        }

        foreach ($examMarks as $mark) {
            if(!isset($marks[$mark->examId]['counter'])){
                $marks[$mark->examId]['counter'] = 0;
                $marks[$mark->examId]['points'] = 0;
                $marks[$mark->examId]['totalMarks'] = 0;
            }
            $marks[$mark->examId]['counter'] ++;
            $marks[$mark->examId]['data'][$mark->id]['subject_name'] = $subjectArray[$mark->subjectId];
            $marks[$mark->examId]['data'][$mark->id]['subject_id'] = $mark->subjectId;
            $marks[$mark->examId]['data'][$mark->id]['test_obtained'] = $mark->attendanceMark;
            $marks[$mark->examId]['data'][$mark->id]['mark_obtained'] = $mark->examMark;
            $marks[$mark->examId]['data'][$mark->id]['comment'] = $mark->markComments;
            $marks[$mark->examId]['data'][$mark->id]['grade_point'] = $this->gradePoint($mark->attendanceMark + $mark->examMark);
            if($this->exam_id != 0 || $this->class_id != 0)
            {
                $marks[$mark->examId]['data'][$mark->id]['class_average'] = $this->classAverage($mark->subjectId);
                //$marks[$mark->examId]['data'][$mark->id]['position'] = $this->position($mark->attendanceMark + $mark->examMark,$mark->subjectId);
            }

            //$marks[$mark->id]['totalMarks'] += $mark->examMark + $mark->attendanceMark;
            $marks[$mark->examId]['totalMarks'] += $mark->examMark + $mark->attendanceMark;

            $marks[$mark->examId]['pointsAvg'] = round($marks[$mark->examId]['totalMarks'] / $marks[$mark->examId]['counter'],1).'%'; 
        }

        return $marks;
        exit;
    }


    /*getReportFooterSection HELPERS FUNCTIONS*/

    function getRemark($student_id,$remark_type){
        $remark = $this->db->get_where('students_extra_report',array('studentId'=>$student_id,'examId'=>$this->exam_id))->row();
        if(is_object($remark))
        {
            return $remark->{$remark_type};    
        }
        return '';
    }

    function getTimesSchoolOpen(){
       $time_open = $this->db->get_where('exams_list',array('id'=>$this->exam_id))->row()->timesSchoolOpen;
       if($time_open != 0)
       {
            return $time_open;
       }
        return '--';
    }

    function getPresent($student_id, $fromAbsent = false){
        $times_school_open = $this->getTimesSchoolOpen();
        if($times_school_open == '--')
        {
            return '--';
        }
        $times_present = $this->getRemark($student_id,'timesPresent');
        if($fromAbsent)
        {
            return compact('times_school_open','times_present');
        }
        return $times_present;
    }

    function getAbsent($student_id){
        $time_absent = 0;
        $times_p = $this->getPresent($student_id,true);
        if(is_array($times_p))
        {
            $time_absent = $times_p['times_school_open'] - $times_p['times_present'];
        }
        
        if($time_absent == 0)
        {
            return '--';
        }
        return $time_absent;
    }

    function getSchoolDate($date){
        $dateInUnix =  $this->db->get_where('exams_list',array('id'=>$this->exam_id))->row()->$date;
        return $this->panelInit->unixToDate($dateInUnix);
    }

    /*END getReportFooterSection HELPERS FUNCTIONS*/

    public function __get($key)
    {   
        $ci =& get_instance();

        return $ci->{$key};
    }


    public function logo()
    {
        return 'data:image/png;base64,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';
    }
}