<?php

namespace Quotation\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Quotation\Model\Article;
use Quotation\Model\Categorie;

/**
 * Class ArticleController
 * @package Quotation\Controller
 */
class ArticleController extends BaseController
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
        $this->view->render($response, 'Article/index.html.twig', [
            'articles' => Article::all(),
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

        /** @var Article $article */
        $article = $id ? Article::find($id) : null;

        if ($request->isPost()) {
            $postedValues = $request->getParsedBody();

            if ($id) {
                $article->update($postedValues);
            } else {
                $article = new Article($postedValues);
                $article->save();
            }

            if (!$article->getErrors()) {
                return $this->redirect($this->get('router')->pathFor('article-list'));
            }
        }

        $this->view->render($response, 'Article/edit.html.twig', [
            'article' => $article,
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
        /** @var Article $article */
        if ($article = Article::find($request->getAttribute('id'))) {
            $article->delete();
        }

        return $this->redirect($this->get('router')->pathFor('article-list'));
    }
}
