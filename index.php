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
    'user' => 'p1605304',
    'password' => '11605304',
    'dbname' => 'p1605304',
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

$app->get('/article/{index}', 'DUT\\Controllers\\ArticleController::AfficheArticle');


//web/index.php
$app->get('/example', function() use ($app) {
	return $app['twig']->render('Vue.twig', ['name' => 'Lucas']);
});


$app->get('/create', 'DUT\\Controllers\\ItemsController::createAction');
$app->post('/create', 'DUT\\Controllers\\ItemsController::createAction');

$app->get('/remove/{index}', 'DUT\\Controllers\\ItemsController::deleteAction');
$app->get('/check/{index}', 'DUT\\Controllers\\ItemsController::checkAction');

$app['debug'] = true;
$app->run();

/**123456789**/