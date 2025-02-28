<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	=> '',
	'hostname' => '192.168.197.70', 
<<<<<<< HEAD
	'username' => 'jessadj', 
	'password' => '@w@ll3m_m1s', 
=======
	'username' => 'root', 
	'password' => 'rootpassword', 
>>>>>>> d32164c39d5d2888847dd400f1d18200b3b10daf
	'database' => 'liquidation', 
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => TRUE,
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
