<?php defined('SYSPATH') or die('No direct script access.');

Route::set('migrations', 'migrations(/<action>(/<id>))')
    ->defaults(array(
        'controller' => 'migrations',
    )); 
