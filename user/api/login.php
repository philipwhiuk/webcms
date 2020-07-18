<?php
class User_API_Login {
  function __construct() {}

  function processRequest($request) {
    $response = new stdClass();
    $user = User_User::getUserWithHashByUsername($request['username']);
    if ($user != null) {
      $success = password_verify($request['password'], $user->password_hash);
      if ($success) {
        $_SESSION['user_username'] = $user->username;
        $response->status = "success";
      } else {
        $response->status = "failure";
      }
      User_LoginAttempt::add($user->id, time(), $success);
    } else {
      $response->status = "failure";
    }
    echo json_encode($response);
  }
}
