<?php

declare(strict_types=1);

namespace Midnite81\Core\Traits;

trait AskYesNo
{
    /**
     * @param  string  $question
     * @return bool
     */
    protected function askYesNo(string $question): bool
    {
        $response = '';
        $pattern = '/(^[Yy](ES|es)??$)|(^[Nn]([Oo])??$)/';
        $count = 0;
        while (!preg_match($pattern, $response)) {
            $askQuestion = $count > 0 ? 'RE-ASKING ' . $question : $question;
            $response = $this->ask($askQuestion);
            $count++;
        }

        if (preg_match('/^[Yy](ES|es)??$/', $response)) {
            return true;
        }

        return false;
    }
}
