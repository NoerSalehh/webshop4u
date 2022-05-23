<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderHasProduct;
use App\Entity\Product;
use App\Entity\User;
use App\Manager\CartCounter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Controller\MailController;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;


class CartController extends AbstractController

{
    private $session;
    private $em;

    public function __construct(SessionInterface $session, EntityManagerInterface $entityManager, CartCounter $cartCounter)
    {
        $this->session = $session;
        $this->em = $entityManager;
        $this->cartCounter = $cartCounter;

    }

    /**
     * @Route("/cart", name="cart")
     */
    public function index(): Response
    {
        $this->session();
        $products = $this->em->getRepository(Product::class)->findAll();

        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
            'products' => $products,
        ]);
    }

    public function session()
    {
        $this->session->set('session', 'foo');
        $foo = $this->session->get('session');
        $filters = $this->session->get('filters', []);
    }


//this will be the add function

    /**
     * @Route("/drum/{id}", name="drum")
     * @param Product $product
     * @return Response
     */
    public function add(Product $product)
    {

        $products = $this->session->get('Products', []);
//        dd(substr($_SERVER['HTTP_REFERER'], -4,-1));
//        session_destroy();

        if (isset ($products[$product->getId()])) {
            $products[$product->getId()]->amount++;
        } else {
            $product->amount = 1;
            $products[$product->getId()] = $product;//places product in the array
        }
        $this->session->set('Products', $products);
        if (substr($_SERVER['HTTP_REFERER'], -4, -1) == 'car') {
            return $this->redirectToRoute('view');
        }

        return $this->cartCounter->count();
    }


    /**
     * @Route("/view/", name="view")
     * @return Response
     */
    public function view()
    {
        $products = $this->session->get('Products', []);
//        dd($products);
        $total = 0;

        foreach ($products as $product) {
            $total += $product->getPrice() * $product->amount;
        }
        return $this->render('product/jmr.html.twig', [
            'products' => $products,
            'total' => $total,

        ]);
    }

    /**
     * @Route("/minus/{id}", name="minus")
     * @param Product $product
     * @return Response
     */
    public function minus(Product $product)
    {
        $products = $this->session->get('Products', []);

        if (isset($products[$product->getId()])) { //checkt of een variable bestaat
            $products[$product->getId()]->amount--;
            if ($products[$product->getId()]->amount == 0) {
                unset($products[$product->getId()]);
            }
        }
        $this->session->set('Products', $products);

        return $this->cartCounter->count();
    }


    // this is the payment function

    /**
     * @Route("/payment", name="payment")
     */
    public function order(Request $request)
    {
        $mailer = new MailController();

        $order = new Order();
        $builder = $this->createFormBuilder();
        $form = $builder
//            POST data for mailer
//            ->add('orderid',HiddenType::class,[
//                'data' => $order->getId()
//            ] )
            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary'],
            ])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $order->setUser($user);
            $order->setPlacedAt(new \DateTime('now'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($order);
            foreach ($this->session->get('Products') as $product) {
                $amount = $product->amount;
                $orderhasproduct = new OrderHasProduct();
                $orderhasproduct->setOrderkey($order);
                $product = $em->getRepository(Product::class)->find($product->getId());
                $orderhasproduct->setProductkey($product);;
                $orderhasproduct->setAmount($amount);
                $em->persist($orderhasproduct);
                $em->flush();
//                Mail the order
//                $mailer->mail( new \Swift_Mailer(new \Swift_SmtpTransport('smtp://5adbac5be7cbf0:330019d8eac8c5@smtp.mailtrap.io:2525?encryption=tls&auth_mode=login')) ,
//                    $order);
                $this->session->clear();
            };
            return $this->render('default/index.html.twig', [
                'order' => $order,
            ]);
        }

        return $this->render('product/thanks.html.twig', [
            'order' => $order,
            'submit' => $form->createView()
        ]);

    }

    /**
     * @Route("/history", name="history")
     */
    public function orderhistory()
    {
        $orders = $this->getUser()->getOrders();


        return $this->render('product/history.html.twig', [
            'orders' => $orders
        ]);
    }

    /**
     * @Route("/historyorder/{id}", name="historyorder")
     * @param Order $order
     * @return Response
     */
    public function orderspecific(Order $order): Response
    {
        $products = $order->getOrderHasProducts();


        return $this->render('product/historyorder.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * @Route("/discount/{code}", name="discount")
     * @return Response
     */
    public function discountcounter()
    {
        $discount = $this->session->set('code' , 'discount');


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
