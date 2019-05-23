<?php declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\User;

class EmptyTodoItemRepository implements TodoItemRepository
{
    public function getTodoItems(User $user): array
    {
        return [];
    }
}
