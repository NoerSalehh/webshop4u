<?php

namespace App\Controller;

use App\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailController extends AbstractController
{
    /**
     * @Route("/mailorder", name="mailorder")
     * @param MailerInterface $mailer
     * @param Order $order
     * @return Response
     */
    public function mail(\Swift_Mailer $mailer , Order $order)
    {
        $user = $this->getUser();
//        $lennart = new \Swift_Mailer()

        $message = (new \Swift_Message('Hello'))
            ->setFrom('lennartderidder@gmail.com')
            ->setTo('info.lennartderidder@gmail.com')
            ->setBody(
                $this->renderView(
                    'mail/index.html.twig', [
                        'user' => $user,
                        'order' => $order,
                    ]
                )
            );

        $mailer->send($message);
    }
}
