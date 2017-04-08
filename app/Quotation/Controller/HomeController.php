<?php

namespace Quotation\Controller;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Quotation\Model\Article;

class HomeController extends BaseController
{
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $args
     *
     * @return ResponseInterface
     */
    public function indexAction(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $this->view->render($response, 'Home/home.html.twig', [
            'articles' => Article::all(),
        ]);

        return $response;
    }
}
