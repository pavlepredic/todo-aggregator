<?php declare(strict_types=1);

namespace App\Tests\Domain\Repository;

use App\Domain\Model\TodoItem;
use App\Domain\Model\User;
use App\Domain\Repository\CompositeTodoItemRepository;
use App\Domain\Repository\EmptyTodoItemRepository;
use App\Domain\Repository\TodoItemRepository;
use PHPUnit\Framework\TestCase;

class CompositeTodoItemRepositoryTest extends TestCase
{
    /**
     * @var TodoItemRepository
     */
    private $firstRepositoryWithItems;

    /**
     * @var TodoItemRepository
     */
    private $secondRepositoryWithItems;

    /**
     * @var TodoItemRepository
     */
    private $repositoryWithoutItems;

    /**
     * @var CompositeTodoItemRepository
     */
    private $compositeRepository;

    protected function setUp()
    {
        parent::setUp();

        $this->firstRepositoryWithItems = new class implements TodoItemRepository {
            public function getTodoItems(User $user): array
            {
                return [new TodoItem('first item')];
            }
        };

        $this->secondRepositoryWithItems = new class implements TodoItemRepository {
            public function getTodoItems(User $user): array
            {
                return [new TodoItem('second item')];
            }
        };

        $this->repositoryWithoutItems = new EmptyTodoItemRepository();

        $this->compositeRepository = new CompositeTodoItemRepository();
    }

    public function testEmptyRepositoryWithoutFallback()
    {
        $this->compositeRepository->addComponent($this->repositoryWithoutItems);
        $items = $this->compositeRepository->getTodoItems(new User('1', ''));

        self::assertEmpty($items);
    }

    public function testEmptyRepositoryWithFallback()
    {
        $this->compositeRepository->addComponent($this->repositoryWithoutItems);
        $this->compositeRepository->setFallback($this->firstRepositoryWithItems);
        $items = $this->compositeRepository->getTodoItems(new User('1', ''));

        self::assertCount(1, $items);
    }

    public function testMultipleRepositories()
    {
        $this->compositeRepository
            ->addComponent($this->firstRepositoryWithItems)
            ->addComponent($this->secondRepositoryWithItems)
        ;

        $items = $this->compositeRepository->getTodoItems(new User('1', ''));

        self::assertCount(2, $items);
        self::assertSame('first item', $items[0]->getText());
        self::assertSame('second item', $items[1]->getText());
    }
}
