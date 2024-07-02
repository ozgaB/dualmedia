<?php

declare(strict_types=1);

namespace App\Controller;


use App\Entity\Order;
use App\Entity\Product;
use App\Form\Type\OrderType;
use App\Utils\PriceCalculator;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Class OrderController.
 */
#[Route('/order', name: 'order_')]
class OrderController extends AbstractController
{
    #[Route('/create', name: 'create', methods: ['POST'])]
    public function create(
        EntityManagerInterface $manager,
        PriceCalculator $priceCalculator,
        Request $request
    ): JsonResponse
    {
        $order = new Order();
        $form = $this->createForm(OrderType::class, $order);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if (false === $form->isValid()) {
            $errors = $this->getFormErrors($form);
            return $this->json($errors, Response::HTTP_BAD_REQUEST);
        }

        try {
            $manager->beginTransaction();

            $productsAmount = 0;
            foreach ($order->getOrderProducts() as $orderProduct) {
                $order->addOrderProduct($orderProduct);
                $productsAmount += $orderProduct->getQuantity();
            }

            $priceCalculator->calculate($order);
            $order->setProductsAmount($productsAmount);
            $manager->persist($order);
            $manager->flush();
            $manager->commit();
            return $this->json($order, 200, [], ['groups' => 'order-create']);
        } catch (\Exception $exception){
            $manager->rollback();
            return $this->json($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/show/{order}', name: 'show', methods: ['GET'])]
    public function show(Order $order): JsonResponse
    {
        return $this->json($order, 200, [], ['groups' => 'order-show']);
    }

    private function getFormErrors(FormInterface $form): array
    {
        $errors = [];
        foreach ($form->getErrors(true) as $error) {
            $errors[] = $error->getMessage();
        }

        return $errors;
    }
}