<?php

namespace App\MessageHandler;


use App\Message\OrderPlacedMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class OrderPlacedMessageHandler implements MessageHandlerInterface
{
    public function __invoke(OrderPlacedMessage $message)
    {
        echo 'Order placed';

        // TODO: fetch entity + update status
    }
}