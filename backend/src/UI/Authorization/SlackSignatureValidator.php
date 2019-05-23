<?php declare(strict_types=1);

namespace App\UI\Authorization;

use App\UI\Exception\InvalidSlackSignatureException;
use Symfony\Component\HttpFoundation\Request;

class SlackSignatureValidator
{
    const SIGNATURE_VERSION = 'v0';
    const ALLOWED_TIMESTAMP_DEVIATION = 300;

    /**
     * @var string
     */
    private $signingSecret;

    public function __construct(string $signingSecret)
    {
        $this->signingSecret = $signingSecret;
    }

    /**
     * @throws InvalidSlackSignatureException
     */
    public function verifySignature(Request $request): void
    {
        $signature = $request->headers->get('X-Slack-Signature');
        $timestamp = $request->headers->get('X-Slack-Request-Timestamp');
        $body = $request->getContent();

        if (!$signature || !$timestamp || abs(time() - $timestamp) > self::ALLOWED_TIMESTAMP_DEVIATION) {
            throw new InvalidSlackSignatureException();
        }

        $toSign = self::SIGNATURE_VERSION . ':' . $timestamp . ':' . $body;
        $computedSignature = self::SIGNATURE_VERSION . '=' . hash_hmac('sha256', $toSign, $this->signingSecret);

        if ($computedSignature !== $signature) {
            throw new InvalidSlackSignatureException();
        }
    }
}
