<?php

namespace App\MessageHandler;


use App\Message\OrderConfirmationEmail;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class OrderConfirmationEmailHandler implements MessageHandlerInterface
{
    public function __invoke(OrderConfirmationEmail $email)
    {
        // Query

        // Create email

        // Send email
        echo 'Sending email now ...';

        // .. other stuff which takes long
    }
}