<?php
// Routes

$app->get('/', \Quotation\Controller\HomeController::class . ':indexAction')
    ->setName('home');

$app->group('/article', function() use ($app) {
    $app->get('/list', \Quotation\Controller\ArticleController::class . ':indexAction')
        ->setName('article-list');
    $app->get('/edit[/{id: \d+}]', \Quotation\Controller\ArticleController::class . ':editAction')
        ->setName('article-edit');
    $app->get('/delete[/{id: \d+}]', \Quotation\Controller\ArticleController::class . ':deleteAction')
        ->setName('article-delete');
    $app->post('/save', \Quotation\Controller\ArticleController::class . ':saveAction')
        ->setName('article-save');
});

$app->group('/categorie', function() use ($app) {
    $app->get('/list', \Quotation\Controller\CategorieController::class . ':indexAction')
        ->setName('categorie-list');
    $app->get('/edit[/{id: \d+}]', \Quotation\Controller\CategorieController::class . ':editAction')
        ->setName('categorie-edit');
    $app->get('/delete/{id: \d+}', \Quotation\Controller\CategorieController::class . ':deleteAction')
        ->setName('categorie-delete');
    $app->post('/save', \Quotation\Controller\CategorieController::class . ':saveAction')
        ->setName('categorie-save');
});

$app->group('/hotel', function() use ($app) {
    $app->get('/list', \Quotation\Controller\HotelController::class . ':indexAction')
        ->setName('hotel-list');
    $app->get('/edit[/{id: \d+}]', \Quotation\Controller\HotelController::class . ':editAction')
        ->setName('hotel-edit');
    $app->get('/delete[/{id: \d+}]', \Quotation\Controller\HotelController::class . ':deleteAction')
        ->setName('hotel-delete');
    $app->post('/save', \Quotation\Controller\HotelController::class . ':saveAction')
        ->setName('hotel-save');
});
