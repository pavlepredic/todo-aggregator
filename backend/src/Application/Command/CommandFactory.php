<?php declare(strict_types=1);

namespace App\Application\Command;

class CommandFactory
{
    /**
     * @var Command[]
     */
    private $commands;

    public function __construct(
        GetTodoList $getTodoList,
        ConfigureGitlabToken $configureGitlabToken,
        FallbackCommand $fallbackCommand
    ) {
        $this->commands = [
            $getTodoList,
            $configureGitlabToken,
            $fallbackCommand,
        ];
    }

    public function getCommandForArguments(array $args): Command
    {
        foreach ($this->commands as $command) {
            if ($command->supportsArguments($args)) {
                return $command;
            }
        }
    }
}
