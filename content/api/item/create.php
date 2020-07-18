<?php
class Content_API_Item_Create {
  function __construct() {}

  function processRequest($request) {
    $statement = DB::getConnection()->prepare("INSERT INTO content (title, `text`, showTitle) VALUES(?,?,?)");
    $showTitle = !empty($request['showTitle']) &&  $request['showTitle'] == 'on' ? 1 : 0;
    $statement->execute(array($request['title'], $request['text'], $showTitle));
    $response = new stdClass();
    if ($statement->rowCount() == 1) {
      $response->status = "success";
    } else {
      $response->status = "failure";
    }
    echo json_encode($response);
  }
}
