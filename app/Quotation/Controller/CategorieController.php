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
        $categorie = new Categorie();

        if ($request->getAttribute('id')) {
            $categorie = Categorie::find($request->getAttribute('id'));
        }

        $this->view->render($response, 'Categorie/edit.html.twig', [
            'categorie' => $categorie,
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
    public function saveAction(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $postedValues = array_filter($request->getParsedBody());

        $id = isset($postedValues['id_categorie']) ? $postedValues['id_categorie'] : null;

        if ($id) {
            $categorie = Categorie::find($id);
            $categorie->update($postedValues);
        } else {
            $categorie = new Categorie($postedValues);
            $categorie->save();
        }

        if ($categorie->getErrors()) {
            $this->view->render($response, 'Categorie/edit.html.twig', [
                'categorie' => $categorie,
            ]);
        } else {
            $response = $this->redirect($this->get('router')->pathFor('categorie-list'));
        }

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
        $categorie = Categorie::find($request->getAttribute('id'));

        $categorie->delete();//To do check articles

        return $this->redirect($this->get('router')->pathFor('categorie-list'));
    }
}
