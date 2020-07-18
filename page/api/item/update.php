<?php
class Page_API_Item_Update {
  function __construct($item) {
    $this->item = $item;
  }

  function processRequest($request) {
    $statement = DB::getConnection()->prepare("UPDATE page SET title = ? , path = ?, module = ?, defaultAction = ? where id = ?");
    $statement->execute(array($request['title'], $request['path'], $request['module'], $request['defaultAction'], $this->item->id));
    $response = new stdClass();
    if ($statement->rowCount() < 2) {
      $response->status = "success";
    } else {
      $response->status = "failure";
    }
    echo json_encode($response);
  }
}
