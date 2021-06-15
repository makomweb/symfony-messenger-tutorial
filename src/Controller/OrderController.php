<?php

namespace App\Controller;


use App\Entity\Order;
use App\Message\OrderConfirmationEmail;
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
        // TODO: Create a new Order entity with status initiated + persist it!

        $order = new Order();
        $order->setName("XYZ");
        $order->setStatus("initial");

        $id = $this->repository->save($order);

        $bus->dispatch(new OrderConfirmationEmail($id));

        return $this->redirectToRoute('index');
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