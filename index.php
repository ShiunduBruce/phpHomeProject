<?php

require 'App/Core/bootstrap.php';
use App\Core\{Router, Request};

require Router::load('App/routes.php')
    ->direct(Request::uri(), Request::method());
