<?php
class Menu_API_MenuBar_Item_Update {
  function __construct($item) {
    $this->item = $item;
  }

  function processRequest($request) {
    $statement = DB::getConnection()->prepare('UPDATE menubar SET title = ? WHERE id = ?');
    $statement->execute(array($request['title'], $this->item->id));
    $response = new stdClass();
    if ($statement->rowCount() < 2) {
      $response->status = 'success';
    } else {
      $response->status = 'failure';
    }
    echo json_encode($response);
  }
}
