<?php declare(strict_types=1);

use Psr\Container\ContainerInterface;

function container(): ContainerInterface
{
    return \Hyperf\Utils\ApplicationContext::getContainer();
}
