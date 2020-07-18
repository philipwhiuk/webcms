<?php
class News_API_Item_Create {
  function __construct() {}

  function processRequest($request) {
    $statement = DB::getConnection()->prepare("INSERT INTO news (title, intro, body, publish_dates) VALUES(?,?,?, ?)");
    $statement->execute(array($request['title'], $request['intro'], $request['body'],
      DateUtils::dateTimeToEpochTime($request['publish_date']));
    $response = new stdClass();
    if ($statement->rowCount() == 1) {
      $response->status = "success";
    } else {
      $response->status = "failure";
    }
    echo json_encode($response);
  }
}
