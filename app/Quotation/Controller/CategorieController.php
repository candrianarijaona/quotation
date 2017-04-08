<?php
/**
 * Created by PhpStorm.
 * User: candrianarijaona
 * Date: 08/04/2017
 * Time: 01:35
 */

namespace Quotation\Controller;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Quotation\Model\Categorie;

class CategorieController extends BaseController
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
        $this->view->render($response, 'Categorie/index.html.twig', [
            'categories' => Categorie::all(),
        ]);

        return $response;
    }
}
