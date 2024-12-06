#!/usr/bin/env php
<?php

require __DIR__ . '/vendor/autoload.php';

use Catalog\Infrastructure\Console\Symfony\Author\ViewAuthorCommand;
use Catalog\Infrastructure\Console\Symfony\Book\ViewBookCommand;
use DI\ContainerBuilder;
use Symfony\Component\Console\Application;

$containerBuilder = new ContainerBuilder();

// Set up dependencies
$dependencies = require __DIR__ . '/app/dependencies.php';
$dependencies($containerBuilder);

// Set up repositories
$repositories = require __DIR__ . '/app/repositories.php';
$repositories($containerBuilder);

// Set up query handlers
$queries = require __DIR__ . '/app/queries.php';
$queries($containerBuilder);

// Set up command handlers
$commands = require __DIR__ . '/app/commands.php';
$commands($containerBuilder);

// Set up event handlers
$eventHandlers = require __DIR__ . '/app/events.php';
$eventHandlers($containerBuilder);

$container = $containerBuilder->build();

// Instantiate the app
$app = new Application();

// Author
$app->add($container->get(ViewAuthorCommand::class));

// Book
$app->add($container->get(ViewBookCommand::class));

$app->run();