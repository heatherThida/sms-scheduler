<?php

class Application
{
    /**
     * @var null The controller
     */
    private $url_controller = null;

    /**
     * @var null the method or "action"
     */
    private $url_action = null;

    /**
     * @var null Parameter one
     */
    private $url_parameter_1 = null;

    /**
     * @var null Parameter two
     */
    private $url_parameter_2 = null;

    /**
     * @var null Parameter three
     */
    private $url_parameter_3 = null;

    /**
     * Instantiate the class
     *
     * Parse URL elements and call the respective controller/method or the fallback
     */
    public function __construct()
    {
        // Create array with URL parts in $url
        $this->splitUrl();

        if ($this->url_controller) {
            // Check if controller exists
            if (file_exists(CONTROLLER_PATH . $this->url_controller . '.php')) {

                echo "{$this->url_controller}.php exists.";
                debug(get_class_vars($this->url_controller));

                // Load this file and create the controller
                require './app/controllers/' . $this->url_controller() . '.php';
                $this->url_controller = new $this->url_controller();
                debug($this->url_controller);
                var_dump($this->url_controller);

                // Check to see if method exists
                if (method_exists($this->url_controller, $this->url_action)) {

                    echo "$this->url_action method exists";


                    // Call the method and pass the arguments to it
                    if (isset($this->url_parameter_3)) {
                        // Eg. $this->home->method($param_1, $param_2, $param_3);
                        $this->url_controller->{$this->url_action}($this->url_parameter_1, $this->url_parameter_2, $this->url_parameter_3);
                    } elseif (isset($this->url_parameter_2)) {
                        // Eg. $this->home->method($param_1, $param_2);
                        $this->url_controller->{$this->url_action}($this->url_parameter_1, $this->url_parameter_2);
                    } elseif (isset($this->url_parameter_1)) {
                        // Eg. $this->home->method($param_1);
                        $this->url_controller->{$this->url_action}($this->url_parameter_1);
                    } else {
                        // No parameters given
                        $this->url_controller->{$this->url_action}();
                    }
                } else {
                    echo "Else no real parameter";
                    // Call the index() method of selected controller as the default fallback
                    $this->url_controller->index();
                }
            } else {
                // Invalid URL, simply show home/index
                // TODO: update this to show a 404 page instead
                echo "Invalid URL";
                require CONTROLLER_PATH . 'Index.php';
                $controller = new Index();
                $controller->index();
            }
        }

    }

    /**
     * Get and split the URL
     */
    private function splitUrl()
    {
        if (isset($_GET['url'])) {
            // Split the URL
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);

            //debug($url);

            // Set URL parts into controller, method, and parameters
            $this->url_controller   = (isset($url[0]) ? ucfirst(strtolower($url[0])) : null);
            $this->url_action       = (isset($url[1]) ? $url[1] : null);
            $this->url_parameter_1  = (isset($url[2]) ? $url[2] : null);
            $this->url_parameter_2  = (isset($url[2]) ? $url[3] : null);
            $this->url_parameter_3  = (isset($url[2]) ? $url[4] : null);

            // Debugging
             echo 'Controller: ' . $this->url_controller . '<br />';
             echo 'Action: ' . $this->url_action . '<br />';
             echo 'Parameter 1: ' . $this->url_parameter_1 . '<br />';
             echo 'Parameter 2: ' . $this->url_parameter_2 . '<br />';
             echo 'Parameter 3: ' . $this->url_parameter_3 . '<br />';
        }
    }
}