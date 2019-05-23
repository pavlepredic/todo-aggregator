<?php declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Model\TodoItem;
use App\Domain\Model\User;
use App\Domain\Repository\TodoItemRepository;

class GetTodoList implements Command
{
    /**
     * @var TodoItemRepository
     */
    private $repository;

    public function __construct(TodoItemRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(User $user, array $args = []): string
    {
        $items = $this->repository->getTodoItems($user);
        $texts = array_map(function (TodoItem $item) {
            return $item->getText();
        }, $items);


        return join("\n", $texts);
    }

    public function supportsArguments(array $args): bool
    {
        return count($args) === 0;
    }
}
