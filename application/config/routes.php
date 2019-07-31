<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details: 
|
|	https://codeigniter.com/user_guide/general/routing.html 
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| ------------------------------------------------------------------------- 
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['test/pdf']['get'] = 'StudentsController/marksheetBulkPDF';
$route['default_controller'] = 'DashboardController';
//$route['default_controller'] = 'LoginController';
$route['404_override'] = ''; 
$route['translate_uri_dashes'] = FALSE;
//CSRF TOKEN
$route['api/csrf']['get'] = 'Views/token';
$route['templates/(:any)'] = 'Views/template/$1';

$route['login']['get'] = 'LoginController/index';
$route['login']['post'] = 'LoginController/attemp';
$route['logout']['get'] = 'LoginController/logout';

$route['forgetpwd']['get'] = 'LoginController/forgetpwd';
$route['forgetpwd']['post'] = 'LoginController/forgetpwdStepOne';
$route['forgetpwd/(:any)']['get'] = 'LoginController/forgetpwdStepTwo/$1';
$route['forgetpwd/(:any)']['post'] = 'LoginController/forgetpwdStepTwo/$1';

$route['register/classes']['get'] = 'LoginController/registerClasses';
$route['register/searchStudents/(:any)']['get'] = 'LoginController/searchStudents/$1';
$route['register/sectionsList']['post'] = 'LoginController/sectionsList';
$route['register/searchUsers/(:any)/(:any)']['get'] = 'LoginController/searchUsers/$1/$2';
$route['register']['get'] = 'LoginController/register';
$route['register']['post'] = 'LoginController/registerPost';

$route['terms']['get'] = 'LoginController/terms';


// Dashboard
//$route['/']['get'] = 'DashboardController/index';
$route['dashboard']['get'] = 'DashboardController/dashboardData';
$route['dashboard/baseUser']['get'] = 'DashboardController/baseUser';
$route['calender']['get'] = 'DashboardController/calender';
$route['dashboard/polls']['post'] = 'DashboardController/savePolls';
$route['uploads/(:any)/(:any)']['get'] = 'DashboardController/image/$1/$2';
$route['dashboard/changeAcYear']['post'] = 'DashboardController/changeAcYear';
$route['dashboard/classesList']['post'] = 'DashboardController/classesList';
$route['dashboard/subjectList']['post'] = 'DashboardController/subjectList';
$route['dashboard/sectionsSubjectsList']['post'] = 'DashboardController/sectionsSubjectsList';
$route['dashboard/profileImage/(:num)']['get'] = 'DashboardController/profileImage/$1';
$route['dashboard/mobnotif']['get'] = 'DashboardController/mobNotif';
$route['dashboard/mobnotif/(:num)']['get'] = 'DashboardController/mobNotif/$1';
$route['dashaboard']['post'] = 'DashboardController/dashaboardData';


//Languages & phrases
$route['languages']['get'] = 'DashboardController/index';
$route['languages/listAll']['get'] = 'LanguagesController/listAll';
$route['languages']['post'] = 'LanguagesController/create';
$route['languages/(:num)']['get'] = 'LanguagesController/fetch/$1';
$route['languages/delete/(:num)']['post'] = 'LanguagesController/delete/$1';
$route['languages/(:num)']['post'] = 'LanguagesController/edit/$1';


//Dormitories
$route['dormitories']['get'] = 'DashboardController/index';
$route['dormitories/listAll']['get'] = 'DormitoriesController/listAll';
$route['dormitories']['post'] = 'DormitoriesController/create';
$route['dormitories/(:num)']['get'] = 'DormitoriesController/fetch/$1';
$route['dormitories/delete/(:num)']['post'] = 'DormitoriesController/delete/$1';
$route['dormitories/(:num)']['post'] = 'DormitoriesController/edit/$1';


//Admins
$route['admins']['get'] = 'DashboardController/index';
$route['admins/listAll']['get'] = 'AdminsController/listAll';
$route['admins']['post'] = 'AdminsController/create';
$route['admins/(:num)']['get'] = 'AdminsController/fetch/$1';
$route['admins/delete/(:num)']['post'] = 'AdminsController/delete/$1';
$route['admins/(:num)']['post'] = 'AdminsController/edit/$1';


//Teachers
$route['teachers']['get'] = 'DashboardController/index';
$route['teachers/import/(:any)']['post'] = 'TeachersController/import/$1';
$route['teachers/reviewImport']['post'] = 'TeachersController/reviewImport';
$route['teachers/export']['get'] = 'TeachersController/export';
$route['teachers/exportpdf']['get'] = 'TeachersController/exportpdf';
$route['teachers/upload']['post'] = 'TeachersController/uploadFile';
$route['teachers/waitingApproval']['get'] = 'TeachersController/waitingApproval';
$route['teachers/leaderBoard/(:num)']['post'] = 'TeachersController/leaderboard/$1';
$route['teachers/approveOne/(:num)']['post'] = 'TeachersController/approveOne/$1';
$route['teachers/profile/(:num)']['get'] = 'TeachersController/profile/$1';
$route['teachers/listAll']['get'] = 'TeachersController/listAll';
$route['teachers/listAll/(:any)']['get'] = 'TeachersController/listAll/$1';
$route['teachers/search/(:any)/(:any)']['get'] = 'TeachersController/search/$1/$2';
$route['teachers']['post'] = 'TeachersController/create';
$route['teachers/(:num)']['get'] = 'TeachersController/fetch/$1';
$route['teachers/leaderBoard/delete/(:num)']['post'] = 'TeachersController/leaderboardRemove/$1';
$route['teachers/delete/(:num)']['post'] = 'TeachersController/delete/$1';
$route['teachers/(:num)']['post'] = 'TeachersController/edit/$1'; 


//Students
$route['students']['get'] = 'DashboardController/index';
$route['students/import/(:any)']['post'] = 'StudentsController/import/$1';
$route['students/reviewImport']['post'] = 'StudentsController/reviewImport';
$route['students/export']['get'] = 'StudentsController/export';
$route['students/exportpdf']['get'] = 'StudentsController/exportpdf';
$route['students/upload']['post'] = 'StudentsController/uploadFile';
$route['students/waitingApproval']['get'] = 'StudentsController/waitingApproval';
$route['students/approveOne/(:num)']['post'] = 'StudentsController/approveOne/$1';
$route['students/print/marksheet/(:any)/(:any)']['get'] = 'StudentsController/marksheetPDF/$1/$2';
$route['students/marksheet/(:num)']['get'] = 'StudentsController/marksheet/$1';
$route['students/attendance/(:num)']['get'] = 'StudentsController/attendance/$1';
$route['students/profile/(:num)']['get'] = 'StudentsController/profile/$1';
$route['students/leaderBoard/(:num)']['post'] = 'StudentsController/leaderboard/$1';
$route['students/listAll']['get'] = 'StudentsController/listAll';
$route['students/listAll/(:any)']['get'] = 'StudentsController/listAll/$1';
$route['students/search/(:any)/(:any)']['get'] = 'StudentsController/search/$1/$2';
$route['students']['post'] = 'StudentsController/create';
$route['students/(:num)']['get'] = 'StudentsController/fetch/$1';
$route['students/printbulk/marksheet']['post'] = 'StudentsController/marksheetBulk';
$route['students/printbulk/pdf']['post'] = 'StudentsController/marksheetBulkPDF';
$route['students/leaderBoard/delete/(:num)']['post'] = 'StudentsController/leaderboardRemove/$1';
$route['students/acYear/delete/(:any)(:num)']['post'] = 'StudentsController/acYearRemove/$1/$2';
$route['students/delete/(:num)']['post'] = 'StudentsController/delete/$1';
$route['students/(:num)']['post'] = 'StudentsController/edit/$1';
$route['students/saveRemark/(:num)/(:any)/(:num)']['post'] = 'StudentsController/saveRemarkAjax/$1/$2/$3';


//Parents
$route['parents/search/(:any)']['get'] = 'ParentsController/searchStudents/$1';
$route['parents/import/(:any)']['post'] = 'ParentsController/import/$1';
$route['parents/reviewImport']['post'] = 'ParentsController/reviewImport';
$route['parents/export']['get'] = 'ParentsController/export';
$route['parents/exportpdf']['get'] = 'ParentsController/exportpdf';
$route['parents']['get'] = 'DashboardController/index';
$route['parents/upload']['post'] = 'ParentsController/uploadFile';
$route['parents/waitingApproval']['get'] = 'ParentsController/waitingApproval';
$route['parents/profile/(:num)']['get'] = 'ParentsController/profile/$1';
$route['parents/approveOne/(:num)']['post'] = 'ParentsController/approveOne/$1';
$route['parents/listAll']['get'] = 'ParentsController/listAll';
$route['parents/listAll/(:any)']['get'] = 'ParentsController/listAll/$1';
$route['parents/search/(:any)/(:any)']['get'] = 'ParentsController/search/$1/$2';
$route['parents']['post'] = 'ParentsController/create';
$route['parents/(:num)']['get'] = 'ParentsController/fetch/$1';
$route['parents/delete/(:num)']['post'] = 'ParentsController/delete/$1';
$route['parents/(:num)']['post'] = 'ParentsController/edit/$1';


//Classes
$route['classes']['get'] = 'DashboardController/index';
$route['classes/listAll']['get'] = 'ClassesController/listAll';
$route['classes']['post'] = 'ClassesController/create';
$route['classes/(:num)']['get'] = 'ClassesController/fetch/$1';
$route['classes/delete/(:num)']['post'] = 'ClassesController/delete/$1';
$route['classes/(:num)']['post'] = 'ClassesController/edit/$1';


//Sections
$route['sections']['get'] = 'DashboardController/index';
$route['sections/listAll']['get'] = 'sectionsController/listAll';
$route['sections']['post'] = 'sectionsController/create';
$route['sections/(:num)']['get'] = 'sectionsController/fetch/$1';
$route['sections/delete/(:num)']['post'] = 'sectionsController/delete/$1';
$route['sections/(:num)']['post'] = 'sectionsController/edit/$1';


//subjects
$route['subjects']['get'] = 'DashboardController/index';
$route['subjects/listAll']['get'] = 'SubjectsController/listAll';
$route['subjects']['post'] = 'SubjectsController/create';
$route['subjects/(:num)']['get'] = 'SubjectsController/fetch/$1';
$route['subjects/delete/(:num)']['post'] = 'SubjectsController/delete/$1';
$route['subjects/(:num)']['post'] = 'SubjectsController/edit/$1';


//NewsBoardass
$route['newsboard']['get'] = 'DashboardController/index';
$route['newsboard/listAll/(:any)']['get'] = 'NewsBoardController/listAll/$1';
$route['newsboard/search/(:any)/(:any)']['get'] = 'NewsBoardController/search/$1/$2';
$route['newsboard']['post'] = 'NewsBoardController/create';
$route['newsboard/(:num)']['get'] = 'NewsBoardController/fetch/$1';
$route['newsboard/delete/(:num)']['post'] = 'NewsBoardController/delete/$1';
$route['newsboard/(:num)']['post'] = 'NewsBoardController/edit/$1';


//Library
$route['library']['get'] = 'DashboardController/index';
$route['library/listAll']['get'] = 'LibraryController/listAll';
$route['library/listAll/(:any)']['get'] = 'LibraryController/listAll/$1';
$route['library/download/(:num)']['get'] = 'LibraryController/download/$1';
$route['library/search/(:any)/(:any)']['get'] = 'LibraryController/search/$1/$2';
$route['library']['post'] = 'LibraryController/create';
$route['library/(:num)']['get'] = 'LibraryController/fetch/$1';
$route['library/delete/(:num)']['post'] = 'LibraryController/delete/$1';
$route['library/(:num)']['post'] = 'LibraryController/edit/$1';


//Account Settings
$route['accountSettings']['get'] = 'DashboardController/index';
$route['accountSettings/langs']['get'] = 'AccountSettingsController/langs';
$route['accountSettings/data']['get'] = 'AccountSettingsController/listAll';
$route['accountSettings/profile']['post'] = 'AccountSettingsController/saveProfile';
$route['accountSettings/email']['post'] = 'AccountSettingsController/saveEmail';
$route['accountSettings/password']['post'] = 'AccountSettingsController/savePassword';


//Class Schedule
$route['classschedule']['get'] = 'DashboardController/index';
$route['classschedule/listAll']['get'] = 'ClassScheduleController/listAll';
$route['classschedule/(:num)']['get'] = 'ClassScheduleController/fetch/$1';
$route['classschedule/sub/(:num)']['get'] = 'ClassScheduleController/fetchSub/$1';
$route['classschedule/sub/(:num)']['post'] = 'ClassScheduleController/editSub/$1';
$route['classschedule/delete/(:any)(:num)']['post'] = 'ClassScheduleController/delete/$1/$2';
$route['classschedule/(:num)']['post'] = 'ClassScheduleController/addSub/$1';


//Site Settings
$route['settings']['get'] = 'DashboardController/index';
$route['siteSettings/langs']['get'] = 'SiteSettingsController/langs';
$route['siteSettings/(:any)']['get'] = 'SiteSettingsController/listAll/$1';
$route['siteSettings/(:any)']['post'] = 'SiteSettingsController/save/$1';


//Attendance
$route['attendance']['get'] = 'DashboardController/index';
$route['attendance/data']['get'] = 'AttendanceController/listAll';
$route['attendance/list']['post'] = 'AttendanceController/listAttendance';
$route['attendance']['post'] = 'AttendanceController/saveAttendance';
$route['attendance/stats']['get'] = 'AttendanceController/getStats';
$route['attendance/stats/(:any)']['get'] = 'AttendanceController/getStats/$1';
$route['attendance/stats']['post'] = 'AttendanceController/search';


//Grade Levels
$route['gradeLevels']['get'] = 'DashboardController/index';
$route['gradeLevels/listAll']['get'] = 'GradeLevelsController/listAll';
$route['gradeLevels']['post'] = 'GradeLevelsController/create';
$route['gradeLevels/(:num)']['get'] = 'GradeLevelsController/fetch/$1';
$route['gradeLevels/delete/(:num)']['post'] = 'GradeLevelsController/delete/$1';
$route['gradeLevels/(:num)']['post'] = 'GradeLevelsController/edit/$1';


//Exams List
$route['examsList']['get'] = 'DashboardController/index';
$route['examsList/listAll']['get'] = 'ExamsListController/listAll';
$route['examsList/notify/(:num)']['post'] = 'ExamsListController/notifications/$1';
$route['examsList']['post'] = 'ExamsListController/create';
$route['examsList/(:num)']['get'] = 'ExamsListController/fetch/$1';
$route['examsList/getMarks']['post'] = 'ExamsListController/fetchMarks';
$route['examsList/(:num)']['post'] = 'ExamsListController/edit/$1';
$route['examsList/delete/(:num)']['post'] = 'ExamsListController/delete/$1';
$route['examsList/saveMarks/(:any)/(:any)/(:any)']['post'] = 'ExamsListController/saveMarks/$1/$2/$3';


//Events
$route['events']['get'] = 'DashboardController/index';
$route['events/listAll']['get'] = 'EventsController/listAll';
$route['events']['post'] = 'EventsController/create';
$route['events/(:num)']['get'] = 'EventsController/fetch/$1';
$route['events/delete/(:num)']['post'] = 'EventsController/delete/$1';
$route['events/(:num)']['post'] = 'EventsController/edit/$1';


//Assignments
$route['assignments']['get'] = 'DashboardController/index';
$route['assignments/listAll']['get'] = 'AssignmentsController/listAll';
$route['assignments/listAnswers/(:num)']['get'] = 'AssignmentsController/listAnswers/$1';
$route['assignments']['post'] = 'AssignmentsController/create';
$route['assignments/download/(:num)']['get'] = 'AssignmentsController/download/$1';
$route['assignments/downloadAnswer/(:num)']['get'] = 'AssignmentsController/downloadAnswer/$1';
$route['assignments/(:num)']['get'] = 'AssignmentsController/fetch/$1';
$route['assignments/checkUpload']['post'] = 'AssignmentsController/checkUpload';
$route['assignments/delete/(:num)']['post'] = 'AssignmentsController/delete/$1';
$route['assignments/upload/(:num)']['post'] = 'AssignmentsController/upload/$1';
$route['assignments/(:num)']['post'] = 'AssignmentsController/edit/$1';


//Study Material
$route['materials']['get'] = 'DashboardController/index';
$route['materials/listAll']['get'] = 'StudyMaterialController/listAll';
$route['materials']['post'] = 'StudyMaterialController/create';
$route['materials/download/(:num)']['get'] = 'StudyMaterialController/download/$1';
$route['materials/(:num)']['get'] = 'StudyMaterialController/fetch/$1';
$route['materials/delete/(:num)']['post'] = 'StudyMaterialController/delete/$1';
$route['materials/(:num)']['post'] = 'StudyMaterialController/edit/$1';


//Mail / SMS
$route['mailsms']['get'] = 'DashboardController/index';
$route['mailsms/listAll']['get'] = 'MailSmsController/listAll';
$route['mailsms']['post'] = 'MailSmsController/create';
$route['mailsms/settings']['get'] = 'MailSmsController/settings';
$route['mailsms/settings']['post'] = 'MailSmsController/settingsSave';


//Mobile Notifications
$route['mobileNotif']['get'] = 'DashboardController/index';
$route['mobileNotif/listAll']['get'] = 'mobileNotifController/listAll';
$route['mobileNotif']['post'] = 'mobileNotifController/create';
$route['mobileNotif/delete/(:num)']['post'] = 'mobileNotifController/delete/$1';

//Messages
$route['messages']['get'] = 'DashboardController/index';
$route['messages']['post'] = 'MessagesController/create';
$route['messages/listAll/(:any)']['get'] = 'MessagesController/listMessages/$1';
$route['messages/searchUser/(:any)']['get'] = 'MessagesController/searchUser/$1';
$route['messages/read']['post'] = 'MessagesController/read';
$route['messages/unread']['post'] = 'MessagesController/unread';
$route['messages/delete']['post'] = 'MessagesController/delete';
$route['messages/(:num)']['get'] = 'MessagesController/fetch/$1';
$route['messages/(:num)']['post'] = 'MessagesController/reply/$1';
$route['messages/ajax/(:any)/(:any)/(:any)']['get'] = 'MessagesController/ajax/$1/$2/$3';
$route['messages/before/(:any)/(:any)/(:any)']['get'] = 'MessagesController/before/$1/$2/$3';


//Online Exams
$route['onlineExams']['get'] = 'DashboardController/index';
$route['onlineExams/listAll']['get'] = 'OnlineExamsController/listAll';
$route['onlineExams/take/(:num)']['post'] = 'OnlineExamsController/take/$1';
$route['onlineExams/took/(:num)']['post'] = 'OnlineExamsController/took/$1';
$route['onlineExams/marks/(:num)']['get'] = 'OnlineExamsController/marks/$1';
$route['onlineExams/export/(:num)(:any)']['get'] = 'OnlineExamsController/export/$1/$2';
$route['onlineExams']['post'] = 'OnlineExamsController/create';
$route['onlineExams/(:num)']['get'] = 'OnlineExamsController/fetch/$1';
$route['onlineExams/delete/(:num)']['post'] = 'OnlineExamsController/delete/$1';
$route['onlineExams/(:num)']['post'] = 'OnlineExamsController/edit/$1';


//Transportation
$route['transports']['get'] = 'DashboardController/index';
$route['transports/listAll']['get'] = 'TransportsController/listAll';
$route['transports/list/(:num)']['get'] = 'TransportsController/fetchSubs/$1';
$route['transports']['post'] = 'TransportsController/create';
$route['transports/(:num)']['get'] = 'TransportsController/fetch/$1';
$route['transports/delete/(:num)']['post'] = 'TransportsController/delete/$1';
$route['transports/(:num)']['post'] = 'TransportsController/edit/$1';


//Media
$route['media']['get'] = 'DashboardController/index';
$route['media/listAll']['get'] = 'MediaController/listAlbum';
$route['media/listAll/(:num)']['get'] = 'MediaController/listAlbumById/$1';
$route['media/resize/(:any)/(:any)/(:any)']['get'] = 'MediaController/resize/$1/$2/$3';
$route['media/image/(:num)']['get'] = 'MediaController/image/$1';
$route['media/newAlbum']['post'] = 'MediaController/newAlbum';
$route['media/editAlbum/(:num)']['get'] = 'MediaController/fetchAlbum/$1';
$route['media/editAlbum/(:num)']['post'] = 'MediaController/editAlbum/$1';
$route['media']['post'] = 'MediaController/create';
$route['media/(:num)']['get'] = 'MediaController/fetch/$1';
$route['media/album/delete/(:num)']['post'] = 'MediaController/deleteAlbum/$1';
$route['media/delete/(:num)']['post'] = 'MediaController/delete/$1';
$route['media/(:num)']['post'] = 'MediaController/edit/$1';


//Static pages
$route['static']['get'] = 'DashboardController/index';
$route['static/listAll']['get'] = 'StaticPagesController/listAll';
$route['static/listUser']['get'] = 'StaticPagesController/listUser';
$route['static/active/(:num)']['get'] = 'StaticPagesController/active/$1';
$route['static']['post'] = 'StaticPagesController/create';
$route['static/(:num)']['get'] = 'StaticPagesController/fetch/$1';
$route['static/delete/(:num)']['post'] = 'StaticPagesController/delete/$1';
$route['static/(:num)']['post'] = 'StaticPagesController/edit/$1';


//Polls
$route['polls']['get'] = 'DashboardController/index';
$route['polls/listAll']['get'] = 'PollsController/listAll';
$route['polls/active/(:num)']['post'] = 'PollsController/makeActive/$1';
$route['polls']['post'] = 'PollsController/create';
$route['polls/(:num)']['get'] = 'PollsController/fetch/$1';
$route['polls/delete/(:num)']['post'] = 'PollsController/delete/$1';
$route['polls/(:num)']['post'] = 'PollsController/edit/$1';


//Mail / SMS Templates
$route['mailsmsTemplates']['get'] = 'DashboardController/index';
$route['MailSMSTemplates/listAll']['get'] = 'MailSMSTemplatesController/listAll';
$route['MailSMSTemplates/(:num)']['get'] = 'MailSMSTemplatesController/fetch/$1';
$route['MailSMSTemplates/(:num)']['post'] = 'MailSMSTemplatesController/edit/$1';


//Fee Types
$route['feeTypes']['get'] = 'DashboardController/index';
$route['feeTypes/listAll']['get'] = 'feeTypesController/listAll';
$route['feeTypes']['post'] = 'feeTypesController/create';
$route['feeTypes/(:num)']['get'] = 'feeTypesController/fetch/$1';
$route['feeTypes/delete/(:num)']['post'] = 'feeTypesController/delete/$1';
$route['feeTypes/(:num)']['post'] = 'feeTypesController/edit/$1';


//Fee Allocation
$route['feeAllocation']['get'] = 'DashboardController/index';
$route['feeAllocation/listAll']['get'] = 'feeAllocationController/listAll';
$route['feeAllocation']['post'] = 'feeAllocationController/create';
$route['feeAllocation/(:num)']['get'] = 'feeAllocationController/fetch/$1';
$route['feeAllocation/delete/(:num)']['post'] = 'feeAllocationController/delete/$1';
$route['feeAllocation/(:num)']['post'] = 'feeAllocationController/edit/$1';


//Payments
$route['payments']['get'] = 'DashboardController/index';
$route['payments/listAll']['get'] = 'PaymentsController/listAll';
$route['payments/listAll/(:any)']['get'] = 'PaymentsController/listAll/$1';
$route['payments/searchUsers/(:any)']['get'] = 'PaymentsController/searchStudents/$1';
$route['payments/search/(:any)/(:any)']['get'] = 'PaymentsController/search/$1/$2';
$route['payments/failed']['get'] = 'PaymentsController/paymentFailed';
$route['payments/invoice/(:num)']['get'] = 'PaymentsController/invoice/$1';
$route['payments/export/(:num)']['get'] = 'PaymentsController/export/$1';
$route['payments/details/(:num)']['get'] = 'PaymentsController/PaymentData/$1';
$route['payments']['post'] = 'PaymentsController/create';
$route['payments/(:num)']['get'] = 'PaymentsController/fetch/$1';
$route['payments/delete/(:num)']['post'] = 'PaymentsController/delete/$1';
$route['payments/(:num)']['post'] = 'PaymentsController/edit/$1';


//Expenses
$route['expenses']['get'] = 'expensesController/index';
$route['expenses/listAll']['get'] = 'expensesController/listAll';
$route['expenses']['post'] = 'expensesController/create';
$route['expenses/(:num)']['get'] = 'expensesController/fetch/$1';
$route['expenses/delete/(:num)']['post'] = 'expensesController/delete/$1';
$route['expenses/(:num)']['post'] = 'expensesController/edit/$1';


//Promotion
$route['promotion']['get'] = 'DashboardController/index';
$route['promotion/search/(:any)']['get'] = 'promotionController/searchStudents/$1';
$route['promotion/listData']['get'] = 'promotionController/listAll';
$route['promotion/listStudents']['post'] = 'promotionController/listStudents';
$route['promotion']['post'] = 'promotionController/promoteNow';


//Academic Year
$route['academicYear']['get'] = 'DashboardController/index';
$route['academic/listAll']['get'] = 'academicYearController/listAll';
$route['academic/active/(:num)']['post'] = 'academicYearController/active/$1';
$route['academic']['post'] = 'academicYearController/create';
$route['academic/(:num)']['get'] = 'academicYearController/fetch/$1';
$route['academic/delete/(:num)']['post'] = 'academicYearController/delete/$1';
$route['academic/(:num)']['post'] = 'academicYearController/edit/$1';


//Staff Attendance
$route['staffAttendance']['get'] = 'DashboardController/index';
$route['sattendance/list']['post'] = 'SAttendanceController/listAttendance';
$route['sattendance']['post'] = 'SAttendanceController/saveAttendance';
$route['sattendance/stats']['get'] = 'SAttendanceController/getStats';
$route['sattendance/stats/(:any)']['get'] = 'SAttendanceController/getStats/$1';
$route['sattendance/stats']['post'] = 'SAttendanceController/search';


//Reports
$route['reports']['get'] = 'DashboardController/index';
$route['reports']['post'] = 'reportsController/report'; 
$route['reports/preAttendace']['get'] = 'reportsController/preAttendaceStats';


//vacation
$route['vacation']['get'] = 'vacationController/index';
$route['vacation']['post'] = 'vacationController/getVacation';
$route['vacation']['post'] = 'vacationController/getVacation';
$route['vacation/confirm']['post'] = 'vacationController/saveVacation';
$route['vacation/delete/(:num)']['post'] = 'vacationController/delete/$1';


 //Hostel
$route['hostel']['get'] = 'DashboardController/index';
$route['hostel/listAll']['get'] = 'hostelController/listAll';
$route['hostel/listSubs/(:num)']['get'] = 'hostelController/listSubs/$1';
$route['hostel']['post'] = 'hostelController/create';
$route['hostel/(:num)']['get'] = 'hostelController/fetch/$1';
$route['hostel/delete/(:num)']['post'] = 'hostelController/delete/$1';
$route['hostel/(:num)']['post'] = 'hostelController/edit/$1';


//HostelCat
$route['hostelCat']['get'] = 'DashboardController/index';
$route['hostelCat/listAll']['get'] = 'hostelCatController/listAll';
$route['hostelCat']['post'] = 'hostelCatController/create';
$route['hostelCat/(:num)']['get'] = 'hostelCatController/fetch/$1';
$route['hostelCat/delete/(:num)']['post'] = 'hostelCatController/delete/$1';
$route['hostelCat/(:num)']['post'] = 'hostelCatController/edit/$1';

$route['payments/success/(:num)']['post'] = 'PaymentsController/paymentSuccess/$1';