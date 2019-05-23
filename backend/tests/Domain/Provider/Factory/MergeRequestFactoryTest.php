<?php declare(strict_types=1);

namespace App\Tests\Domain\Provider\Factory;

use App\Domain\Provider\Gitlab\Factory\MergeRequestFactory;
use PHPUnit\Framework\TestCase;

class MergeRequestFactoryTest extends TestCase
{
    /**
     * @var MergeRequestFactory
     */
    private $factory;

    protected function setUp()
    {
        parent::setUp();

        $this->factory = new MergeRequestFactory();
    }

    public function testCreateFromArray()
    {
        $array = [
            'id' => 1940,
            'iid' => 1,
            'project_id' => 74,
            'title' => 'Update README.md',
            'description' => 'Description',
            'state' => 'opened',
            'created_at' => '2019-03-14T13:12:31.196Z',
            'updated_at' => '2019-03-14T13:12:39.378Z',
            'merged_by' => null,
            'merged_at' => null,
            'closed_by' => null,
            'closed_at' => null,
            'target_branch' => 'master',
            'source_branch' => 'test-mr',
            'upvotes' => 0,
            'downvotes' => 0,
            'author' => [
                'id' => 55,
                'name' => 'Pavle Predic',
                'username' => 'ppredic',
                'state' => 'active',
                'avatar_url' => 'https://git.example.org/uploads/-/system/user/avatar/55/avatar.png',
                'web_url' => 'https://git.example.org/ppredic'
            ],
            'assignee' => [
                'id' => 55,
                'name' => 'Pavle Predic',
                'username' => 'ppredic',
                'state' => 'active',
                'avatar_url' => 'https://git.example.org/uploads/-/system/user/avatar/55/avatar.png',
                'web_url' => 'https://git.example.org/ppredic'
            ],
            'source_project_id' => 74,
            'target_project_id' => 74,
            'labels' => [],
            'work_in_progress' => false,
            'milestone' => null,
            'merge_when_pipeline_succeeds' => false,
            'merge_status' => 'can_be_merged',
            'sha' => '877ed71af8a9ad95545435181e12c8e39158d347',
            'merge_commit_sha' => null,
            'user_notes_count' => 0,
            'discussion_locked' => null,
            'should_remove_source_branch' => null,
            'force_remove_source_branch' => false,
            'web_url' => 'https://git.example.org/acme/todo-aggregator/merge_requests/1',
            'time_stats' => [
                'time_estimate' => 0,
                'total_time_spent' => 0,
                'human_time_estimate' => null,
                'human_total_time_spent' => null
            ],
            'squash' => false
        ];

        $mergeRequest = $this->factory->createFromArray($array);

        self::assertSame(1940, $mergeRequest->getId());
        self::assertSame('Pavle Predic', $mergeRequest->getAuthor());
        self::assertSame('Update README.md', $mergeRequest->getTitle());
        self::assertSame('Description', $mergeRequest->getDescription());
        self::assertSame('opened', $mergeRequest->getState());
        self::assertSame('https://git.example.org/acme/todo-aggregator/merge_requests/1', $mergeRequest->getUrl());
    }
}
