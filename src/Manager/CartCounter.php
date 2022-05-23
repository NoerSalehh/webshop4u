<?php

namespace App\Manager;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartCounter
{
    public function __construct(SessionInterface $session)
    {
        $this->session = $session; //injects the sessionInterface to manipulate the current session
    }

    public function count()
    {
        $products = $this->session->get('Products', []);
//        dd($products);
        $total = 0;

        foreach ($products as $product) {
            $total += $product->getPrice() * $product->amount;
        }
        return new JsonResponse(
            [
                "status" => "200",
                "products" => $products,
                'total' => $total,

            ],
            200
        );
    }
}