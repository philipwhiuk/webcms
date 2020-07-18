<?php
class News_API_Item_Update {
  function __construct($item) {
    $this->item = $item;
  }

  function processRequest($request) {
    $statement = DB::getConnection()->prepare("UPDATE news SET title = ? , intro = ?, body = ?, publish_date = ? where id = ?");
    $statement->execute(array($request['title'], $request['intro'], $request['body'],
      DateUtils::dateTimeToEpochTime($request['publish_date']), $this->item->id));
    $response = new stdClass();
    if ($statement->rowCount() < 2) {
      $response->status = "success";
    } else {
      $response->status = "failure";
    }
    echo json_encode($response);
  }
}
