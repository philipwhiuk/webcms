<?php
class User_API_Role_Item_Create {
  function __construct() {}

  function processRequest($request) {
    $statement = DB::getConnection()->prepare('INSERT INTO user_role (name, description) VALUES(?,?)');
    $statement->execute(array($request['name'], $request['description']));
    $response = new stdClass();
    if ($statement->rowCount() == 1) {
      $response->status = 'success';
    } else {
      $response->status = 'failure';
    }
    echo json_encode($response);
  }
}
