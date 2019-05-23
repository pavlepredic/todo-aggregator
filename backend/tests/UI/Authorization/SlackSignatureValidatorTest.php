<?php declare(strict_types=1);

namespace App\Tests\UI\Authorization;

use App\UI\Authorization\SlackSignatureValidator;
use App\UI\Exception\InvalidSlackSignatureException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class SlackSignatureValidatorTest extends TestCase
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var SlackSignatureValidator
     */
    private $validator;

    protected function setUp()
    {
        parent::setUp();

        $secret = 'secret';
        $timestamp = time();
        $this->validator = new SlackSignatureValidator($secret);

        $payload = 'token=token&team_id=T123&team_domain=team&channel_id=C123';
        $payload .= '&channel_name=directmessage&user_id=U123&user_name=user&command=%2Ftodo';
        $payload .= '&text=&response_url=https%3A%2F%2Fexample.org&trigger_id=123';

        $expectedSignature = 'v0=' . hash_hmac('sha256', 'v0:' . $timestamp . ':' . $payload, $secret);
        $headers = [
            'X-Slack-Request-Timestamp' => $timestamp,
            'X-Slack-Signature' => $expectedSignature,
            'Content-Type' => 'application/x-www-form-urlencoded',
        ];

        $this->request = Request::create('', 'POST', [], [], [], [], $payload);
        $this->request->headers->add($headers);
    }

    public function testVerifyValidSignature()
    {
        $this->validator->verifySignature($this->request);

        self::assertTrue(true);
    }

    public function testVerifyInvalidSignature()
    {
        self::expectException(InvalidSlackSignatureException::class);

        $request = $this->request;
        $request->headers->set('X-Slack-Signature', 'invalid');
        $this->validator->verifySignature($request);
    }
}
