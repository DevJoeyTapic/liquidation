<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'login';
$route['404_override'] = 'errors/page_missing';
$route['translate_uri_dashes'] = FALSE;

$route['login'] = 'login';
$route['login/authenticate'] = 'Login/authenticate';
$route['logout'] = 'login/logout';
$route['admin'] = 'Admin';
$route['addUser'] = 'Admin/addUser';
$route['editUser'] = 'Admin/editUser';
$route['dashboard'] = 'Dashboard';
$route['vesselitem'] = 'VesselItem/view';
$route['agentvessel'] = 'AgentVessel/view';
$route['archive'] = 'VesselItem/archive';
$route['add_item'] = 'VesselItem/add_item';
$route['add_item_remark'] = 'VesselItem/add_item_remark';
$route['get_item_remarks'] = 'VesselItem/get_item_remarks';
$route['revalidate'] = 'Revalidate/get_for_am';

// routes for file upload
$route['upload'] = 'FileUploads/index';
$route['delete/(:any)'] = "FileUploads/delete/$1";
$route['upload/file_upload'] = 'FileUploads/file_upload';
