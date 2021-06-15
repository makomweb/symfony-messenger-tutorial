<?php

namespace App\Controller;


use App\Entity\Order;
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
    public function placeOrder(MessageBusInterface $bus) : Response
    {
        $bus->dispatch(new OrderConfirmationEmail(1));

        // TODO: Create a new Order entity with status initiated + persist it!

        $order = new Order();
        $order->setName("XYZ");
        $order->setStatus("initial");

        $this->repository->save($order);
        return new Response('Your order has been placed!');
    }

    /**
     * @Route("/index", name="index")
     */
    public function index() : Response
    {
        $orders = $this->repository->findAll();

        return $this->render('Order/index.html.twig', [
            'orders' => $orders,
        ]);
    }
}