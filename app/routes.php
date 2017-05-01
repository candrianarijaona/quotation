<?php
// Routes

$app->get('/', \Quotation\Controller\HomeController::class . ':indexAction')
    ->setName('home');

$app->group('/client', function() use ($app) {
    $app->get('/list/', \Quotation\Controller\ClientController::class . ':indexAction')
        ->setName('client-list');
    $app->map(['GET', 'POST'], '/edit/[{id: \d+}]', \Quotation\Controller\ClientController::class . ':editAction')
        ->setName('client-edit');
    $app->get('/delete/{id: \d+}', \Quotation\Controller\ClientController::class . ':deleteAction')
        ->setName('client-delete');
});

$app->group('/devis', function() use ($app) {
    $app->get('/list/', \Quotation\Controller\DevisController::class . ':indexAction')
        ->setName('devis-list');
    $app->map(['GET', 'POST'], '/edit/[{id: \d+}[/{journee: \d+}]]', \Quotation\Controller\DevisController::class . ':editAction')
        ->setName('devis-edit');
    $app->get('/delete/{id: \d+}', \Quotation\Controller\DevisController::class . ':deleteAction')
        ->setName('devis-delete');
    $app->post('/hotel/save', \Quotation\Controller\DevisController::class . ':saveHotelAction')
        ->setName('devis-hotel-save');
    //Prestation
    $app->group('/prestation', function() use ($app) {
        $app->post('/save', \Quotation\Controller\DevisController::class . ':savePrestationAction')
            ->setName('devis-prestation-save');
        $app->get('/load/{id_devis: \d+}/{journee: \d+}', \Quotation\Controller\DevisController::class . ':loadPrestationAction')
            ->setName('devis-prestation-load');
    });
});

$app->group('/article', function() use ($app) {
    $app->get('/list/', \Quotation\Controller\ArticleController::class . ':indexAction')
        ->setName('article-list');
    $app->map(['GET', 'POST'], '/edit/[{id: \d+}]', \Quotation\Controller\ArticleController::class . ':editAction')
        ->setName('article-edit');
    $app->get('/delete/{id: \d+}', \Quotation\Controller\ArticleController::class . ':deleteAction')
        ->setName('article-delete');
});

$app->group('/prestation', function() use ($app) {
    $app->get('/list/', \Quotation\Controller\PrestationController::class . ':indexAction')
        ->setName('prestation-list');
    $app->map(['POST', 'GET'], '/edit/[{id: \d+}]', \Quotation\Controller\PrestationController::class . ':editAction')
        ->setName('prestation-edit');
    $app->get('/delete/[{id: \d+}]', \Quotation\Controller\PrestationController::class . ':deleteAction')
        ->setName('prestation-delete');
});

$app->group('/categorie', function() use ($app) {
    $app->get('/list/', \Quotation\Controller\CategorieController::class . ':indexAction')
        ->setName('categorie-list');
    $app->map(['POST', 'GET'], '/edit/[{id: \d+}]', \Quotation\Controller\CategorieController::class . ':editAction')
        ->setName('categorie-edit');
    $app->get('/delete/{id: \d+}', \Quotation\Controller\CategorieController::class . ':deleteAction')
        ->setName('categorie-delete');
});

$app->group('/hotel', function() use ($app) {
    $app->get('/list', \Quotation\Controller\HotelController::class . ':indexAction')
        ->setName('hotel-list');
    $app->map(['POST', 'GET'], '/edit/[{id: \d+}]', \Quotation\Controller\HotelController::class . ':editAction')
        ->setName('hotel-edit');
    $app->get('/delete/{id: \d+}', \Quotation\Controller\HotelController::class . ':deleteAction')
        ->setName('hotel-delete');
});
