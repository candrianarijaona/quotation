<?php

namespace Quotation\Controller;


use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Slim\Container;

/**
 * Class BaseController
 * @package Quotation\Controller
 * @property-read Container $container
 * @property-read Logger $logger
 *
 */
class BaseController
{

    protected $container;

    protected $view;

    protected $logger;

    /**
     * BaseController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->logger = $container->get('logger');
        $this->view = $container->get('view');
    }

    /**
     * @param $id
     * @return mixed
     */
    public function get($id) {
        return $this->container->get($id);
    }

    /**
     * @param $url
     * @param int $redirectStatus
     */
    public function redirect($url, $redirectStatus = 302)
    {
        return $this->get('response')->withStatus($redirectStatus)->withHeader('Location', $url);
    }
}
