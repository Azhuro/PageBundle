<?php

namespace Azhuro\Bundle\PageBundle\Controller;

use PageBundle\Manager\PageManager;
use PageBundle\Model\Interfaces\PageInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

/**
 * Page controller.
 */
class PageController extends Controller
{
    /**
     * Lists all Page entities.
     */
    public function indexAction()
    {
        return $this->render('PageBundle:Page:index.html.twig', array(
            'pages' => $this->getPageManager()->findPages(),
        ));
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $page = $this->getPageManager()->createPage();

        $form = $this->createForm('page_type', $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($page);
            $em->flush();

            return $this->redirectToRoute('page_show', array('id' => $page->getId()));
        }

        return $this->render('PageBundle:Page:new.html.twig', array(
            'page' => $page,
            'form' => $form->createView(),
        ));
    }

    /**
     * @param $id
     * @return Response
     */
    public function showAction($id)
    {
        $page = $this->getPageManager()->findPageBy(['id' => $id]);

        if (!$page instanceof PageInterface) {
            throw new NotFoundResourceException(sprintf('Page with id %s not found', $id));
        }

        $deleteForm = $this->createDeleteForm($page);

        return $this->render('PageBundle:Page:show.html.twig', array(
            'page' => $page,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, $id)
    {
        $page = $this->getPageManager()->findPageBy(['id' => $id]);

        if (!$page instanceof PageInterface) {
            throw new NotFoundResourceException(sprintf('Page with id %s not found', $id));
        }

        $deleteForm = $this->createDeleteForm($page);
        $editForm = $this->createForm('page_type', $page);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($page);
            $em->flush();

            return $this->redirectToRoute('page_edit', array('id' => $page->getId()));
        }

        return $this->render('PageBundle:Page:edit.html.twig', array(
            'page' => $page,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, $id)
    {
        $page = $this->getPageManager()->findPageBy(['id' => $id]);

        if (!$page instanceof PageInterface) {
            throw new NotFoundResourceException(sprintf('Page with id %s not found', $id));
        }

        $form = $this->createDeleteForm($page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($page);
            $em->flush();
        }

        return $this->redirectToRoute('page_index');
    }

    /**
     * Creates a form to delete a Page entity.
     *
     * @param PageInterface $page The Page entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PageInterface $page)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('page_delete', array('id' => $page->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    /**
     * @param PageInterface $page
     * @return Response
     */
    public function homepageAction(PageInterface $page)
    {
        return $this->render('PageBundle:Index:homepage.html.twig', array(
            'page' => $page
        ));
    }

    /**
     * @return PageManager
     */
    protected function getPageManager()
    {
        return $this->container->get('page.manager.page_manager');
    }
}
