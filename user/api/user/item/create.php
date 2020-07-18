<?php
class User_API_User_Item_Create {
  function __construct() {}

  function processRequest($request) {
    $statement = DB::getConnection()->prepare('INSERT INTO user (username, password_hash) VALUES(?,?)');
    $newPassword = md5(microtime()); //fairly-random initial password seeded from micro-seconds since epoch
    $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
    $statement->execute(array($request['username'], $newPassword));
    $response = new stdClass();
    if ($statement->rowCount() == 1) {
      $response->status = 'success';
    } else {
      $response->status = 'failure';
    }
    echo json_encode($response);
  }
}
