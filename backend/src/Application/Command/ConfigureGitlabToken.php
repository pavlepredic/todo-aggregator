<?php declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Model\User;
use App\Domain\Provider\Gitlab\Service\GitlabTokenService;

class ConfigureGitlabToken implements Command
{
    /**
     * @var GitlabTokenService
     */
    private $gitlabTokenService;

    public function __construct(GitlabTokenService $gitlabTokenService)
    {
        $this->gitlabTokenService = $gitlabTokenService;
    }

    public function execute(User $user, array $args = []): string
    {
        $token = $this->getTokenFromArguments($args);
        if (empty($token)) {
            return 'No token provided';
        }

        $this->gitlabTokenService->configureTokenForUser($token, $user);

        return 'Gitlab token configured';
    }

    public function supportsArguments(array $args): bool
    {
        return
            count($args) === 4 &&
            $args[0] === 'configure' &&
            $args[1] === 'gitlab' &&
            $args[2] === 'token';
    }

    private function getTokenFromArguments(array $args): ?string
    {
        foreach ($args as $i => $arg) {
            if ($arg === 'token' && isset($args[$i + 1])) {
                return $args[$i + 1];
            }
        }
    }
}
