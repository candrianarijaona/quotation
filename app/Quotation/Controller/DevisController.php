<?php

namespace Quotation\Controller;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Quotation\Model\Article;
use Quotation\Model\Client;
use Quotation\Model\Devis\Devis;
use Quotation\Model\Devis\DevisArticle;
use Quotation\Model\Devis\DevisHotel;
use Quotation\Model\Devis\DevisPrestation;
use Quotation\Model\Hotel;
use Quotation\Model\Prestation;
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
            $devisHotel = DevisHotel::where(['id_devis' => $id, 'journee' => $journee])->first();
        }

        $this->view->render($response, 'Devis/edit.html.twig', [
            'devis' => $devis,
            'clients' => Client::all()->sortBy('last_name'),
            'hotels' => Hotel::all()->sortBy('label'),
            'prestations' => Prestation::all()->sortBy('label'),
            'articles' => Article::all()->sortBy('label'),
            'journee' => $journee,
            'devisHotel' => $devisHotel,
        ]);

        return $response;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $args
     * @return ResponseInterface
     */
    public function computeTotalAction(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $totalDevis = $this->get('devis')->computeTotalDevis(
            $request->getAttribute('id'),
            $request->getAttribute('journee')
        );

        return $response->withJson([
            'total' => $totalDevis,
        ],
            200
        );
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $args
     * @return ResponseInterface
     */
    public function saveHotelAction(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $postedValues = $request->getParsedBody();
        parse_str($postedValues['data'], $data);

        $postedValues = array_merge($data, ['journee' => $postedValues['journee'], 'id_devis' => $postedValues['id_devis']]);
        $postedValues = array_filter($postedValues);

        /** @var DevisHotel $devisHotel */
        $devisHotel = DevisHotel::updateOrCreate([
                'id_hotel' => $postedValues['id_hotel'],
                'journee' => $postedValues['journee'],
                'id_devis' => $postedValues['id_devis'],
            ],
            $postedValues
        );

        return $response->withJson([
                'id_devis_hotel' => $devisHotel->getAttribute('id_devis_hotel')
            ],
            200
        );
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $args
     *
     * @return ResponseInterface
     */
    public function loadPrestationAction(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $devisPrestations = DevisPrestation
            ::where([
                ['id_devis', '=', $request->getAttribute('id_devis')],
                ['journee', '=', $request->getAttribute('journee')],
            ])
            ->join('prestation', "prestation.id_prestation", '=', "devis_prestation.id_prestation")
            ->get();

        return $response->withJson([
            'devisPrestations' => $devisPrestations
        ],
            200
        );
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $args
     *
     * @return ResponseInterface
     */
    public function savePrestationAction(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $postedValues = $request->getParsedBody();
        parse_str($postedValues['data'], $data);

        $postedValues = array_merge($data, ['journee' => $postedValues['journee'], 'id_devis' => $postedValues['id_devis']]);
        $postedValues = array_filter($postedValues);

        /** @var DevisPrestation $devisPrestation */
        $devisPrestation = DevisPrestation::updateOrCreate([
            'id_prestation' => $postedValues['id_prestation'],
            'journee' => $postedValues['journee'],
            'id_devis' => $postedValues['id_devis'],
        ],
            $postedValues
        );

        return $response->withJson([
            'id_devis_prestation' => $devisPrestation->getAttribute('id_devis_prestation')
        ],
            200
        );
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $args
     *
     * @return ResponseInterface
     */
    public function loadArticleAction(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $devisArticles = DevisArticle
            ::where([
                ['id_devis', '=', $request->getAttribute('id_devis')],
                ['journee', '=', $request->getAttribute('journee')],
            ])
            ->join('article', "article.id_article", '=', "devis_article.id_article")
            ->get();

        return $response->withJson([
            'devisArticles' => $devisArticles
        ],
            200
        );
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $args
     *
     * @return ResponseInterface
     */
    public function saveArticleAction(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $postedValues = $request->getParsedBody();
        parse_str($postedValues['data'], $data);

        $postedValues = array_merge($data, ['journee' => $postedValues['journee'], 'id_devis' => $postedValues['id_devis']]);
        $postedValues = array_filter($postedValues);

        /** @var DevisArticle $devisArticle */
        $devisArticle = DevisArticle::updateOrCreate([
            'id_article' => $postedValues['id_article'],
            'journee' => $postedValues['journee'],
            'id_devis' => $postedValues['id_devis'],
        ],
            $postedValues
        );

        return $response->withJson([
            'id_devis_article' => $devisArticle->getAttribute('id_devis_article')
        ],
            200
        );
    }
}
