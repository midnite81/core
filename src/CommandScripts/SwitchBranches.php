<?php

declare(strict_types=1);

namespace Midnite81\Core\CommandScripts;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Midnite81\Core\Commands\Development\FireScriptsCommand;
use Midnite81\Core\Contracts\Services\ExecuteInterface;
use Midnite81\Core\Exceptions\Commands\Development\CommandFailedException;

class SwitchBranches extends AbstractCommandScript
{
    /**
     * @inheritDoc
     */
    public function handle(FireScriptsCommand $command, ExecuteInterface $execute): int
    {
        $branchName = $this->makeBranchNameFromArguments($command);
        $command->info("Parsed branch name to {$branchName}");

        if ($branchName !== null) {
            $isNewBranch = $command->askYesNoQuestion("Is {$branchName} a new branch?");
            $checkoutType = $isNewBranch ? "new" : "existing";
            $command->info("Checking out to {$checkoutType} branch {$branchName}");

            $checkoutBranch = $isNewBranch ? "-b" : "";
            $cmd = "git checkout {$checkoutBranch} {$branchName}";
            $command->info("> {$cmd}");
            $returnCode = $execute->passthru($cmd);

            if ($returnCode > 0 && $command->abortOnFailure()) {
                throw new CommandFailedException($cmd);
            }
        }

        return Command::SUCCESS;
    }

    /**
     * Make branch from arguments.
     *
     * @param Command $command
     * @return string|null
     */
    protected function makeBranchNameFromArguments(Command $command): ?string
    {
        if (count($command->arguments()['args'] ?? []) === 0) {
            return null;
        }

        $argsAsString = implode(' ', $command->arguments()['args']);
        return Str::of($argsAsString)->replace(' ', '-')->toString();
    }
}
