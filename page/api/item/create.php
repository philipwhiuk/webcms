<?php
class Page_API_Item_Create {
  function __construct() {}

  function processRequest($request) {
    $statement = DB::getConnection()->prepare("INSERT INTO page (title, path, module, defaultAction) VALUES(?,?,?,?)");
    $statement->execute(array($request['title'], $request['path'], $request['module'], $request['defaultAction']));
    $response = new stdClass();
    if ($statement->rowCount() == 1) {
      $response->status = "success";
    } else {
      $response->status = "failure";
    }
    echo json_encode($response);
  }
}
