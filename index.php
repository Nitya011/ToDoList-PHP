<?php

require_once 'vendor/autoload.php';
require_once 'core/Bootstrap.php';

Router::load('routes.php')
    ->direct(Request::uri(), Request::method());