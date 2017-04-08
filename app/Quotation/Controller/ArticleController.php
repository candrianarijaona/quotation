<?php

namespace Quotation\Controller;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Quotation\Model\Article;
use Quotation\Model\Categorie;

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
        $article = new Article();

        if ($request->getAttribute('id')) {
            $article = Article::find($request->getAttribute('id'));
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
     * @param $args
     *
     * @return ResponseInterface
     */
    public function saveAction(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $postedValues = $request->getParsedBody();

        $id = isset($postedValues['id_article']) ? $postedValues['id_article'] : null;

        if ($id) {
            $article = Article::find($id);
            $article->update($postedValues);
        } else {
            $article = new Article($postedValues);
            $article->save();
        }

        if ($article->getErrors()) {
            $this->view->render($response, 'Article/edit.html.twig', [
                'article' => $article,
                'categories' => Categorie::all()->sortBy('label'),
            ]);
        } else {
            $response = $this->redirect($this->get('router')->pathFor('article-list'));
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
