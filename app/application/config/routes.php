<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'Login';
$route['404_override'] = 'errors/page_missing';
$route['translate_uri_dashes'] = FALSE;

$route['login'] = 'Login';
$route['authenticate'] = 'Login/authenticate';
$route['logout'] = 'Login/logout';
$route['admin'] = 'Admin';
$route['addUser'] = 'Admin/addUser';
$route['editUser'] = 'Admin/editUser';
$route['dashboard'] = 'Dashboard';
$route['vesselitem/view/(:any)'] = 'VesselItem/view/$1';
$route['vesselitem/submit_for_validation'] = 'VesselItem/submit_for_validation';
$route['vesselitem/submit_for_amendment'] = 'VesselItem/submit_for_amendment';
$route['notes/add_notes'] = 'notes/add_notes';
$route['remarks/get_item_remarks/(:any)'] = 'Remarks/get_item_remarks/$1';
$route['remarks/add_item_remark'] = 'Remarks/add_item_remark';
$route['agentvessel/view/(:any)'] = 'AgentVessel/view/$1';
$route['agentvessel/ok_to_pay'] = 'AgentVessel/ok_to_pay';
$route['agentvessel/for_amendment_tad'] = 'AgentVessel/for_amendment_tad';
$route['agentvessel/for_amendment_acctg'] = 'AgentVessel/for_amendment_acctg';
$route['agentvessel/validate_liquidation'] = 'AgentVessel/validate_liquidation';
$route['archive'] = 'VesselItem/archive';
$route['vesselitem/add_item'] = 'VesselItem/add_item';
$route['add_item_remark'] = 'VesselItem/add_item_remark';
$route['get_item_remarks'] = 'VesselItem/get_item_remarks';
$route['revalidate'] = 'Revalidate/get_for_am';

// routes for file upload
$route['upload'] = 'FileUploads/index';
$route['delete/(:any)'] = "FileUploads/delete/$1";
$route['upload/file_upload'] = 'FileUploads/file_upload';
