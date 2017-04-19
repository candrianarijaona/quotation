<?php

namespace Quotation\Controller;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Quotation\Model\Client;
use Quotation\Model\Devis\Devis;
use Quotation\Model\Devis\DevisHotel;
use Quotation\Model\Hotel;
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
            'allDevis' => Devis::all(),
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
        $journee = $request->getAttribute('journee') ?: 1;

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
        }

        $devisHotel = null;
        if ($id) {
            $devisHotel = DevisHotel::where(['id_devis' => $id, 'journee' => $journee]);
        }

        $this->view->render($response, 'Devis/edit.html.twig', [
            'devis' => $devis,
            'clients' => Client::all()->sortBy('last_name'),
            'hotels' => Hotel::all()->sortBy('label'),
            'journee' => $journee,
            'devisHotel' => $devisHotel,
        ]);

        return $response;
    }
}
