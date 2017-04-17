<?php

namespace Quotation\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Quotation\Model\Client;
use Quotation\Model\Categorie;

/**
 * Class ClientController
 * @package Quotation\Controller
 */
class ClientController extends BaseController
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
        $this->view->render($response, 'Client/index.html.twig', [
            'clients' => Client::all(),
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

        /** @var Client $client */
        $client = $id ? Client::find($id) : null;

        if ($request->isPost()) {
            $postedValues = $request->getParsedBody();

            if ($id) {
                $client->update($postedValues);
            } else {
                $client = new Client($postedValues);
                $client->save();
            }

            if (!$client->getErrors()) {
                return $this->redirect($this->get('router')->pathFor('client-list'));
            }
        }

        $this->view->render($response, 'Client/edit.html.twig', [
            'client' => $client,
            'categories' => Categorie::all()->sortBy('label'),
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
        /** @var Client $client */
        if ($client = Client::find($request->getAttribute('id'))) {
            $client->delete();
        }

        return $this->redirect($this->get('router')->pathFor('client-list'));
    }
}
