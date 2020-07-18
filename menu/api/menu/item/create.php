<?php
class Menu_API_Menu_Item_Create {
  function __construct() {}

  function processRequest($request) {
    $statement = DB::getConnection()->prepare("INSERT INTO menu (title, menu_bar, menu_order) VALUES(?,?,?)");
    $statement->execute(array($request['title'],$request['menu_bar'],$request['menu_order']));
    $response = new stdClass();
    if ($statement->rowCount() == 1) {
      $response->status = "success";
    } else {
      $response->status = "failure";
    }
    echo json_encode($response);
  }
}
