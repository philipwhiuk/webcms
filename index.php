<?php
define('CMS',true);
define('CMS_DEBUG',true);
//TODO: Move this somewhere else, support cookies and URL alternative
session_start();
require_once 'autoload.php';

function showRequestedPage($page, $user) {
  $pageRequest = $page->resolveRequest(Site::getPageRequest());
  $options = $page->getPermissionOptions($pageRequest);
  if (Site::userHasPermission($user, $options)) {
    $page->loadAs($pageRequest);
    $page->render(Site::getTheme())->display();
  } else {
    try {
      $page->loadAsDefault();
      $page->render(Site::getTheme())->display();
    } catch (BadRouteException $e) {
      showAccessDeniedPage($user);
    }
  }
}
function showAccessDeniedPage($user) {
  $page = Site::getPageAccessDeniedPage();
  if (Site::userHasPermission($user, array('*',$page->path))) {
    $page->loadAsDefault();
    $page->render(Site::getTheme())->display();
  } else {
    header('Content-Type: text/html');
    http_response_code(403);
  }
}
function showErrorPage($error) {
  $user = Site::getAnonymousUser();
  Site::setError($error);
  $page = Site::getErrorPage();
  if (Site::userHasPermission($user, array('*',$page->path))) {
    $page->loadAsDefault();
    $page->render(Site::getTheme())->display();
  } else {
    header('Content-Type: text/html');
    http_response_code(403);
  }
}

function handleError($e, $e2) {
  if (CMS_DEBUG) {
      header('Content-Type: text/html');
      http_response_code(500);
      ?><html>
<head><title>Server Error</title></head>
<body><pre>
<?php echo $e->getMessage(); ?>

<?php echo $e->getTraceAsString(); ?>

<?php echo $e2->getMessage(); ?>

<?php echo $e2->getTraceAsString(); ?>
</pre></body>
</html><?php
    } else {
      throw $e2;
    }
}

try {
  Site::load();
  $user = Site::getUser();
  $page = Site::getPageForRequest();
  if (Site::userHasPermission($user, array('*',$page->path))) {
    showRequestedPage($page, $user);
  } else {
    showAccessDeniedPage($user);
  }
} catch (Exception $e) {
  try {
    showErrorPage($e);
  } catch (Exception $e2) {
    handleError($e, $e2);

  }
}
