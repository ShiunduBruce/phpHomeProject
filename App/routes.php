<?php
$router->get('', 'TimesController@index');
$router->get('post-new-date', 'TimesController@create');
$router->post('post-new-date','TimesController@store');
$router->get('next-month', 'TimesController@increase');
$router->get('previous-month', 'TimesController@decrease');

$router->get('login', 'AuthController@show');
$router->post('login', 'AuthController@authenticate');
$router->get('logout', 'AuthController@logout');

$router->get('signup', 'UsersController@create');
$router->post('signup', 'UsersController@store');

$router->post('', 'BookingController@index');
$router->get('book-this-date', 'BookingController@show');
$router->post('book-this-date', 'BookingController@store');
$router->get('cancel-booking', 'BookingController@destroy');
