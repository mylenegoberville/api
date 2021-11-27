<?php

namespace App\Controller;

use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class OrderController extends AbstractController
{
    #[Route('/orders/stat', name: 'order_stat')]
    public function last10daysStat(OrderRepository $orderRepository)
    {
        $lastStat = $orderRepository->findStatOf10LastDay();

        return new Response(json_encode($lastStat));
    }


    #[Route('/orders/last', name: 'order_last')]
    public function lastOrder(OrderRepository $orderRepository)
    {
        $lastStat = $orderRepository->findLast10Order();

        return new Response(json_encode($lastStat));
    }
}
