<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$route = [
	/**
	 * Route for dashboard URl
	 */
	'cronjob'			=> 'Cronjob/doJobs',

	'^(admin|admin/)'	=> 'Admin/main/index',
	'admin/dashboard'   => 'Admin/main/index',

	'admin/login'   	=> 'Admin/auth/login',
	'admin/logout'   	=> 'Admin/auth/logout',

	/**
	 * Route for campaign
	 */
	'admin/campaign/email/list'       => 	'Admin/campaign/email_list',
	'admin/campaign/email/add/(:any)' => 	'Admin/campaign/email_add/$1',
	'admin/campaign/email/edit'       => 	'Admin/campaign/email_edit',
	'admin/campaign/email/delete'     => 	'Admin/campaign/email_delete',
	'admin/campaign/email/email_send' => 	'Admin/campaign/email_post_send',

	/*
	 * Router for campaign template 
	 */
	'admin/campaign/template/list'          => 	'Admin/template/list',
	'admin/campaign/template/add'           => 	'Admin/template/add',
	'admin/campaign/template/edit/(:num)'   => 	'Admin/template/edit/$1',
	'admin/campaign/template/delete/(:num)' => 	'Admin/template/delete/$1',
	'admin/campaign/template/(:any)'        =>	'Admin/template/home',

	/**
	 * Route for Directory it mean group of contact
	 */
	'admin/contact/group/list'          => 'Admin/group/list',
	'admin/contact/group/add'           => 'Admin/group/add',
	'admin/contact/group/edit/(:num)'   => 'Admin/group/edit/$1',
	'admin/contact/group/delete/(:num)' => 'Admin/group/delete/$1',
	'admin/contact/group/(:any)'        => 'Admin/group/home',

	/**
	 * Route for Contact it mean Email list
	 */
	'admin/contact/list'          => 	'Admin/contact/list',
	'admin/contact/add'           => 	'Admin/contact/add',
	'admin/contact/import'        => 	'Admin/contact/import',
	'admin/contact/edit/(:num)'   => 	'Admin/contact/edit/$1',
	'admin/contact/delete/(:num)' => 	'Admin/contact/delete/$1',
	'admin/contact/(:any)'        =>	'Admin/contact/home',

	/**
	 * Route for User
	 */
	'admin/user/list'   => 	'Admin/user/list',
	'admin/user/add'    => 	'Admin/user/add',
	'admin/user/edit'   => 	'Admin/user/edit',
	'admin/user/delete' => 	'Admin/user/delete',
	'admin/user/(:any)' =>	'Admin/user/home',

	'admin/user/list'   => 	'Admin/main/index',
	'admin/user/add'    => 	'Admin/main/index',
	'admin/user/edit'   => 	'Admin/main/index',
	'admin/user/delete' => 	'Admin/main/index',
	'admin/user/(:any)' =>	'Admin/main/index',

	/**
	 * Route for configuration
	 */
	'admin/setting/get_secret_key'  => 	'Admin/Configuration/generating_secret_key',
	'admin/setting'   				=> 	'Admin/Configuration/index',
	'api/(:any)'   					=> 	'VIK_Api/index/$1',

	/**
	 * Route for default
	 */
	'admin/(:any)'    => 'Admin/main/home',
	'test'			  => 'VIK_Api/test',
	'upload'		  => 'Upload/index'
];

$route['default_controller'] = "home";
$route['404_override']         = 'Admin/main/index';
$route['translate_uri_dashes'] = true;