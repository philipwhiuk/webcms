<?php
class User_API_ResetPassword {
  function __construct() {}

  function processRequest($request) {
    $response = new stdClass();
    $response->status = "failure";
    $user = User_User::getByUsername($request['username']);
    if ($user != null) {
      if ($user->reset_password_token == $request['resetToken'] && $user->reset_password_expiry < time()) {
        if ($request['password'] == $request['confirm_password']) {
          $newPasswordHash = password_hash($request['password'], PASSWORD_DEFAULT);
          $userUpdated = User_User::updatePassword($user->id, $newPasswordHash);
          if ($userUpdated) {
            $response->status = "success";
          }
        }
      }
    }
    echo json_encode($response);
  }
}
