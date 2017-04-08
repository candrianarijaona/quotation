<?php

namespace Quotation\Controller;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Quotation\Model\Hotel;

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
            'articles' => Hotel::all(),
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
        $hotel = new Hotel();

        if ($request->getAttribute('id')) {
            $article = Hotel::find($request->getAttribute('id'));
        }

        $this->view->render($response, 'Hotel/edit.html.twig', [
            'article' => $hotel,
            'categories' => Hotel::all()->sortBy('label'),
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
        $postedValues = $request->getParsedBody();

        $id = isset($postedValues['id_hotel']) ? $postedValues['id_hotel'] : null;

        if ($id) {
            $hotel = Hotel::find($id);
            $hotel->update($postedValues);
        } else {
            $hotel = new Hotel($postedValues);
            $hotel->save();
        }

        if ($hotel->getErrors()) {
            $this->view->render($response, 'Hotel/edit.html.twig', [
                'hotel' => $hotel,
            ]);
        } else {
            $response = $this->redirect($this->get('router')->pathFor('hotel-list'));
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
        $article = Article::find($request->getAttribute('id'));

        $article->delete();

        return $this->redirect($this->get('router')->pathFor('article-list'));
    }
}
