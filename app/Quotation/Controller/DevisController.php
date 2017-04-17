<?php

namespace Quotation\Controller;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Quotation\Model\Devis;
use Slim\Http\Request;
use Slim\Http\Response;

class DevisController extends BaseController
{

    /**
     * @param ServerRequestInterface|Request $request
     * @param ResponseInterface|Response $response
     * @param $args
     *
     * @return ResponseInterface
     */
    public function indexAction(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $this->view->render($response, 'Devis/index.html.twig', [
            'articles' => Devis::all(),
        ]);

        return $response;
    }
}
