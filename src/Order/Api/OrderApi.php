<?php

declare(strict_types=1);

namespace App\Order\Api;

use App\Order\Domain\OrderCartId;
use App\Order\Domain\OrderId;
use App\Order\Domain\Place\PlaceOrder;
use App\Order\Domain\Purchaser;
use App\Order\Domain\StartNew\StartNewOrder;
use App\Shared\Application\Command\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

#[AsController]
#[Route(path: '/order')]
final readonly class OrderApi
{
    #[Route(path: '/checkout', methods: Request::METHOD_POST)]
    public function create(Request $request, CommandBus $commandBus): Response
    {
        try {
            $requestData = $request->toArray();
            $orderCartId = OrderCartId::create($requestData['orderCartId']);
            $orderId =  OrderId::create();

            $command = new StartNewOrder($orderId, $orderCartId);
            $commandBus->execute($command);
        } catch (Throwable $exception) {
            return new JsonResponse(sprintf('Error: %s', $exception->getMessage()), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new JsonResponse(['id' => $orderId->toString()], Response::HTTP_CREATED);
    }


    #[Route(path: '/place', methods: Request::METHOD_PUT)]
    public function place(Request $request, CommandBus $commandBus): Response
    {
        try {
            $requestData = $request->toArray();
            $orderId =  OrderId::fromString($requestData['orderId']);

            $command = new PlaceOrder(
                $orderId,
                Purchaser::create(
                    $requestData['purchaserFirstName'],
                    $requestData['purchaserLastName'],
                    $requestData['purchaserAddress']
                )
            );
            $commandBus->execute($command);
        } catch (Throwable $exception) {
            return new JsonResponse(sprintf('Error: %s', $exception->getMessage()), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new JsonResponse(status: Response::HTTP_NO_CONTENT);
    }
}