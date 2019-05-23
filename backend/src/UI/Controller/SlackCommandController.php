<?php declare(strict_types=1);

namespace App\UI\Controller;

use App\Application\Command\CommandFactory;
use App\UI\Authorization\SlackSignatureValidator;
use App\UI\Authorization\SlackUserProvider;
use App\UI\Exception\InvalidSlackSignatureException;
use App\UI\Exception\UserNotFoundException;
use App\UI\Factory\SlackResponseFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Exception;

class SlackCommandController
{
    /**
     * @var CommandFactory
     */
    private $commandFactory;

    /**
     * @var SlackResponseFactory
     */
    private $slackResponseFactory;

    /**
     * @var SlackUserProvider
     */
    private $slackUserProvider;

    /**
     * @var SlackSignatureValidator
     */
    private $slackSignatureValidator;

    public function __construct(
        CommandFactory $commandFactory,
        SlackResponseFactory $slackResponseFactory,
        SlackUserProvider $slackUserProvider,
        SlackSignatureValidator $slackSignatureValidator
    ) {
        $this->commandFactory = $commandFactory;
        $this->slackResponseFactory = $slackResponseFactory;
        $this->slackUserProvider = $slackUserProvider;
        $this->slackSignatureValidator = $slackSignatureValidator;
    }

    public function execute(Request $request): Response
    {
        try {
            $this->slackSignatureValidator->verifySignature($request);
            $user = $this->slackUserProvider->getUserFromRequest($request);
            $text = $request->request->get('text');
            $args = $text ? preg_split('/\s+/', $text) : [];

            $command = $this->commandFactory->getCommandForArguments($args);
            $response = $command->execute($user, $args);

            return $this->slackResponseFactory->generateResponse($response);
        } catch (InvalidSlackSignatureException $e) {
            throw new AccessDeniedHttpException();
        } catch (UserNotFoundException $e) {
            throw new BadRequestHttpException();
        } catch (Exception $e) {
            $msg = 'Todo aggregator needs to rest now. No, it is not broken, where did you get that idea?';
            return $this->slackResponseFactory->generateResponse($msg);
        }
    }
}
