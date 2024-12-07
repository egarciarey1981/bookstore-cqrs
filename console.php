#!/usr/bin/env php
<?php

require __DIR__ . '/vendor/autoload.php';

use Catalog\Infrastructure\Console\Symfony\Author\CreateAuthorConsoleCommand;
use Catalog\Infrastructure\Console\Symfony\Author\DeleteAuthorConsoleCommand;
use Catalog\Infrastructure\Console\Symfony\Author\ListAuthorsConsoleCommand;
use Catalog\Infrastructure\Console\Symfony\Author\UpdateAuthorConsoleCommand;
use Catalog\Infrastructure\Console\Symfony\Author\ViewAuthorConsoleCommand;
use Catalog\Infrastructure\Console\Symfony\Book\CreateBookConsoleCommand;
use Catalog\Infrastructure\Console\Symfony\Book\DeleteBookConsoleCommand;
use Catalog\Infrastructure\Console\Symfony\Book\ListBooksConsoleCommand;
use Catalog\Infrastructure\Console\Symfony\Book\UpdateBookConsoleCommand;
use Catalog\Infrastructure\Console\Symfony\Book\ViewBookConsoleCommand;
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
$app->add($container->get(CreateAuthorConsoleCommand::class));
$app->add($container->get(DeleteAuthorConsoleCommand::class));
$app->add($container->get(ListAuthorsConsoleCommand::class));
$app->add($container->get(UpdateAuthorConsoleCommand::class));
$app->add($container->get(ViewAuthorConsoleCommand::class));

// Book
$app->add($container->get(CreateBookConsoleCommand::class));
$app->add($container->get(DeleteBookConsoleCommand::class));
$app->add($container->get(ListBooksConsoleCommand::class));
$app->add($container->get(UpdateBookConsoleCommand::class));
$app->add($container->get(ViewBookConsoleCommand::class));

$app->run();