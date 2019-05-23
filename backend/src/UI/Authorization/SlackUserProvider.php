<?php declare(strict_types=1);

namespace App\UI\Authorization;

use App\Domain\Model\User;
use App\UI\Exception\UserNotFoundException;
use Symfony\Component\HttpFoundation\Request;

class SlackUserProvider
{
    /**
     * @throws UserNotFoundException
     */
    public function getUserFromRequest(Request $request): User
    {
        $userId = $request->request->get('user_id');
        $userName = $request->request->get('user_name');

        if ($userId === null) {
            throw new UserNotFoundException();
        }

        return new User($userId, $userName);
    }
}
