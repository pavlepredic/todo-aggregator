<?php declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\TodoItem;
use App\Domain\Model\User;

interface TodoItemRepository
{
    /**
     * @return TodoItem[]
     */
    public function getTodoItems(User $user): array;
}
