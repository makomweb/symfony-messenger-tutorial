<?php

namespace App\Controller;


use App\OrderConfirmationEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

class OrderController extends AbstractController
{
    public function placeOrder(MessageBusInterface $bus)
    {
        $bus->dispatch(new OrderConfirmationEmail(1));

        return new Response('Your order has been placed!');
    }
}