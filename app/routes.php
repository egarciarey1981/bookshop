<?php

declare(strict_types=1);

use Slim\App;
use App\Actions\Book\ViewBookAction;
use App\Actions\Book\ListBooksAction;
use App\Actions\Book\CreateBookAction;
use App\Actions\Book\RemoveBookAction;
use App\Actions\Book\UpdateBookAction;
use App\Actions\Genre\CreateGenreAction;
use App\Actions\Genre\ListGenreAction;
use App\Actions\Genre\RemoveGenreAction;
use App\Actions\Genre\UpdateGenreAction;
use App\Actions\Genre\ViewGenreAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->get('/', function (Request $request, Response $response, $args) {
        $response->getBody()->write("Hello world!");
        return $response;
    });
    $app->group('/book', function (Group $group) {
        $group->get('/{id}', ViewBookAction::class);
        $group->get('', ListBooksAction::class);
        $group->post('', CreateBookAction::class);
        $group->put('/{id}', UpdateBookAction::class);
        $group->delete('/{id}', RemoveBookAction::class);
    });
    $app->group('/genre', function (Group $group) {
        $group->get('/{id}', ViewGenreAction::class);
        $group->get('', ListGenreAction::class);
        $group->post('', CreateGenreAction::class);
        $group->put('/{id}', UpdateGenreAction::class);
        $group->delete('/{id}', RemoveGenreAction::class);
    });   
};