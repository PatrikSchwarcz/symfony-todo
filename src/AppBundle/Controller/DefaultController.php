<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Todo;
use AppBundle\Form\TodoType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function indexAction()
    {
        $todos = $this->getDoctrine()->getRepository('AppBundle:Todo')->findBy(['user' => $this->getUser()->getId()]);

        return $this->render('default/index.html.twig', compact('todos'));
    }
    
    /**
     * @Route("/todo/create", name="todo_create")
     */
    public function createAction(Request $request)
    {
        $todo = new Todo();
        $todo->setUser($this->getUser());
        $form = $this->createForm(TodoType::class, $todo);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $now = new \DateTime('now');
            $todo->setCreateDate($now)->setUpdateDate($now);

            $em = $this->getDoctrine()->getManager();
            $em->persist($todo);
            $em->flush();

            $this->addFlash('notice', 'Todo created!');

            return $this->redirectToRoute('home');
        }

        return $this->render('default/create.html.twig', [
            'form' => $form->createView()
            ]);
    }

    /**
     * @Route("/todo/details/{id}", name="todo_details")
     */
    public function detailsAction($id)
    {
        $todo = $this->getDoctrine()->getRepository('AppBundle:Todo')->findOneBy([
            'id' => $id,
            'user' => $this->getUser()->getId()
            ]);

        if (! $todo) {
            throw $this->createNotFoundException('Todo not found.');
        }

        return $this->render('default/details.html.twig', compact('todo'));
    }

    /**
     * @Route("/todo/edit/{id}", name="todo_edit")
     */
    public function editAction($id, Request $request)
    {
        $todo = $this->getDoctrine()->getRepository('AppBundle:Todo')->findOneBy([
            'id' => $id,
            'user' => $this->getUser()->getId()
            ]);

        if (! $todo) {
            throw $this->createNotFoundException('Todo not found.');
        }

        $form = $this->createForm(TodoType::class, $todo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $todo->setUpdateDate(new \DateTime('now'));

            $em->persist($todo);
            $em->flush();

            $this->addFlash('notice', 'Todo has been updated.');

            return $this->redirectToRoute('home');
        }

        return $this->render('default/edit.html.twig', [
            'todo' => $todo,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/todo/delete/{id}", name="todo_delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $todo = $em->getRepository('AppBundle:Todo')->findOneBy([
            'id' => $id,
            'user' => $this->getUser()->getId()
            ]);

        if ($todo != null) {
            $em->remove($todo);
            $em->flush();

            $this->addFlash('notice', 'Todo has been removed from your list.');
        }


        return $this->redirectToRoute('home');
    }
}
