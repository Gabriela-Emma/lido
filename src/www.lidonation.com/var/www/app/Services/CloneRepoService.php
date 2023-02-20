<?php

namespace App\Services;

use CzProject\GitPhp\Git;
use Whoops\Exception\ErrorException;


class CloneRepoService
{   
    public static $repositoryPath;

    public static $repositoryName;

    protected static $git;

    public static function clone($url)
    {
        // define repository path and name
        self::$repositoryName = basename($url, ".git");
        self::$repositoryPath = storage_path("app/repo/".self::$repositoryName);


        // check if repository already exists
        if (is_dir(self::$repositoryPath)) {
            throw new ErrorException('Repository already exists.');
        }

        // clone repository
        $git = new Git;
        $git->cloneRepository($url, self::$repositoryPath);

        return self::$repositoryPath;
    }

    public static function repoName()
    {
        // return repository name
        return self::$repositoryName;
    }
}