<?php declare(strict_types=1);

namespace App\Infrastructure\Provider\Gitlab;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\ResponseInterface;

class GitlabApiClient
{
    const BASE_URL = 'https://gitlab.com';

    /**
     * @var ClientInterface
     */
    private $guzzleClient;

    public function __construct(ClientInterface $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
    }

    public function getMergeRequestsAssignedToMe(string $accessToken): array
    {
        try {
            $url = self::BASE_URL . '/api/v4/merge_requests?scope=assigned_to_me&state=opened';
            $response = $this->guzzleClient->get($url, ['headers' => $this->getHeadersWithAccessToken($accessToken)]);

            return $this->parseResponse($response);
        } catch (ClientException $e) {
            if ($e->getCode() === 401) {
                throw new UnauthorizedException();
            } else {
                throw new InvalidApiResponseException();
            }
        }
    }

    private function getHeadersWithAccessToken(string $accessToken, array $headers = []): array
    {
        $headers['Private-Token'] = $accessToken;

        return $headers;
    }

    private function parseResponse(ResponseInterface $response): array
    {
        $responseData = json_decode($response->getBody()->getContents(), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidApiResponseException();
        }

        return $responseData;
    }
}
