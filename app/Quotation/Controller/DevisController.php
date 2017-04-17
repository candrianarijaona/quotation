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

        /** @var Devis $devis */
        $devis = $id ? Devis::find($id) : null;

        if ($request->isPost()) {
            $postedValues = $request->getParsedBody();

            if ($id) {
                $devis->update($postedValues);
            } else {
                $devis = new Devis($postedValues);
                $devis->save();
            }

            if (!$devis->getErrors()) {
                return $this->redirect($this->get('router')->pathFor('devis-list'));
            }
        }

        $this->view->render($response, 'Devis/edit.html.twig', [
            'devis' => $devis,
        ]);

        return $response;
    }
}
