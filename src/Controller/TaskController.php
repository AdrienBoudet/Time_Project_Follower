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
    public function index(Request $request): Response
    {
        $start = $request->get('s');
        $end = $request->get('e');

        $tasks = $this->em->getRepository(Tasks::class)->findByDateRange($start, $end);
        return $this->render('task/index.html.twig',[
            'tasks' => $tasks,
            'start' => $start,
            'end' => $end,
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
     * @Route(path="/task/{id}/update", name="task_update")
     */
    public function update(Tasks $tasks, Request $request)
    {

        $updateTaskForm = $this->createForm(TaskType::class, $tasks);

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

    /**
     * @Route(path="task/{id}/delete", name="task_delete")
     */
    public function delete(Tasks $tasks)
    {
        $this->em->remove($tasks);
        $this->em->flush();
        return $this->redirectToRoute('project');
    }

    /**
     * @Route(path="task/{id}/invoice", name="task_invoice")
     */
    public function invoice(Tasks $tasks)
    {
        $em = $this->getDoctrine()->getManager();
        $tasks->setIsInvoiced(true);
        $em->flush();
        return $this->redirectToRoute('task');
    }
}
