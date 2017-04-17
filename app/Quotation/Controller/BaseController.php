<?php

namespace Quotation\Controller;


use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Container;
use Slim\Views\Twig;

/**
 * Class BaseController
 * @package Quotation\Controller
 */
class BaseController
{
    /** @var ContainerInterface */
    protected $container;

    /** @var Twig */
    protected $view;

    /** @var Logger */
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
     *
     * @return ResponseInterface
     */
    public function redirect($url, $redirectStatus = 302)
    {
        return $this->get('response')->withStatus($redirectStatus)->withHeader('Location', $url);
    }
}
