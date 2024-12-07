<?php

namespace Shared\Infrastructure\Http\Slim\Action;

use Shared\Domain\Exception\InvalidDataException;
use Shared\Domain\Exception\ResourceNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;
use Shared\Application\Command\CommandBus;
use Shared\Application\Query\QueryBus;
use Throwable;

abstract class Action
{
    protected LoggerInterface $logger;
    protected Request $request;
    protected Response $response;
    protected QueryBus $queryBus;
    protected CommandBus $commandBus;

    /**
     * @var array<mixed>
     */
    protected array $args;

    public function __construct(
        LoggerInterface $logger,
        QueryBus $queryBus,
        CommandBus $commandBus,
    ) {
        $this->logger = $logger;
        $this->queryBus = $queryBus;
        $this->commandBus = $commandBus;
    }

    /**
     * @param array<mixed> $args
     */
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
            $status = 400;
            $payload = ['error' => $t->getMessage()];
        } elseif ($t instanceof ResourceNotFoundException) {
            $message = $t->getMessage();
            $status = 404;
        } else {
            $message = 'Internal Server Error';
            $status = 500;
        }

        $this->logger->error($message);

        if (null !== $payload) {
            $this->response->getBody()->write(json_encode($payload, JSON_THROW_ON_ERROR));
            $this->response = $this->response->withHeader('Content-Type', 'application/json');
        }

        return $this->response->withStatus($status);
    }

    /**
     * @return array<mixed>
     */
    protected function formData(): array
    {
        $formData = $this->request->getParsedBody();
        assert(is_array($formData));
        return $formData;
    }
}
