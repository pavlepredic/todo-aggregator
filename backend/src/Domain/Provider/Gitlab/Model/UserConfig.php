<?php declare(strict_types=1);

namespace App\Domain\Provider\Gitlab\Model;

interface UserConfig
{
    public function getUserId(): string;
    public function setUserId(string $userId): void;
    public function getAccessToken(): ?string;
    public function setAccessToken(string $accessToken): void;
}
