<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'login';
$route['404_override'] = 'errors/page_missing';
$route['translate_uri_dashes'] = FALSE;

$route['login'] = 'login';
$route['login/authenticate'] = 'login/authenticate';
$route['logout'] = 'logout';
$route['dashboard'] = 'dashboard';
$route['vesselitem/(:any)/(:any)'] = 'vesselitem/view/$1/$2';
$route['agentvessel'] = 'agentvessel';

