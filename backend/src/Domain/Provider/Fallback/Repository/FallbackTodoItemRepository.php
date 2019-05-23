<?php declare(strict_types=1);

namespace App\Domain\Provider\Fallback\Repository;

use App\Domain\Model\TodoItem;
use App\Domain\Model\User;
use App\Domain\Repository\TodoItemRepository;

class FallbackTodoItemRepository implements TodoItemRepository
{
    private $todos = [
        'Nothing to do. Pat yourself on the shoulder.',
        'You did everything you were supposed to do. Well done!',
        'No tasks for you. Maybe go unload the dishwasher?',
        'There is literally nothing left for you to do. Next time work slower.',
        'I have no tasks for you. Here\'s a picture of a cat instead: http://random.cat/',
    ];

    public function getTodoItems(User $user): array
    {
        $todoText = $this->todos[array_rand($this->todos)];

        return [new TodoItem($todoText)];
    }
}
