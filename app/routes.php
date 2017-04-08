<?php
// Routes

$app->get('/', \Quotation\Controller\HomeController::class . ':indexAction')
    ->setName('homepage');

$app->group('/article', function() use ($app) {
    $app->get('/list', \Quotation\Controller\ArticleController::class . ':indexAction')
        ->setName('article-list');
});

$app->group('/categorie', function() use ($app) {
    $app->get('/list', \Quotation\Controller\CategorieController::class . ':indexAction')
        ->setName('categorie-list');
});
