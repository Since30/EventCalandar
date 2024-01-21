<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;


class TaskController extends AbstractController
{
    #[Route('/task/new', name: 'task_new')]
public function new(Request $request, EntityManagerInterface $entityManager): Response
{
    $task = new Task();
    $form = $this->createForm(TaskFormType::class, $task);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
       
        $entityManager->persist($task);
        $entityManager->flush();

        $this->addFlash('success', 'La tâche a été créée avec succès.');
        return $this->redirectToRoute('app_home');
    }

    return $this->render('task/index.html.twig', [
        'form' => $form->createView(),
    ]);
}


    #[Route('/task/new/json', name: 'task_new_json')]
    public function newJson(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $taskRepository = $entityManager->getRepository(Task::class);
        $tasks = $taskRepository->findAll();

        $data = [];
        foreach ($tasks as $task) {
            $data[] = [
                'id' => $task->getId(),
                'user' => $task->getUser()->getEmail(), // 'user' => 'email
                'title' => $task->getTitle(),
                'start' => $task->getStart()->format(\DateTimeInterface::ATOM), // Format ISO 8601
                'end' => $task->getEnd()->format(\DateTimeInterface::ATOM),
            ];
            
        }

        return new JsonResponse($data);
    }
}
