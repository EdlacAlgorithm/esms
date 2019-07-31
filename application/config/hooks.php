<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/

$hook['post_controller_constructor '] = function()
{
    $checkMethod = ['logout','forgetpwd','forgetpwdStepOne','forgetpwdStepTwo','register','registerPost'];
};

// $hook['pre_system'] = function() {
//     $dotenv = new Dotenv\Dotenv(FCPATH);
//     $dotenv->load();
// };