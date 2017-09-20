<?php

namespace mssimi\ContentManagementBundle\ControllerRouter;

use mssimi\ContentManagementBundle\Document\Article;
use mssimi\ContentManagementBundle\Document\Blog;
use mssimi\ContentManagementBundle\Document\Page;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class RouterController extends Controller
{
    /**
     * Displays a form to edit an existing Page entity.
     *
     * @Route("{id}", name="mssimi_page_render", options={"expose" = true} , requirements={"id"="(?!\/).+"})
     * @Method({"GET"})
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function routerAction($id, Request $request)
    {
        $dm = $this->get('doctrine_phpcr')->getManager();
        $abstractPage = $dm->find(null, '/cms/page/' . rtrim($id,'/'));

        if(!$abstractPage || !$abstractPage->getPublish()){
            throw $this->createNotFoundException();
        }

        if($abstractPage instanceof Blog){
            return $this->blogAction($abstractPage, $request);
        }

        if($abstractPage instanceof Article){
            return $this->articleAction($abstractPage);
        }

        return $this->pageAction($abstractPage);
    }

    /**
     * @param $page
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function pageAction(Page $page){
        return $this->render($this->getParameter('content_management.page_template'), array(
            'page' => $page,
        ));
    }

    /**
     * @param $article
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function articleAction(Article $article){
        return $this->render($this->getParameter('content_management.article_template'), array(
            'article' => $article,
        ));
    }

    /**
     * @param Request $request
     * @param Blog $blog
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function blogAction(Blog $blog, Request $request)
    {
        $dm = $this->get('doctrine_phpcr')->getManager();
        $query = $dm->getRepository('ContentManagementBundle:Article')->pagination($request, $blog);

        $paginator  = $this->get('knp_paginator');
        $articles = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $this->getParameter('content_management.articles_per_page')
        );

        return $this->render($this->getParameter('content_management.blog_template'), array(
            'blog' => $blog,
            'articles' => $articles
        ));
    }
}
