<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'login';
$route['404_override'] = 'errors/page_missing';
$route['translate_uri_dashes'] = FALSE;

$route['login'] = 'login';
$route['login/authenticate'] = 'login/authenticate';
$route['logout'] = 'login/logout';
$route['admin'] = 'admin';
$route['addUser'] = 'admin/addUser';
$route['editUser'] = 'admin/editUser';
$route['dashboard'] = 'dashboard';
$route['vesselitem'] = 'vesselitem/view';
$route['agentvessel'] = 'agentvessel';
$route['archive'] = 'vesselitem/archive';
$route['add_item'] = 'vesselitem/add_item';
$route['add_item_remark'] = 'vesselitem/add_item_remark';
$route['get_item_remarks'] = 'vesselitem/get_item_remarks';
$route['sample/(:any)'] = 'breakdowncost/get_breakdown_cost/$1';
$route['vesselitem/view/(:any)/(:any)'] = 'vesselitem/view/$1/$2';
$route['revalidate'] = 'revalidate/get_for_am';
