<?php

namespace Quotation\Controller;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Quotation\Model\Prestation;
use Slim\Http\Request;
use Slim\Http\Response;


class PrestationController extends BaseController
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
        $this->view->render($response, 'Prestation/index.html.twig', [
            'prestations' => Prestation::all(),
        ]);

        return $response;
    }

    /**
     * @param ServerRequestInterface|Request $request
     * @param ResponseInterface|Response $response
     * @param $args
     *
     * @return ResponseInterface
     */
    public function editAction(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $id = $request->getAttribute('id');
        /** @var Prestation $prestation */
        $prestation = $id ? Prestation::find($id) : null;

        if ($request->isPost()) {
            $postedValues = $request->getParsedBody();

            if ($id) {
                $prestation->update($postedValues);
            } else {
                $prestation = new Prestation($postedValues);
                $prestation->save();
            }

            //If no errors, go the page list
            if (!$prestation->getErrors()) {
                return $this->redirect($this->get('router')->pathFor('prestation-list'));
            }
        }

        $this->view->render($response, 'Prestation/edit.html.twig', [
            'prestation' => $prestation,
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
        /** @var Prestation $prestation */
        if ($prestation = Prestation::find($request->getAttribute('id'))) {
            $prestation->delete();
        }

        return $this->redirect($this->get('router')->pathFor('prestation-list'));
    }
}
