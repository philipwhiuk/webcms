<?php
class Menu_API_Menu_Item_Update {
  function __construct($item) {
    $this->item = $item;
  }

  function processRequest($request) {
    $statement = DB::getConnection()->prepare('UPDATE menu SET title = ?, menu_bar = ?, menu_order = ? WHERE id = ?');
    $statement->execute(array($request['title'], $request['menu_bar'], $request['menu_order'], $this->item->id));
    $response = new stdClass();
    if ($statement->rowCount() < 2) {
      $response->status = 'success';
    } else {
      $response->status = 'failure';
    }
    echo json_encode($response);
  }
}
