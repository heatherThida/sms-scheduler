<?php

/**
 * Base Controller Class
 */

class Controller
{
    /**
     * Constructor
     */
    function __construct()
    {

    }

    /**
     *
     */
    public function loadModel($modelName)
    {
        require 'app/models/' . strtolower($modelName) . '.php';

        return new $modelName();
    }
}