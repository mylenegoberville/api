<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsController]
class BookController
{
    #[Route('/books/batch_delete', name:'book_batch_delete')]
    public function deleteMultipleBook(Request $request, BookRepository $bookRepository)
    {
        $ids = json_decode($request->getContent(), true)['ids'];
        $bookRepository->deleteMultipleBook($ids);

        $data = [
            'status'  => '204 Books deleted',
            'message' => 'All Books have been deleted',
        ];

        return new JsonResponse($data, 204);
    }


}
