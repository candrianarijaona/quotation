<?php

namespace Quotation\Controller;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Quotation\Model\Hotel;
use Quotation\Model\Ville;

class HotelController extends BaseController
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
        $this->view->render($response, 'Hotel/index.html.twig', [
            'hotels' => Hotel::all(),
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

        /** @var Hotel $hotel */
        $hotel = $id ? Hotel::find($id) : null;

        if ($request->isPost()) {
            $postedValues = $request->getParsedBody();

            if ($id) {
                $hotel->update($postedValues);
            } else {
                $hotel = new Hotel($postedValues);
                $hotel->save();
            }

            //If no errors, go the page list
            if (!$hotel->getErrors()) {
                return $this->redirect($this->get('router')->pathFor('hotel-list'));
            }
        }

        $this->view->render($response, 'Hotel/edit.html.twig', [
            'hotel' => $hotel,
            'villes' => Ville::all()->sortBy('label'),
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
        /** @var Hotel $hotel */
        if ($hotel = Hotel::find($request->getAttribute('id'))) {
            $hotel->delete();
        }

        return $this->redirect($this->get('router')->pathFor('hotel-list'));
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $args
     *
     * @return ResponseInterface
     */
    public function loadOneAction(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        return $response->withJson([
            'hotel' => Hotel::find($request->getAttribute('id'))
        ],
            200
        );
    }
}
