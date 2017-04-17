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

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $args
     *
     * @return ResponseInterface
     */
    public function editAction(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $id = $request->getAttribute('id');

        $categorie = $id ? Categorie::find($id) : null;

        if ($request->isPost()) {
            $postedValues = $request->getParsedBody();

            if ($id) {
                $categorie->update($postedValues);
            } else {
                $categorie = new Categorie($postedValues);
                $categorie->save();
            }

            //If no errors, go the page list
            if (!$categorie->getErrors()) {
                return $this->redirect($this->get('router')->pathFor('categorie-list'));
            }
        }

        $this->view->render($response, 'Categorie/edit.html.twig', [
            'categorie' => $categorie,
        ]);

        return $response;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $arg
     *
     * @return ResponseInterface
     */
    public function deleteAction(ServerRequestInterface $request, ResponseInterface $response, $arg)
    {
        /** @var Categorie $categorie */
        if ($categorie = Categorie::find($request->getAttribute('id'))) {
            $categorie->delete();
        }

        return $this->redirect($this->get('router')->pathFor('categorie-list'));
    }
}
