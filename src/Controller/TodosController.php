<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TodosController extends AbstractController
{
    public function showTodos(Connection $connection)
    {
        if (isset($_GET['all']) && $_GET['all'] == '1') {
            $todos = $connection->fetchAll('SELECT t.* FROM todos t');
        } else {
            $todos = $connection->fetchAll('SELECT t.* FROM todos t WHERE completed = 0');
        }

        return $this->render('showTodos.html.twig', ['todos' => $todos]);
    }

    public function completeUncomplete(Connection $connection)
    {
        $condition = $connection->fetchAll('SELECT t.* FROM todos t WHERE id = ' . $_GET['id']);

        if ($condition[0]['completed'] == 1) {
            $connection->executeQuery('UPDATE todos SET completed = 0 WHERE id = ' . $_GET['id']);
        } else {
            $connection->executeQuery('UPDATE todos SET completed = 1 WHERE id = ' . $_GET['id']);
        }

        return $this->redirect('/symfony-refactoring-exercise/public/');
    }
}
