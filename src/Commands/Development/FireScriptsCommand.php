<?php

namespace Midnite81\Core\Commands\Development;

use Illuminate\Console\Command;
use Midnite81\Core\CommandScripts\AbstractCommandScript;
use Midnite81\Core\CommandScripts\RunArtisanCommand;
use Midnite81\Core\Contracts\Services\ExecuteInterface;
use Midnite81\Core\Exceptions\Commands\Development\CommandFailedException;
use Midnite81\Core\Exceptions\Commands\Development\ProfileDoesNotExistException;
use Midnite81\Core\Exceptions\Commands\Development\ScriptShortcutDoesNotExistException;
use Midnite81\Core\Exceptions\General\ClassMustInheritFromException;
use Midnite81\Core\Traits\AskYesNo;

class FireScriptsCommand extends Command
{
    use AskYesNo;

    /**
     * This will be overwritten on construct
     * @var string
     */
    protected $signature = 'fire-scripts-command';

    protected $description = 'Runs predefined scripts from core-ignition config';

    /**
     * Whether the runner should abort on failure
     * @var bool
     */
    protected bool $abortOnFailure;

    /**
     * If this should be run silently
     *
     * @var bool
     */
    protected bool $silent;

    /**
     * The array of script profiles
     * @var array
     */
    protected array $profiles;

    /**
     * The default profile
     * @var string
     */
    protected mixed $defaultProfile;

    /**
     * This allows the user to define additional options in an array which can
     * be made available to any extension scripts extending AbstractCommand Script
     * @var array
     */
    protected array $optionsArray = [];

    /**
     * The command name of this command
     * @var string
     */
    protected string $commandName;


    public function __construct(
        protected ExecuteInterface $execute
    ) {
        $this->commandName = config('core-ignition.fire-script-command-name', 'scripts:run');
        $this->signature = "$this->commandName {args?* : This is the main argument passed to the command (used more in classes)}
                                               {--profile= : This allows you pass the profile as an option}
                                               {--script= : This allows you to pass a script shortcut as defined in the config}
                                               {--silent : Forces the command to run silently}
                                               {--abortOnFailure : Aborts on failure}
                                               {--options=* : This allows you to pass additional options}";

        $this->profiles = config('core-ignition.profiles', []);

        $this->defaultProfile = config('core-ignition.default-profile', 'default');

        parent::__construct();
    }

    /**
     * Handle the command
     *
     * @return int
     */
    public function handle(): int
    {
        $this->abortOnFailure = $this->option('abortOnFailure')
            ?? config('core-ignition.abort-on-failure', false);

        $this->silent = $this->option('silent');

        $this->parseExtendedOptions();

        try {
            if ($this->hasOption('script') && $this->option('script') !== null) {
                $scriptArguments = $this->getScriptArgs();
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
        } catch (ScriptShortcutDoesNotExistException $e) {
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

    /**
     * @return bool
     */
    public function abortOnFailure(): bool
    {
        return $this->abortOnFailure;
    }

    /**
     * Allowed use of the yes/no asking in extended classes
     *
     * @param string $question
     * @return bool
     */
    public function askYesNoQuestion(string $question): bool
    {
        return $this->askYesNo($question);
    }

    /**
     * @return bool
     */
    public function isSilent(): bool
    {
        return $this->silent;
    }

    /**
     * This allows the user to define additional options in an array which can
     * be made available to any extension scripts extending AbstractCommand Script
     *
     * @return array
     */
    public function getOptionsArray(): array
    {
        return $this->optionsArray;
    }

    /**
     * @param string $profile
     * @return array
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
     * @return array
     * @throws ScriptShortcutDoesNotExistException
     */
    protected function getScriptArgs(): array
    {
        $scripts = config('core-ignition.scripts');
        $scriptKey = $this->option('script');

        if (!array_key_exists($scriptKey, $scripts)) {
            throw new ScriptShortcutDoesNotExistException($scriptKey);
        }

        return $scripts[$scriptKey];
    }

    /**
     * @param mixed $script
     * @param int|string $question
     * @return bool
     */
    protected function isScriptClass(mixed $script, int|string $question): bool
    {
        return !empty($script) && is_string($script) && is_numeric($question);
    }

    /**
     * Checks if script is an instance of RunArtisanCommand
     *
     * @param mixed $script
     * @param int|string $question
     * @return bool
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
     * @param string|array $commands
     * @return int
     * @throws CommandFailedException
     */
    protected function executeCommand(string|array $commands): int
    {
        if (is_string($commands)) {
            $commands = [$commands];
        }

        foreach ($commands as $command) {
            $this->info("> $command");
            $resultCode = $this->execute->passthru($command);

            if ($resultCode > 0 && $this->abortOnFailure) {
                throw new CommandFailedException($command);
            }
        }

        return Command::SUCCESS;
    }

    /**
     * @param mixed $script
     * @return int
     * @throws CommandFailedException
     * @throws ClassMustInheritFromException
     */
    protected function executeExtensionClass(mixed $script): int
    {
        $this->info("> Executing $script class");
        $class = new $script($this);
        if (!$class instanceof AbstractCommandScript) {
            throw new ClassMustInheritFromException($class, AbstractCommandScript::class);
        }

        $resultCode = $class->handle($this, $this->execute);

        if ($resultCode > 0 && $this->abortOnFailure) {
            throw new CommandFailedException($script);
        }

        return $resultCode;
    }

    /**
     * Executes an artisan command
     * @param mixed $script
     * @return int
     * @throws CommandFailedException
     */
    protected function executeArtisanClass(RunArtisanCommand $script): int
    {
        $this->info("> Executing {$script->commandSignature} artisan command");

        $resultCode = $this->call($script->commandSignature, $script->argumentsAndOptions);

        if ($resultCode > 0 && $this->abortOnFailure) {
            throw new CommandFailedException($script->commandSignature);
        }

        return $resultCode;
    }

    /**
     * Parses extended options
     *
     * @return void
     */
    protected function parseExtendedOptions(): void
    {
        $options = $this->option('options');

        $this->optionsArray = array_reduce($options, function ($carry, $item) {
            $parts = explode("|", $item);
            $key = count($parts) > 1 ? $parts[0] : $item;
            $value = count($parts) > 1 ? $parts[1] : $item;
            $carry[$key] = $value;
            return $carry;
        }, []);
    }
}
