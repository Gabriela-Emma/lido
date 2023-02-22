<?php

namespace App\Actions;

use CzProject\GitPhp\IRunner;
use CzProject\GitPhp\RunnerResult;

class GitCmdRunner implements IRunner
{
    public function run($cwd, array $args, array $env = null)
    {
        // Implement the run() method to execute the Git command.
        // Return a RunnerResult object that contains the output of the command.
        // Here's an example implementation:
        $command = 'git '.implode(' ', array_map('escapeshellarg', $args));
        $descriptors = [
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
        ];
        $process = proc_open($command, $descriptors, $pipes, $cwd, $env);
        if (! is_resource($process)) {
            throw new \RuntimeException("Failed to execute Git command: $command");
        }
        $output = stream_get_contents($pipes[1]);
        fclose($pipes[1]);
        $errorOutput = stream_get_contents($pipes[2]);
        fclose($pipes[2]);
        $exitCode = proc_close($process);

        return new RunnerResult($command, $exitCode, explode("\n", $output), explode("\n", $errorOutput));
    }

    public function getCwd()
    {
        // Implement the getCwd() method to return the current working directory
        // that the Git command should be executed in.
        // For example, return '/path/to/repo'.
    }
}
