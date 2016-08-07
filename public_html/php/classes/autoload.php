<?php

/**
 * PSR-4 compliant Autoloader
 *
 * This will load classes and dynamically decide which class(es) to load.
 * This is the basis for packages that use Composer
 *
 * @param string $class fully qualified class name to load
 * @see http://www.php-fig.org/psr/psr-4/examples/ PSR-4 Example Autoloader for seeing examples to follow
 *
 * spl autoload register is aka a closure (n.) a function within a function.
 **/
spl_autoload_register(function($class) {
    /**
     * CONFIGURABLE PARAMETERS
     * prefix: the prefix for all the classes (i.e., the namespace)
     * baseDir the base directory for all classes (default = current directory)
     **/
    $prefix = "Edu\\Cnm\\Flek";
    $baseDir = __DIR__;

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    // get the relative class name
    $className = substr($class, $len);

    // replace the namespace prefix with the base directory, replace namespace
    // separators with directory separators in the relative class name, append
    // with .php
    $file = $baseDir . str_replace("\\", "/", $className) . ".php";

    // if the file exists, require it
    if(file_exists($file)) {
        require_once($file);
    }
});