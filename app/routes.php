<?php
// Routes

$app->get('/', \Quotation\Controller\HomeController::class . ':indexAction')
    ->setName('homepage');
