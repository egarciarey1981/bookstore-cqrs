<?php

namespace Bookstore\Shared\Infrastructure\Http\Slim\Action;

use Bookstore\Shared\Domain\Exception\ResourceNotFoundException;
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
        } catch (ResourceNotFoundException $e) {
            $this->logger->error($e->getMessage(), $e->getContext());
            return $this->response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(404);
        } catch (Throwable $t) {
            $this->logger->error($t->getMessage());
            return $this->response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(500);
        }
        die('como');
    }

    abstract protected function action(): Response;
}
