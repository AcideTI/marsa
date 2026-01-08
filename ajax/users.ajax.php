<?php

require_once "../controller/users.controller.php";
require_once "../model/users.model.php";

class UsersAjax
{
  //  Show user data to edit
  public $codUser;
  public function ajaxEditUser()
  {
    $codUser = $this->codUser;
    $response = UsersController::ctrGetUserDataEdit($codUser);
    echo json_encode($response);
  }
}

//  Show user data to edit
if(isset($_POST["codUser"])){
	$edit = new UsersAjax();
	$edit -> codUser = $_POST["codUser"];
	$edit -> ajaxEditUser();
}