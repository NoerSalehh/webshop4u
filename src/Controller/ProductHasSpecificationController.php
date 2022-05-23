<?php

namespace App\Controller;

use App\Entity\ProductHasSpecification;
use App\Form\ProductHasSpecificationType;
use App\Repository\ProductHasSpecificationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/productspecification")
 */
class ProductHasSpecificationController extends AbstractController
{
    /**
     * @Route("/", name="product_has_specification_index", methods={"GET"})
     */
    public function index(ProductHasSpecificationRepository $productHasSpecificationRepository): Response
    {
        return $this->render('product_has_specification/index.html.twig', [
            'product_has_specifications' => $productHasSpecificationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="product_has_specification_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $productHasSpecification = new ProductHasSpecification();
        $form = $this->createForm(ProductHasSpecificationType::class, $productHasSpecification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($productHasSpecification);
            $entityManager->flush();

            return $this->redirectToRoute('product_has_specification_index');
        }

        return $this->render('product_has_specification/new.html.twig', [
            'product_has_specification' => $productHasSpecification,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="product_has_specification_show", methods={"GET"})
     */
    public function show(ProductHasSpecification $productHasSpecification): Response
    {
        return $this->render('product_has_specification/show.html.twig', [
            'product_has_specification' => $productHasSpecification,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="product_has_specification_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ProductHasSpecification $productHasSpecification): Response
    {
        $form = $this->createForm(ProductHasSpecificationType::class, $productHasSpecification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('product_has_specification_index');
        }

        return $this->render('product_has_specification/edit.html.twig', [
            'product_has_specification' => $productHasSpecification,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="product_has_specification_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ProductHasSpecification $productHasSpecification): Response
    {
        if ($this->isCsrfTokenValid('delete'.$productHasSpecification->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($productHasSpecification);
            $entityManager->flush();
        }

        return $this->redirectToRoute('product_has_specification_index');
    }
}
