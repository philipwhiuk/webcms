<?php

spl_autoload_register(function ($class_name) {
    $file = str_replace("_","/",strtolower($class_name)) . '.php';
    if (!file_exists($file)) {
      throw new Exception("SITE_MISSING_CLASS_FILE");
    }
    require_once str_replace("_","/",strtolower($class_name)) . '.php';
});
