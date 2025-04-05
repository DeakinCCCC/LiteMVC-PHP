<?php

$classPrefixList = ['app\\', 'core\\'];

foreach ($classPrefixList as $prefix) {
  spl_autoload_register(function($class) use ($prefix) {
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
      return;
    }
    $classFile = __DIR__ . DIRECTORY_SEPARATOR. str_replace('\\', DIRECTORY_SEPARATOR, $class). '.php';
    if (file_exists($classFile)) {
      require $classFile;
    }
  });
}