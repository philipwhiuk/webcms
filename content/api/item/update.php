<?php
class Content_API_Item_Update {
  function __construct($item) {
    $this->item = $item;
  }

  function processRequest($request) {
    $statement = DB::getConnection()->prepare("UPDATE content SET title = ? , text = ?, showTitle = ? where id = ?");
    $showTitle = !empty($request['showTitle']) &&  $request['showTitle'] == 'on' ? 1 : 0;
    $statement->execute(array($request['title'], $request['text'], $showTitle, $this->item->id));
    $response = new stdClass();
    if ($statement->rowCount() < 2) {
      $response->status = "success";
    } else {
      $response->status = "failure";
    }
    echo json_encode($response);
  }
}
