<?php declare(strict_types=1);

namespace App\Domain\Provider\Gitlab\Repository;

use App\Domain\Model\TodoItem;
use App\Domain\Model\User;
use App\Domain\Provider\Gitlab\Factory\MergeRequestFactory;
use App\Domain\Provider\Gitlab\Model\MergeRequest;
use App\Domain\Repository\TodoItemRepository;
use App\Infrastructure\Provider\Gitlab\GitlabApiClient;
use App\Infrastructure\Provider\Gitlab\UnauthorizedException;
use App\Infrastructure\Repository\Gitlab\UserConfigRepository;

class GitlabTodoItemRepository implements TodoItemRepository
{
    /**
     * @var MergeRequestFactory
     */
    private $mergeRequestFactory;

    /**
     * @var GitlabApiClient
     */
    private $gitlabApiClient;

    /**
     * @var UserConfigRepository
     */
    private $userConfigRepository;

    public function __construct(
        MergeRequestFactory $mergeRequestFactory,
        GitlabApiClient $gitlabApiClient,
        UserConfigRepository $userConfigRepository
    ) {
        $this->mergeRequestFactory = $mergeRequestFactory;
        $this->gitlabApiClient = $gitlabApiClient;
        $this->userConfigRepository = $userConfigRepository;
    }

    public function getTodoItems(User $user): array
    {
        $userConfig = $this->userConfigRepository->getConfigForUser($user);
        if (!$userConfig || empty($userConfig->getAccessToken())) {
            return [$this->createTodoItemToSetUpAccessToken()];
        }

        try {
            $responseData = $this->gitlabApiClient->getMergeRequestsAssignedToMe($userConfig->getAccessToken());
            $mergeRequests = $this->mergeRequestFactory->createFromApiResponse($responseData);
            $todoItems = [];
            foreach ($mergeRequests as $mergeRequest) {
                $todoItems[] = $this->createTodoItemFromMergeRequest($mergeRequest);
            }

            return $todoItems;
        } catch (UnauthorizedException $e) {
            return [$this->createTodoItemToSetUpAccessToken()];
        }
    }

    private function createTodoItemToSetUpAccessToken(): TodoItem
    {
        $url = GitlabApiClient::BASE_URL . '/profile/personal_access_tokens';
        $text = 'Set up your gitlab access token by typing /todo configure gitlab token <token>. ';
        $text .= 'To obtain a personal access token, visit : ' . $url;

        return new TodoItem($text);
    }

    private function createTodoItemFromMergeRequest(MergeRequest $mergeRequest): TodoItem
    {
        $text = sprintf(
            'Review merge request "%s" created by %s: %s',
            $mergeRequest->getTitle(),
            $mergeRequest->getAuthor(),
            $mergeRequest->getUrl()
        );

        return new TodoItem($text);
    }
}
