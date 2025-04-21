<?php

namespace Midnite81\Core\Commands\Development;

use Illuminate\Console\Command;
use Midnite81\Core\CommandScripts\AbstractCommandScript;
use Midnite81\Core\CommandScripts\RunArtisanCommand;
use Midnite81\Core\Contracts\Services\ExecuteInterface;
use Midnite81\Core\Exceptions\Commands\Development\CommandFailedException;
use Midnite81\Core\Exceptions\Commands\Development\ProfileDoesNotExistException;
use Midnite81\Core\Exceptions\Commands\Development\ShortcutDoesNotExistException;
use Midnite81\Core\Exceptions\General\ClassMustInheritFromException;
use Midnite81\Core\Traits\AskYesNo;

class FireScriptsCommand extends Command
{
    use AskYesNo;

    /**
     * This will be overwritten on construct
     *
     * @var string
     */
    protected $signature = 'fire-scripts-command';

    protected $description = 'Runs predefined scripts from core-ignition config';

    /**
     * Whether the runner should abort on failure
     */
    public bool $abortOnFailure;

    /**
     * If this should be run silently
     */
    public bool $silent;

    /**
     * The array of script profiles
     */
    public array $profiles;

    /**
     * The default profile
     *
     * @var string
     */
    public mixed $defaultProfile;

    /**
     * This allows the user to define additional options in an array which can
     * be made available to any extension scripts extending AbstractCommand Script
     */
    public array $optionsArray = [];

    /**
     * The command name of this command
     */
    public string $commandName;

    public function __construct(
        protected ExecuteInterface $execute
    ) {
        $this->commandName = config('core-ignition.fire-script-command-name', 'scripts:run');
        $this->signature = "$this->commandName {args?* : This is the main argument passed to the command (used more in classes)}
                                               {--profile= : This allows you pass the profile as an option}
                                               {--shortcut= : This allows you to pass a shortcut as defined in the config}
                                               {--silent : Forces the command to run silently}
                                               {--abortOnFailure : Aborts on failure}
                                               {--options=* : This allows you to pass additional options}";

        $this->profiles = config('core-ignition.profiles', []);

        $this->defaultProfile = config('core-ignition.default-profile', 'default');

        parent::__construct();
    }

    /**
     * Handle the command
     */
    public function handle(): int
    {
        $this->abortOnFailure = $this->option('abortOnFailure')
            ?? config('core-ignition.abort-on-failure', false);

        $this->silent = $this->option('silent');

        $this->parseExtendedOptions();

        try {
            if ($this->hasOption('shortcut') && $this->option('shortcut') !== null) {
                $scriptArguments = $this->getShortcutArgs();

                return $this->call($this->commandName, $scriptArguments);
            }

            $profile = $this->hasOption('profile')
                ? $this->option('profile')
                : $this->defaultProfile;
            $scripts = $this->getProfileScripts($profile);
            $this->info("Running script profile [$profile]");

            if (!empty($scripts)) {
                foreach ($scripts as $question => $script) {
                    if ($this->isScriptClass($script, $question)) {
                        $this->executeExtensionClass($script);
                    } elseif ($this->isRunArtisanCommand($script, $question)) {
                        $this->executeArtisanClass($script);
                    } else {
                        if ($this->silent || $this->askYesNo($question)) {
                            $this->executeCommand($script);
                        }
                    }
                }
            }
        } catch (ShortcutDoesNotExistException $e) {
            $this->error("Script Key doesn't exist: {$e->getMessage()}");
        } catch (ProfileDoesNotExistException $e) {
            $this->error("Profile doesn't exist: {$e->getMessage()}");
        } catch (CommandFailedException $e) {
            $this->error("A command failed: {$e->getMessage()}");
        } catch (ClassMustInheritFromException $e) {
            $this->error("A class doesn't inherit properly: {$e->getMessage()}");
        }

        return Command::SUCCESS;
    }

    public function abortOnFailure(): bool
    {
        return $this->abortOnFailure;
    }

    /**
     * Allowed use of the yes/no asking in extended classes
     */
    public function askYesNoQuestion(string $question): bool
    {
        return $this->askYesNo($question);
    }

    /**
     * @throws ProfileDoesNotExistException
     */
    protected function getProfileScripts(string $profile): array
    {
        if (!array_key_exists($profile, $this->profiles)) {
            throw new ProfileDoesNotExistException($profile);
        }

        return $this->profiles[$profile];
    }

    /**
     * Returns the script's arguments
     *
     *
     * @throws ShortcutDoesNotExistException
     */
    protected function getShortcutArgs(): array
    {
        $shortcuts = config('core-ignition.shortcuts');
        $shortcutKey = $this->option('shortcut');

        if (!array_key_exists($shortcutKey, $shortcuts)) {
            throw new ShortcutDoesNotExistException($shortcutKey);
        }

        return $shortcuts[$shortcutKey];
    }

    protected function isScriptClass(mixed $script, int|string $question): bool
    {
        return !empty($script) &&
            (is_string($script) || $script instanceof AbstractCommandScript) &&
            is_numeric($question);
    }

    /**
     * Checks if script is an instance of RunArtisanCommand
     */
    protected function isRunArtisanCommand(mixed $script, int|string $question): bool
    {
        return !empty($script) &&
            $script instanceof RunArtisanCommand &&
            is_numeric($question);
    }

    /**
     * Execute the command(s)
     *
     *
     * @throws CommandFailedException
     */
    protected function executeCommand(string|array $commands): int
    {
        if (is_string($commands)) {
            $commands = [$commands];
        }

        foreach ($commands as $command) {
            $parsedCommand = $this->parseCommand($command);
            $this->info("> $parsedCommand");
            $resultCode = $this->execute->passthru($parsedCommand);

            if ($resultCode > 0 && $this->abortOnFailure) {
                throw new CommandFailedException($parsedCommand);
            }
        }

        return Command::SUCCESS;
    }

    /**
     * @throws ClassMustInheritFromException
     * @throws CommandFailedException
     */
    protected function executeExtensionClass(mixed $class): int
    {
        $class = is_string($class) ? new $class : $class;
        $className = $class::class;

        $this->info("> Executing $className class");

        if (!$class instanceof AbstractCommandScript) {
            throw new ClassMustInheritFromException($class, AbstractCommandScript::class);
        }

        if (!$this->silent && $class->shouldAnnounce) {
            $shouldRun = $this->askYesNo($class->message ?? "Do you want to run {$className}");

            if (!$shouldRun) {
                return Command::SUCCESS;
            }
        }

        $resultCode = $class->handle($this, $this->execute);

        if ($resultCode > 0 && $this->abortOnFailure) {
            throw new CommandFailedException($className);
        }

        return $resultCode;
    }

    /**
     * Executes an artisan command
     *
     * @param mixed $script
     *
     * @throws CommandFailedException
     */
    protected function executeArtisanClass(RunArtisanCommand $script): int
    {
        $this->info("> Executing {$script->commandSignature} artisan command");

        if (!$this->silent && $script->shouldAnnounce) {
            $shouldRun = $this->askYesNo(
                $script->message ?? "Do you wish to run artisan command $script->commandSignature?"
            );

            if (!$shouldRun) {
                return Command::SUCCESS;
            }
        }

        $resultCode = $this->call($script->commandSignature, $script->argumentsAndOptions);

        if ($resultCode > 0 && $this->abortOnFailure) {
            throw new CommandFailedException($script->commandSignature);
        }

        return $resultCode;
    }

    /**
     * Get extended option value
     *
     * @param mixed $defaultValue
     */
    public function getExtendedOption(string $key, mixed $defaultValue = null): mixed
    {
        if (array_key_exists($key, $this->optionsArray)) {
            return $this->optionsArray[$key];
        }

        return $defaultValue;
    }

    /**
     * Parses extended options
     */
    protected function parseExtendedOptions(): void
    {
        $options = $this->option('options');

        $this->optionsArray = array_reduce($options, function ($carry, $item) {
            $parts = explode('|', $item);
            $key = count($parts) > 1 ? $parts[0] : $item;
            $value = count($parts) > 1 ? $parts[1] : true;
            $carry[$key] = $value;

            return $carry;
        }, []);
    }

    /**
     * Parse the command to add arguments to numbered $ variables
     */
    protected function parseCommand(mixed $command): string
    {
        return preg_replace_callback('/\$(\d+|\*)/', function ($matches) {
            if ($matches[1] === '*') {
                return implode(' ', $this->arguments()['args']);
            }

            $index = (int) $matches[1] - 1;

            return $this->arguments()['args'][$index] ?? '';
        }, $command);
    }
}
