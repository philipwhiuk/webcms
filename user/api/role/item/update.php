<?php
class User_API_Role_Item_Update {
  function __construct($item) {
    $this->item = $item;
  }

  function processRequest($request) {
    $statement = DB::getConnection()->prepare('UPDATE user_role SET name = ?, description = ? where id = ?');
    $statement->execute(array($request['name'], $request['description'], $this->item->id));
    $response = new stdClass();
    if ($statement->rowCount() < 2) {
      $response->status = 'success';
    } else {
      $response->status = 'failure';
    }
    echo json_encode($response);
  }
}
