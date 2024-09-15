<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

 

$routes->get('/', 'Home::login');

$routes->get('/home/dashboard', 'Home::dashboard');

$routes->get('/home/signup', 'Home::signup');
$routes->get('/home/login', 'Home::login');
$routes->post('/home/loginSubmit', 'Home::loginSubmit');
$routes->get('/home/logout', 'Home::logout');

$routes->get('/home/listSong', 'Home::listSong');
$routes->post('/home/listSong', 'Home::listSong');
$routes->get('/home/songDetail', 'Home::songDetail');

$routes->get('/home/uploadProfile', 'Home::uploadProfile');
$routes->post('/home/uploadProfilePicture', 'Home::uploadProfilePicture');


$routes->get('/home/getUsers', 'Home::getUsers');
$routes->get('/home/userList', 'Home::userList');
$routes->post('/home/userList', 'Home::userList');
$routes->get('/home/listUser', 'Home::listUser');

$routes->get('/home/companyAdd', 'Home::companyAdd');
$routes->post('/home/companySave', 'Home::companySave');
$routes->post('/home/saveLogin', 'Home::saveLogin');


//Admin Routes
$routes->get('/admin/login', 'Admin::login');
$routes->post('/admin/loginSubmit', 'Admin::loginSubmit');

$routes->get('/admin/dashboard', 'Admin::dashboard');

$routes->get('/admin/userList', 'Admin::userList');
$routes->get('/admin/userAdd', 'Admin::userAdd');
$routes->post('/admin/userSave', 'Admin::userSave');

$routes->get('/admin/listSong', 'Admin::listSong');
$routes->post('/admin/listSong', 'Admin::listSong');
$routes->get('/admin/addSong', 'Admin::addSong');
$routes->post('/admin/saveSong', 'Admin::saveSong');
$routes->get('/admin/deleteSong', 'Admin::deleteSong');
$routes->get('/admin/deleteUser', 'Admin::deleteUser');
$routes->get('/admin/logout', 'Admin::logout');


$routes->post('/api/login', 'AppApi::login');
