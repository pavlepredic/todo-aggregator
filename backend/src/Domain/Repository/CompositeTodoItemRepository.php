<?php declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\User;

class CompositeTodoItemRepository implements TodoItemRepository
{
    /**
     * @var TodoItemRepository[]
     */
    private $components = [];

    /**
     * @var TodoItemRepository
     */
    private $fallback;

    public function __construct()
    {
        $this->fallback = new EmptyTodoItemRepository();
    }

    public function addComponent(TodoItemRepository $component): self
    {
        $this->components[] = $component;

        return $this;
    }

    public function setFallback(TodoItemRepository $fallback): self
    {
        $this->fallback = $fallback;

        return $this;
    }

    public function getTodoItems(User $user): array
    {
        $items = [];
        foreach ($this->components as $component) {
            $items = array_merge($items, $component->getTodoItems($user));
        }

        if (empty($items)) {
            $items = $this->fallback->getTodoItems($user);
        }

        return $items;
    }
}
