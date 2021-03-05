<?php

namespace App\Controller;

use App\Entity\Projects;
use App\Entity\Tasks;
use App\Form\TaskType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
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

    /**
     * @Route(path="/task/{taskId}/update", name="task_update")
     * @Entity("task", expr="repository.find(taskId)")
     */
    public function update(Request $request,?Projects $projects,?Tasks $task): Response {

        $updateTaskForm = $this->createForm(TaskType::class, $task);

        $updateTaskForm->handleRequest($request);

        if ($updateTaskForm->isSubmitted() && $updateTaskForm->isValid()) {
            $this->em->flush();

            return $this->redirectToRoute('project');
        }


        return $this->render('task/update.html.twig',[
            'updateTaskForm' => $updateTaskForm->createView(),
        ]
        );
    }
}
