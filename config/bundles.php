<?php

use Symfony\Bundle\DebugBundle\DebugBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Twig\Extra\TwigExtraBundle\TwigExtraBundle;

return [
    FrameworkBundle::class => ['all' => true],
    DebugBundle::class => ['dev' => true],
    TwigBundle::class => ['all' => true],
    TwigExtraBundle::class => ['all' => true],
];
