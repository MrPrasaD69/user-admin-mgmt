<?php

// namespace App\Filters;

// use CodeIgniter\HTTP\RequestInterface;
// use CodeIgniter\HTTP\ResponseInterface;
// use CodeIgniter\Filters\FilterInterface;

// class UserAuth implements FilterInterface{
//     public $session;
        
//     public function before(RequestInterface $request, $arguments = null)
//     {
        
//         $this->session = \Config\Services::session();
        
//         // Check if user session variable is set
//         if (empty($_SESSION['user_id'])) {

//             $mod_arr = explode("/",$_SERVER['REQUEST_URI']);
//             // print_r($mod_arr);exit;
//             if ($mod_arr[2]== 'home' && $mod_arr[3] !='login' ) {
//                 return redirect()->to(base_url('home/login'));
//             }
//         }
//     }

//     public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
//     {
//         // No post-processing required
//     }
// }

?>