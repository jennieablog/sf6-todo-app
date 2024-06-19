<?php

namespace App\Controller;

use App\Entity\Todo;
use App\Form\Type\TodoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('', name: 'todo_home', methods: ['GET'])]
    public function homePage(): Response
    {
        return $this->render('todo/listing.html.twig');
    }

    #[Route('/new', name: 'todo_new_page', methods: ['GET'])]
    public function newPage(): Response
    {
        return $this->render('todo/new.html.twig');
    }

    #[Route('/new', name: 'todo_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        // Create the todo
        $todo = new Todo();
        $form = $this->createForm(TodoType::class, $todo);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
        $errors = [];
        foreach ($form->getErrors(true, true) as $key => $error) {
            $errors[$key] = $error->getMessage();
        }

        if (!$form->isValid()) {
            return new JsonResponse(['message' => 'Todo failed to update!', 'errors' => $errors], Response::HTTP_BAD_REQUEST);
        }

        $this->entityManager->persist($todo);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Todo updated!']);
    }

    #[Route('/todos', name: 'todo_listing', methods: ['GET'])]
    public function listing(): JsonResponse
    {
        $todos = $this->entityManager->getRepository(Todo::class)->findAll();

        // Serialize todos to JSON
        $rows = [];
        foreach ($todos as $todo) {
            $rows[] = [
                'id' => $todo->getId(),
                'title' => $todo->getTitle(),
                'completed' => $todo->isCompleted(),
            ];
        }

        return new JsonResponse([
            'rows' => $rows,
            'count' => count($rows),
        ]);
    }

    #[Route('todos/{id}', name: 'todo_details', requirements: ['id' => "\d+"], methods: ['GET'])]
    public function details(Request $request, $id): Response
    {
        $isEditing = $request->query->get('isEditing');
        $todo = $this->entityManager->getRepository(Todo::class)->find($id);

        if (!$todo) {
            throw $this->createNotFoundException('Todo not found');
        }

        return $this->render($isEditing ? 'todo/update.html.twig' : 'todo/details.html.twig', [
            'todo' => $todo,
        ]);
    }

    #[Route('todos/{id}', name: 'todo_update', requirements: ['id' => "\d+"], methods: ['PUT'])]
    public function update(Request $request, $id): JsonResponse
    {
        $todo = $this->entityManager->getRepository(Todo::class)->find($id);

        if (!$todo) {
            return new JsonResponse(['message' => 'Todo not found!'], Response::HTTP_NOT_FOUND);
        }

        // Update the todo
        $form = $this->createForm(TodoType::class, $todo);
        $data = json_decode($request->getContent(), true);

        $form->submit($data);
        $errors = [];
        foreach ($form->getErrors(true, true) as $key => $error) {
            $errors[$key] = $error->getMessage();
        }

        if (!$form->isValid()) {
            return new JsonResponse(['message' => 'Todo failed to update!', 'errors' => $errors], Response::HTTP_BAD_REQUEST);
        }

        $this->entityManager->persist($todo);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Todo updated!']);
    }

    #[Route('todos/{id}/complete', name: 'todo_complete', requirements: ['id' => "\d+"], methods: ['GET', 'PUT'])]
    public function complete(Request $request, $id): JsonResponse
    {
        $todo = $this->entityManager->getRepository(Todo::class)->find($id);

        if (!$todo) {
            return new JsonResponse(['message' => 'Todo not found!'], Response::HTTP_NOT_FOUND);
        }

        // Complete todo
        $data = json_decode($request->getContent(), true);
        $todo->setCompleted($data['completed']);

        $this->entityManager->persist($todo);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Todo updated!']);
    }

    #[Route('todos/{id}/delete', name: 'todo_delete', requirements: ['id' => "\d+"], methods: ['DELETE'])]
    public function delete(Request $request, $id): JsonResponse
    {
        $todo = $this->entityManager->getRepository(Todo::class)->find($id);

        if (!$todo) {
            return new JsonResponse(['message' => 'Todo not found!'], Response::HTTP_NOT_FOUND);
        }

        // Delete todo
        $this->entityManager->remove($todo);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Todo updated!']);
    }
}
