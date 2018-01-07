<?php
session_start();
$_SESSION['id']=1;

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

$app->post('/create', 'DUT\\Controllers\\ArticleController::createAction')
    ->bind('created');

$app->get('/search/{key}', 'DUT\\Controllers\\ArticleController::searchAction')
    ->bind('search');

$app->post('/add', 'DUT\\Controllers\\UserController::add')
    ->bind('add');


$app->get('/addComment', 'DUT\\Controllers\\ArticleController::commentAction')
    ->bind('addComment');

$app->post('/con', 'DUT\\Controllers\\UserController::con')
    ->bind('con');

//$app->post('/create', 'DUT\\Controllers\\ItemsController::createAction');



$app['debug'] = true;
$app->run();

/**123456789**/