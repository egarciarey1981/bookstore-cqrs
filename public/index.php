<?php

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

// Instantiate PHP-DI ContainerBuilder
$containerBuilder = new ContainerBuilder();

// Set up dependencies
$dependencies = require __DIR__ . '/../app/dependencies.php';
$dependencies($containerBuilder);

// Set up repositories
$repositories = require __DIR__ . '/../app/repositories.php';
$repositories($containerBuilder);

// Set up query handlers
$queries = require __DIR__ . '/../app/queries.php';
$queries($containerBuilder);

// Set up command handlers
$commands = require __DIR__ . '/../app/commands.php';
$commands($containerBuilder);

// Set up event handlers
$eventHandlers = require __DIR__ . '/../app/events.php';
$eventHandlers($containerBuilder);

// Build PHP-DI Container instance
$container = $containerBuilder->build();

// Instantiate the app
AppFactory::setContainer($container);
$app = AppFactory::create();

// Add Body Parsing Middleware
$app->addBodyParsingMiddleware();

// Register routes
$routes = require __DIR__ . '/../app/routes.php';
$routes($app);

$app->run();
