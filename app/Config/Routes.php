<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
$routes->get('/', 'LoginController::view');

$routes->get('/login', 'LoginController::view');
$routes->post('/login/authenticate', 'LoginController::authenticate');
$routes->get('/logout', 'LoginController::logout');
$routes->get('/forgotPassword', 'LoginController::forgotPassword');
$routes->get('/resetPassword', 'LoginController::ResetPass');

$routes->get('forgotPassword', 'LoginController::forgotPassword');
$routes->post('sendResetLink', 'LoginController::sendResetLink');
$routes->get('resetPassword/(:any)', 'LoginController::resetPassword/$1');
$routes->post('updatePassword', 'LoginController::updatePassword');

$routes->get('/admin', 'AdminController::dashboard');
$routes->get('/profile', 'AdminController::display');
$routes->post('profile/update', 'AdminController::update');
$routes->get('/admin/changePass', 'AdminController::view');
$routes->post('/admin/changePassword', 'AdminController::changePassword');


$routes->get('/staff', 'UserInfoController::create');
$routes->post('/staff/insert', 'UserInfoController::insert');
$routes->get('/staff/view', 'UserInfoController::view');
$routes->post('/staff/update', 'UserInfoController::update');
$routes->get('/staff/fetchUsers/(:num)', 'UserInfoController::fetchUsers/$1');
$routes->get('/staff/fetch', 'UserInfoController::fetchAll');
$routes->post('/staff/delete/(:num)', 'UserInfoController::delete/$1');
$routes->get('/staff/profile', 'UserInfoController::display');
$routes->get('staff/details/(:num)', 'UserInfoController::details/$1');



$routes->get('/project', 'ProjectController::create');
$routes->get('/project/view', 'ProjectController::view');
$routes->post('project/insert', 'ProjectController::insert');
$routes->get('/project/fetchProject/(:num)', 'ProjectController::fetchProject/$1');
$routes->post('/project/update', 'ProjectController::update');
$routes->get('/project/fetch', 'ProjectController::fetchAll');
$routes->post('/project/delete/(:num)', 'ProjectController::delete/$1');
$routes->get('/project/profile', 'ProjectController::display');
$routes->get('project/details/(:num)', 'ProjectController::details/$1');


$routes->get('/meeting', 'MeetingController::create');
$routes->post('meeting/insert', 'MeetingController::insert');
$routes->get('/meeting/view', 'MeetingController::view');
$routes->get('/meeting/fetch', 'MeetingController::fetchAll');
$routes->post('/meeting/delete/(:num)', 'MeetingController::delete/$1');
$routes->post('/meeting/update', 'MeetingController::update');
$routes->get('/meeting/fetchMeeting/(:num)', 'MeetingController::fetchMeeting/$1');
$routes->get('/meeting/profile', 'MeetingController::display');
$routes->get('meeting/details/(:num)', 'MeetingController::details/$1');


$routes->get('/chat', 'ChatController::view');
$routes->get('chat/getMessages/(:num)', 'ChatController::getMessages/$1');
$routes->post('chat/sendMessage', 'ChatController::sendMessage');
$routes->get('chat/getUsers', 'ChatController::getUsers');
