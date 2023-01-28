<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;

class GenerateMnemonicPhraseController extends Controller
{
    public function generate()
    {
        $process = static::processCommand(['/opt/cardano-wallet', 'recovery-phrase', 'generate']);
        $process->run();

        return explode(' ', str_replace(["\r", "\n"], '', $process->getOutput()));
    }
    
    protected static function processCommand(array|string $command, $fromShell = false): Process
    {
        if ($fromShell) {
            if (is_array($command)) {
                $command = implode(' ', $command);
            }

            return ['data'=>Process::fromShellCommandline($command)];
        }

        return new Process($command);
    }
}
