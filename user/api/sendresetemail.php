<?php
class User_API_SendResetEmail {
  function __construct() {}

  function processRequest($request) {
    $response = new stdClass();
    $user = User_User::getByUsername($request['username']);
    if ($user != null) {
      if ($user->email == $request['email']) {
        $resetCode = User_User::generateToken(16);
        $userUpdated = User_User::setResetPasswordToken($user->id, $resetCode, time()+3600);
        if ($userUpdated) {
          $to = $user->email;
          $subject = 'Password reset requested for '.Site::getTitle();
          $message = "Hi,\r\n".
            "\r\n".
            "Either you or someone else has requested a password to be reset on the account {$user->username} registered to this email address.\r\n".
            "\r\n".
            "If it was not you then you can safely delete and ignore this request.\r\n".
            "\r\n".
            "If it was you then please visit ".
            Site::getFullPageUrl(Page::forModule('user'), 'resetpassword')." and enter reset code: $resetCode to change your password.\r\n".
            "\r\n".
            "This password reset request will expire an hour after it was made.\r\n".
            "\r\n".
            "Best regards\r\n".
            "\r\n".
            "Webmaster\r\n".
            Site::getTitle()."\r\n";
          $headers = array(
            'From' => Site::getConfigProperty('email_from_address')
          );

          mail($to, $subject, $message, $headers);
        }
      }
    }
    $response->status = "success";
    echo json_encode($response);
  }
}
