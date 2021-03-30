<?php declare(strict_types=1);


namespace Kiboko\Plugin\JSON\Factory\Repository;

use Kiboko\Contract\Configurator\RepositoryInterface;
use Kiboko\Plugin\JSON;

final class Loader implements RepositoryInterface
{
    use RepositoryTrait;

    public function __construct(private JSON\Builder\Loader $builder)
    {
    }

    public function getBuilder(): JSON\Builder\Loader
    {
        return $this->builder;
    }

    public function merge(RepositoryInterface $friend): RepositoryInterface
    {
        array_push($this->files, ...$friend->getFiles());
        array_push($this->packages, ...$friend->getPackages());

        return $this;
    }
}
