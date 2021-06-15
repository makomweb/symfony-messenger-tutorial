<?php

namespace App\MessageHandler;


use App\Message\OrderPlacedMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class OrderPlacedMessageHandler implements MessageHandlerInterface
{
    public function __invoke(OrderPlacedMessage $message)
    {
        // Query

        // Create email

        // Send email
        echo 'Sending email now ...';

        // .. other stuff which takes long
    }
}