<?php

require __DIR__ . '/vendor/autoload.php';

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;


$app = new Silex\Application();
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
//web/index.php
$app->register(new Silex\Provider\TwigServiceProvider(), [
	'twig.path' => __DIR__.'/src/views',
]);


$app['connection'] = [
    'driver' => 'pdo_mysql',
    'host' => 'localhost',
    'user' => 'root',
    'password' => '',
    'dbname' => 'blog',
    'charset' => 'utf8'
];

$app['doctrine_config'] = Setup::createYAMLMetadataConfiguration([__DIR__ . '/config'], true);

$app['em'] = function ($app) {
    return EntityManager::create($app['connection'], $app['doctrine_config']);
};





/**
 * ROUTES
 */
$app->get('/', 'DUT\\Controllers\\ArticleController::listArticles')
    ->bind('home');

$app->get('/inscription', 'DUT\\Controllers\\UserController::inscription')
    ->bind('inscription');

$app->get('/article/{index}', 'DUT\\Controllers\\ArticleController::AfficheArticle');

$app->get('/create', 'DUT\\Controllers\\ArticleController::createAction')
    ->bind('create');

$app->get('/search/{key}', 'DUT\\Controllers\\ArticleController::searchAction')
    ->bind('search');

$app->post('/add', 'DUT\\Controllers\\UserController::add')
    ->bind('add');

//web/index.php
$app->get('/example', function() use ($app) {
	return $app['twig']->render('Vue.twig', ['name' => 'Lucas']);
});




//$app->post('/create', 'DUT\\Controllers\\ItemsController::createAction');

$app->get('/remove/{index}', 'DUT\\Controllers\\ItemsController::deleteAction');
$app->get('/check/{index}', 'DUT\\Controllers\\ItemsController::checkAction');

$app['debug'] = true;
$app->run();

/**123456789**/