<?php

namespace App\Controller;

use App\Entity\Tasks;
use App\Form\TaskType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class TaskController extends MainController
{
    /**
     * @Route("/task", name="task")
     */
    public function index(): Response
    {
        return $this->render('task/index.html.twig', [
            'controller_name' => 'TaskController',
        ]);
    }

    /**
     * @Route(path="/task/create", name="task_create")
     */
    public function create(Request $request): Response
    {
        $task = new Tasks();

        $taskCreateForm = $this->createForm(TaskType::class, $task);

        $taskCreateForm->handleRequest($request);

        if ($taskCreateForm->isSubmitted() && $taskCreateForm->isValid())
        {
            $this->em->persist($task);
            $this->em->flush();

            return $this->redirectToRoute('task');
        }

        return $this->render('task/create.html.twig',[
            'taskCreateForm' => $taskCreateForm->createView()
        ]);
    }
}
