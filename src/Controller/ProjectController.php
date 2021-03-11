<?php

namespace App\Controller;

use App\Entity\Projects;
use App\Entity\Tasks;
use App\Form\ProjectType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends MainController
{
    /**
     * @Route("/project", name="project")
     */
    public function index(): Response
    {
        $projects = $this->em->getRepository(Projects::class)->findAll();
        $tasks = $this->em->getRepository(Tasks::class)->findAll();
        return $this->render('project/index.html.twig', [
            'projects' => $projects,
            'tasks' => $tasks
        ]);
    }

    /**
     * @Route("/project/create", name="_create")
     */
    public function create(Request $request): Response
    {
        $project = new Projects();

        $projectCreateForm = $this->createForm(ProjectType::class, $project);

        $projectCreateForm->handleRequest($request);

        if ($projectCreateForm->isSubmitted() && $projectCreateForm->isValid())
        {
            $this->em->persist($project);
            $this->em->flush();

            return $this->redirectToRoute('project');
        }

        return $this->render('project/create.html.twig',[
            'projectCreateForm' => $projectCreateForm->createView()
        ]);
    }

    /**
     * @Route(path="/project/{id}", name="_display")
     */
    public function display($id): Response
    {
        $project = $this->em->getRepository(Projects::class)->find($id);

        return $this->render('project/display.html.twig',[
            'project' => $project
        ]);
    }
}
