<?php
class User_API_Role_Item_Delete {
  function __construct($item) {
    $this->item = $item;
  }

  function processRequest($request) {
    $statement = DB::getConnection()->prepare('DELETE FROM user_role WHERE id = ?');
    $statement->execute(array($this->item->id));
    $response = new stdClass();
    if ($statement->rowCount() == 1) {
      $response->status = 'success';
    } else {
      $response->status = 'failure';
      $response->id = $this->item->id;
    }
    echo json_encode($response);
  }
}
