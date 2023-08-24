<?php

namespace App\Configuration;

use App\Router;

Router::addRoute('^$', ['controller' => 'main', 'action' => 'index']);



Router::addRoute('^/?article/(?P<id_article>[0-9]+)/?$', ['controller' => 'article', 'action' => 'index']);

Router::addRoute('^/?chapter/(?P<chapter_name>[a-z]+)/?$', ['controller' => 'chapter', 'action' => 'index']);
Router::addRoute('^/?chapter/(?P<chapter_name>[a-z]+)/page/(?P<page>[0-9]+)?$', ['controller' => 'chapter', 'action' => 'page']);


Router::addRoute('^(?P<controller>[a-zA-Z_]+)/?$');
Router::addRoute('^(?P<controller>[a-zA-Z_]+)/(?P<action>[a-zA-Z_]+)/?$');


