<?php declare(strict_types=1);

namespace App\Infrastructure\Entity\Gitlab;

use App\Domain\Provider\Gitlab\Model\UserConfig as UserConfigInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Infrastructure\Repository\Gitlab\UserConfigRepository")
 * @ORM\Table(name="gitlab_user_config")
 */
class UserConfig implements UserConfigInterface
{
    /**
     * @ORM\Column(type="string", length=255)
     * @ORM\Id()
     */
    private $userId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $accessToken;

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function setUserId(string $userId): void
    {
        $this->userId = $userId;
    }

    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    public function setAccessToken($accessToken): void
    {
        $this->accessToken = $accessToken;
    }
}
