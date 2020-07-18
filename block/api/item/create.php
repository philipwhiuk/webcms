<?php
class Block_API_Item_Create {
  function __construct() {}

  function processRequest($request) {
    $statement = DB::getConnection()->prepare("INSERT INTO block (module, action, location, visibility, title)
      VALUES(?,?,?,?,?)");
    $statement->execute(array($request['module'], $request['action'],
      $request['location'], $request['visibility'], $request['title']));
    $response = new stdClass();
    if ($statement->rowCount() == 1) {
      $response->status = "success";
    } else {
      $response->status = "failure";
    }
    echo json_encode($response);
  }
}
