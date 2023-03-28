<?php

declare(strict_types=1);

namespace App\Cart\Api;

use App\Cart\Domain\AddItem\AddCartItem;
use App\Cart\Domain\CartId;
use App\Cart\Domain\CartItem;
use App\Cart\Domain\StartShopping\StartShopping;
use App\Shared\Application\Command\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

#[AsController]
#[Route(path: '/cart')]
final readonly class CartApi
{
    #[Route(path: '/start-shopping', methods: Request::METHOD_POST)]
    public function startShopping(Request $request, CommandBus $commandBus): Response
    {
        try {
            $cartId = CartId::create();
            $commandBus->execute(new StartShopping($cartId));
        } catch (Throwable $exception) {
            return new JsonResponse(sprintf('Error: %s', $exception->getMessage()), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new JsonResponse(['id' => $cartId->toString()], Response::HTTP_CREATED);
    }

    #[Route(path: '/add-item', methods: Request::METHOD_PUT)]
    public function create(Request $request, CommandBus $commandBus): Response
    {
        try {
            $requestData = $request->toArray();
            $cartId = CartId::fromString($requestData['cartId']);

            $command = new AddCartItem(
                $cartId,
                CartItem::create(
                    $requestData['itemName'],
                    $requestData['itemPrice'],
                    $requestData['itemQuantity']
                )
            );
            $commandBus->execute($command);
        } catch (Throwable $exception) {
            return new JsonResponse(sprintf('Error: %s', $exception->getMessage()), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }
}