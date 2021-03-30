<?php declare(strict_types=1);

namespace Kiboko\Plugin\JSON\Factory\Repository;

use Kiboko\Contract\Configurator\RepositoryInterface;
use Kiboko\Plugin\JSON;

final class Extractor implements RepositoryInterface
{
    use RepositoryTrait;

    public function __construct(private JSON\Builder\Extractor $builder)
    {
        $this->files = [];
        $this->packages = [];
    }

    public function getBuilder(): JSON\Builder\Extractor
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
