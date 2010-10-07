<?php
	$config = array();

	/**
	* Path to your migrations folder.
	* Typically, it will be within your application path.
	* -> Writing permission is required within the migrations path.
	*
	* Paths are oranized by database groups
	*/
	$config['path'] = array (
		'default' => APPPATH . 'migrations/',
	);

	/**
	* Subdirectory to store meta-information about the state of the migrations.
	*/
	$config['info'] = '.info';

	return $config;
