<?php

namespace App\MessageHandler;


use App\Message\OrderPlacedMessage;
use App\Repository\OrderRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class OrderPlacedMessageHandler implements MessageHandlerInterface
{
    /**
     * @var OrderRepository
     */
    private $repository;

    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;    
    }
    
    public function __invoke(OrderPlacedMessage $message)
    {
        echo 'Order placed';

        // TODO: fetch entity + update status
    }
}