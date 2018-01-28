<?php

namespace App;
/**
* 
*/
class Route
{
    public static $domain = "http://blog.inner";

    protected $web_routes = [];
    protected $api_routes = [];
    protected $current_registration;


    // function __construct(argument)
    // {
        
    // }

    public static function start()
    {
        $router = new static;
        $router->bootstrap();
        $router->resolve($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
    }

    public function bootstrap()
    {
        $this->current_registration = 'web';
        include '../routes/web.php';

        $this->current_registration = 'api';
        include '../routes/api.php';
    }

    public function register($query_method, $route, $controller)
    {
        $query_method = strtolower($query_method);

        if ($route == '/') {
            if ($this->current_registration == 'web') {
                $this->web_routes["[$query_method]"] = $controller;
            } elseif ($this->current_registration == 'api') {
                throw new \Exception("Restricted API route");
            }
        }

        $route_sequence = array_slice(explode('/', $route), 1);

        if ($this->current_registration == 'web') {
            $current_array = &$this->web_routes;
        } elseif ($this->current_registration == 'api') {
            $current_array = &$this->api_routes;
        }

        for ($i = 0; $i < count($route_sequence); $i++) {
            $route_part = $route_sequence[$i];
            if (!array_key_exists($route_part, $current_array)) {
                $current_array[$route_part] = [];
            }
            $current_array = &$current_array[$route_part];
        }

        $current_array["[$query_method]"] = $controller;
    }

    public function resolve($route, $query_method)
    {
        if (count($get_string = explode('?', $route)) == 2) {
            [$route, $params] = explode('?', $route);
        }
        $route_sequence = array_slice(explode('/', $route), 1);

        $query_method = strtolower($query_method);

        if ($route_sequence[0] == 'api') {
            $current_array = &$this->api_routes;
            $route_sequence = array_slice($route_sequence, 1);
        } else {
            $current_array = &$this->web_routes;
        }
        

        $vars = [];

        for ($i = 0; $i < count($route_sequence); $i++) {
            $route_part = $route_sequence[$i];

            if (array_key_exists($route_part, $current_array)) {
                $current_array = &$current_array[$route_part];
            } else {
                $keys = preg_grep("/^\{[A-Za-z]+\}$/", array_keys($current_array));

                if (!$keys) {
                    throw new \Exception("Undefined route");    
                }
                $key = array_shift($keys);
                $var_name = substr($key, 1, strlen($key) - 2);
                $vars[$var_name] = $route_part;

                $current_array = &$current_array["{".$var_name."}"];
            }
        }

        $input = (object) [];

        if (count($_REQUEST)) {
            $input = (object) $_REQUEST;
        } else {
            $json = file_get_contents("php://input");

            if(isset($json) && !empty($json)) {
                $input = json_decode($json);
            }
        }


        [$controller_name, $controller_method] = explode(
            '@', 
            $current_array[ "[".$query_method."]"]
        );

        call_user_func(
            array(
                "\\App\\Controller\\$controller_name", 
                $controller_method
            ),
            $vars,
            $input
        );
    }
}