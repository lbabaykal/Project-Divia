<?php

namespace App\Configuration;

use App\Router;

Router::addRoute('^$', ['controller' => 'Main', 'action' => 'Index']);
Router::addRoute('^(?P<controller>[a-zA-Z_]+)/?$');
Router::addRoute('^(?P<controller>[a-zA-Z_]+)/(?P<action>[a-zA-Z_]+)/?$');

