<?php

namespace Shared\Infrastructure\Http\Slim\Action;

use Shared\Domain\Exception\InvalidDataException;
use Shared\Domain\Exception\ResourceNotFoundException;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;
use Throwable;

abstract class Action
{
    protected LoggerInterface $logger;
    protected Request $request;
    protected Response $response;
    protected array $args;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $this->request = $request;
        $this->response = $response;
        $this->args = $args;

        try {
            return $this->action();
        } catch (Throwable $t) {
            return $this->handlerException($t);
        }
    }

    abstract protected function action(): Response;

    private function handlerException(Throwable $t): Response
    {
        $message = '';
        $context = [];
        $status = null;
        $payload = null;

        if ($t instanceof InvalidDataException) {
            $message = $t->getMessage();
            $context = $t->getContext();
            $status = 400;
            $payload = ['error' => $t->getMessage()];
        } elseif ($t instanceof ResourceNotFoundException) {
            $message = $t->getMessage();
            $context = $t->getContext();
            $status = 404;
        } else {
            $message = 'Internal Server Error';
            $status = 500;
        }

        $this->logger->error($message, $context);

        if (null !== $payload) {
            $this->response->getBody()->write(json_encode($payload));
            $this->response = $this->response->withHeader('Content-Type', 'application/json');
        }

        return $this->response->withStatus($status);
    }
}
