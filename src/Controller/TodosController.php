<?php

namespace App\Controller;

use App\Entity\Todos;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TodosController extends AbstractController
{
    public function showTodos($all)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository(Todos::class);

        (int)$all === 1
            ? $todos = $repository->findAll()
            : $todos = $repository->findBy(
                ['completed' => 0]
            );

        return $this->render('showTodos.html.twig', ['todos' => $todos]);
    }

    public function updateTodo($id, $completed)
    {
        (int)$completed === 0 ? $completed = 1 : $completed = 0;

        $this->getDoctrine()->getManager()
        ->getRepository(Todos::class)
            ->updateById($id, $completed);

        return $this->redirect('/');
    }
}
