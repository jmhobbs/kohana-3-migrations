<?php 
Route::set('migrations', 'migrations(/<action>(/<id>))',
    array(
        'action'    => '(index|up|down)',
        'id'        => '\d+',
    ))->defaults(array(
        'controller'=> 'migrations',
        'action'    => 'index',
    ));
