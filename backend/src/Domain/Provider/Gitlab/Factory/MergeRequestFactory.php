<?php declare(strict_types=1);

namespace App\Domain\Provider\Gitlab\Factory;

use App\Domain\Provider\Gitlab\Model\MergeRequest;

class MergeRequestFactory
{
    public function createFromArray(array $array): MergeRequest
    {
        $requiredKeys = ['id', 'title', 'description', 'state', 'author', 'web_url'];

        foreach ($requiredKeys as $requiredKey) {
            if (!array_key_exists($requiredKey, $array)) {
                throw new \InvalidArgumentException();
            }
        }

        if (!array_key_exists('name', $array['author'])) {
            throw new \InvalidArgumentException();
        }

        return new MergeRequest(
            $array['id'],
            $array['title'],
            $array['description'],
            $array['state'],
            $array['web_url'],
            $array['author']['name']
        );
    }

    /**
     * @return MergeRequest[]
     */
    public function createFromApiResponse(array $responseData): array
    {
        $mergeRequests = [];

        foreach ($responseData as $responseItem) {
            $mergeRequests[] = $this->createFromArray($responseItem);
        }

        return $mergeRequests;
    }
}
