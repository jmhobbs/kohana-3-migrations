<?php defined('SYSPATH') or die('No direct script access.');

Route::set('migration', '<controller>(/<action>(/<id>))')
    ->defaults(array(
        'controller' => 'migration',
    )); 
