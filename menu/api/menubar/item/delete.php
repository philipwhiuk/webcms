<?php
class Menu_API_MenuBar_Item_Delete {
  function __construct($item) {
    $this->item = $item;
  }

  function processRequest($request) {
    $statement = DB::getConnection()->prepare('DELETE FROM menubar WHERE id = ?');
    $statement->execute(array($item->id));
    $response = new stdClass();
    if ($statement->rowCount() == 1) {
      $response->status = 'success';
    } else {
      $response->status = 'failure';
    }
    echo json_encode($response);
  }
}
