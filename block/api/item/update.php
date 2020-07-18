<?php
class Block_API_Item_Update {
  function __construct($item) {
    $this->item = $item;
  }

  function processRequest($request) {
    $statement = DB::getConnection()->prepare("UPDATE block SET module = ? , action = ?, location = ?, visibility = ?, title = ? where id = ?");
    $statement->execute(array($request['module'], $request['action'],
      $request['location'], $request['visibility'], $request['title'], $request['id']));
    $response = new stdClass();
    if ($statement->rowCount() < 2) {
      $response->status = "success";
    } else {
      $response->status = "failure";
    }
    echo json_encode($response);
  }
}
