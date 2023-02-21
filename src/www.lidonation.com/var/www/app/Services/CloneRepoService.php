<?php

namespace App\Services;

use CzProject\GitPhp\Git;
use CzProject\GitPhp\GitException;
use Whoops\Exception\ErrorException;

class CloneRepoService
{
    public static string $repositoryPath;

    public static string $repositoryName;

    protected static string $git;

    /**
     * @throws ErrorException
     * @throws GitException
     */
    public static function clone($url): string
    {
        // define repository path and name
        self::$repositoryName = basename($url, '.git');
        self::$repositoryPath = storage_path('app/git-repos/'.self::$repositoryName);

        // check if repository already exists
        if (is_dir(self::$repositoryPath)) {
            throw new ErrorException('Repository already exists.');
        }

        // clone repository
        $git = new Git;
        $git->cloneRepository($url, self::$repositoryPath);

        return self::$repositoryPath;
    }

    /**
     * return repository name
     *
     * @return string
     */
    public static function repoName(): string
    {
        return self::$repositoryName;
    }
}
