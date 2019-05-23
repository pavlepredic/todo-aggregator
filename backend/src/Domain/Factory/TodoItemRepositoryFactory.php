<?php declare(strict_types=1);

namespace App\Domain\Factory;

use App\Domain\Provider\Fallback\Repository\FallbackTodoItemRepository;
use App\Domain\Provider\Gitlab\Repository\GitlabTodoItemRepository;
use App\Domain\Repository\CompositeTodoItemRepository;
use App\Domain\Repository\TodoItemRepository;

class TodoItemRepositoryFactory
{
    /**
     * @var GitlabTodoItemRepository
     */
    private $gitlabTodoItemRepository;

    public function __construct(GitlabTodoItemRepository $gitlabTodoItemRepository)
    {
        $this->gitlabTodoItemRepository = $gitlabTodoItemRepository;
    }

    public function generate(): TodoItemRepository
    {
        $compositeRepository = new CompositeTodoItemRepository();
        $compositeRepository->addComponent($this->gitlabTodoItemRepository);

        $compositeRepository->setFallback(new FallbackTodoItemRepository());

        return $compositeRepository;
    }
}
