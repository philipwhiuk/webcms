<?php
class Site {
    static $config;
    static $liveSettings;
    static $error;

    static function load() {
      self::$config = Config::load();
      self::$liveSettings = LiveSettings::get();
      Module::loadModules();
    }

    static function getDefaultPage() {
        return Page::getByPath(self::$config->getProperty('site_home_path'));
    }

    static function getPageAccessDeniedPage() {
      $accessDeniedPath = self::$config->getProperty('site_access_denied_path');
      return Page::getByPath($accessDeniedPath);
    }

    static function getPageNotFoundPage($path) {
      $notFoundPath = self::$config->getProperty('site_page_not_found_path');
      if ($path !== $notFoundPath) {
        return Page::getByPath($notFoundPath);
      }
      throw new Exception('PAGE_NOT_FOUND_PAGE_NOT_FOUND');
    }

    static function getErrorPage() {
        return Page::getByPath(self::$config->getProperty('site_error_path'));
    }

    static function getPageForRequest() {
        if (empty($_GET['page'])) {
          return self::getDefaultPage();
        }
        $path = explode('/', $_GET['page'], 2);
        return Page::getByPath($path[0]);
    }

    static function getPageRequest() {
      if (empty($_GET['page'])) {
        return '';
      }
      $path = explode('/', $_GET['page'], 2);
      if (count($path) < 2) {
          return '';
      }
      return $path[1];
    }

    static function getPathRequest() {
      return $_GET['page'];
    }

    static function resolvePagePermissions($path) {
      $pathParts = explode('/', $path, 2);
      $page = Page::getByPath($pathParts[0]);
      $relativePath = (count($pathParts) < 2) ? '' : $pathParts[1];
      $pageRequest = $page->resolveRequest($relativePath);
      $options = $page->getPermissionOptions($pageRequest);
      $options[] = $path;
      return $options;
    }


    static function getApiUrl($module, $request) {
      if (self::getConfigProperty('site_clean_urls')) {
        return dirname($_SERVER['SCRIPT_NAME']).'/api.php?request='.$module.'/'.$request;
      } else {
        return 'api.php?request='.$module.'/'.$request;
      }
    }

    static function getPageUrl($page, $request) {
      if (self::getConfigProperty('site_clean_urls')) {
        return dirname($_SERVER['SCRIPT_NAME']).'/'.$page->path.'/'.$request;
      } else {
        return 'index.php?page='.$page->path.'/'.$request;
      }
    }

    static function getPathUrl($path) {
      if (self::getConfigProperty('site_clean_urls')) {
        return dirname($_SERVER['SCRIPT_NAME']).'/'.$path;
      } else {
        return 'index.php?page='.$path;
      }
    }

    static function getRootUrl() {
      if (self::getConfigProperty('site_clean_urls')) {
        return dirname($_SERVER['SCRIPT_NAME']).'/';
      } else {
        return '';
      }
    }

    static function getFullPageUrl($page, $request) {
      if (self::getConfigProperty('site_clean_urls')) {
        return $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']).'/'.$page->path.'/'.$request;
      }
      return $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'].'?page='.$page->path.'/'.$request;
    }
    static function getFullPageEncodedUrl($page, $request) {
      if (self::getConfigProperty('site_clean_urls')) {
        return urlencode($_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']).'/'.$page->path.'/'.$request);
      }
      return urlencode($_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'].'?page=').$page->path.'/'.$request;
    }

    static function getModuleForRequest() {
        if (empty($_GET['request'])) {
          return self::getErrorModule();
        }
        $path = explode('/', $_GET['request'], 2);
        return Module::getLoadedByName($path[0]);
    }

    static function getApiRequest() {
      if (empty($_GET['request'])) {
        return '';
      }
      $path = explode('/', $_GET['request'], 2);
      return $path[1];
    }

    static function getFullUrlForPage($page) {
      return $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'].'?page='.$page->path;
    }

    static function getConfigProperty($property) {
      return self::$config->getProperty($property);
    }

    static function getTitle() {
      return self::getConfigProperty('site_title');
    }

    static function getTheme() {
      return Theme::getByName(self::$config->getProperty('site_default_theme'));
    }

    static function getUser() {
      if (!empty($_SESSION['user_username'])) {
        $user = User_User::getByUsername($_SESSION['user_username']);
        if ($user != null) {
          return $user;
        }
      }
      //TODO: Cookies and stuff
      return User_User::getById(self::$config->getProperty('site_anonymous_user'));
    }

    static function getAnonymousUser() {
      return User_User::getById(self::$config->getProperty('site_anonymous_user'));
    }

    static function userHasPermission($user, $permissionOptions) {
      return User_Permission::permissionExists($user->id, $permissionOptions);
    }

    static function setError($error) {
      self::$error = $error;
    }

    static function getError() {
      return self::$error;
    }
}
