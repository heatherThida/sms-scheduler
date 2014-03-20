<?php
/**
 * Autoloader
 */
function autoload($class) {
    // Make sure first letter is capitalized
    $class = ucfirst(strtolower($class));

    // If file does not exist in LIBS_PATH folder = 'app/libs/
    if (file_exists(LIBS_PATH . $class . '.php')) {
        require LIBS_PATH . $class . '.php';
    } else {
        exit ('The file ' . $class . '.php is missing in the libs folder');
    }
}

// Autload the needed class everytime a such a file is called
spl_autoload_register("autoload");