<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class ApiBaseController extends Controller{


    public function __construct()
    {
        $route_arr = explode('/',$_SERVER['REQUEST_URI']);
        $controller = (!empty($route_arr[2]) ? $route_arr[2] : '');
        $action = (!empty($route_arr[3]) ? $route_arr[3] : '');


    }

    

}

?>