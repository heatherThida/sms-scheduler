<?php
/**
 * Class: Index
 */

class Index extends Controller
{
    /**
     * Extend basic Controller class
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * Default controller when user gives no input, i.e handle URL/index/index
     */
    function index()
    {
        echo "Inside index method of Index Class.";
        echo "<h1>This is the homepage</h1>";

        $x = $this->view->render('index/index');
    }

} 