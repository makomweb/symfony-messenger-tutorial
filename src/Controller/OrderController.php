<?php

namespace App\Controller;


use App\OrderConfirmationEmail;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    private $repository;

    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/order", name="order")
     * @param MessageBusInterface $bus
     * @return Response
     */
    public function placeOrder(MessageBusInterface $bus)
    {
        $bus->dispatch(new OrderConfirmationEmail(1));

        return new Response('Your order has been placed!');
    }

    public function index()
    {
        $orders = $this->repository->findAll();

        
    }
}