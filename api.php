<?php
//API entry point
define('CMS',true);
define('CMS_API',true);
define('CMS_DEBUG',true);
//TODO: Move this somewhere else, support cookies and URL alternative
session_start();
require_once 'autoload.php';
try {
  Site::load();
  $module = Site::getModuleForRequest();
  $handler = $module::getRequestHandler(Site::getApiRequest());
  if ($handler === null) {
    throw new Exception("API_UNHANDLED_REQUEST");
  }
  $handler->processRequest($_REQUEST);
} catch (Exception $e) {
  header('Content-Type: application/json');
  http_response_code(400);
  $response = new stdClass();
  if (CMS_DEBUG) {
    $response->cause = $e->getMessage();
    $response->trace = $e->getTraceAsString();
  }
  echo json_encode($response);
}
