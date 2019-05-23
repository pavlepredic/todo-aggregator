<?php declare(strict_types=1);

namespace App\Domain\Provider\Gitlab\Model;

class MergeRequest
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $state;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $author;

    public function __construct(
        int $id,
        string $title,
        string $description,
        string $state,
        string $url,
        string $author
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->state = $state;
        $this->url = $url;
        $this->author = $author;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }
}
