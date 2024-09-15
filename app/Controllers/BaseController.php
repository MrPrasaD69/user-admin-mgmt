<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;
    protected $session;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */

     public function __construct(){
        // Load the session service
        $this->session = \Config\Services::session();
        // echo "here";exit;
        $this->checkUser();

    }


    public function checkUser(){
        $allowedRoutes = ['login','signup','loginSubmit'];
        
        $route_arr = explode('/',$_SERVER['REQUEST_URI']);
        // print_r($_SESSION);exit;

        $controller = (!empty($route_arr[2]) ? $route_arr[2] : '');
        $action = (!empty($route_arr[3]) ? $route_arr[3] : '');
        
        if($controller=='home'){ //User Panel
            if(empty($_SESSION['user_id']) && !in_array($action,$allowedRoutes)){
                header("Location: ".base_url()."home/login");
                exit;
            }

            if(!empty($_SESSION['user_id']) && in_array($action,$allowedRoutes)){
                header("Location: ".base_url()."home/dashboard");
                exit;
            }
        }
        else{
            //Admin Panel Redirection
            if(empty($_SESSION['admin_id']) && !in_array($action, $allowedRoutes)){
                header("Location: ".base_url()."admin/login");
                exit;
            }            
        }
    }

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
    }

    public function setSession($key,$value){
        $this->session->set($key, $value);
    }

    public function getSession($key,$value){
        return $this->session->get($key);
    }

    public function destroySession($key){
        $this->session->remove($key);
    }

    public function generateToken(){
        $model = new UserModel;
        $token = md5(rand(10,10000));

        $check = $model->where('token="'.$token.'"')->first();

        if(!empty($check)){
            $this->generateToken();
        }
        return $token;
    }
}
