<?php

declare(strict_types=1);

use App\Bootstrap;
use Nette\Application\Application;

require __DIR__ . '/../vendor/autoload.php';

/** @var Application $application */
$application = Bootstrap::boot()->createContainer()->getByType(Application::class);
$application->run();
