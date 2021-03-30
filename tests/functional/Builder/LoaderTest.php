<?php

namespace functional\Kiboko\Plugin\JSON\Builder;

use Kiboko\Plugin\JSON\Builder;
use Kiboko\Component\PHPUnitExtension\BuilderAssertTrait;
use PHPUnit\Framework\TestCase;
use Vfs\FileSystem;

class LoaderTest extends TestCase
{
    use BuilderAssertTrait;

    private ?FileSystem $fs = null;

    protected function setUp(): void
    {
        $this->fs = FileSystem::factory('vfs://');
        $this->fs->mount();
    }

    protected function tearDown(): void
    {
        $this->fs->unmount();
        $this->fs = null;
    }

    public function testWithoutOption()
    {
        $loader = new Builder\Loader(
            filePath: 'vfs://output.jsonld'
        );

        $this->assertBuilderProducesInstanceOf(
            'Kiboko\\Component\\Flow\\JSON\\Loader',
            $loader
        );

        $this->assertBuilderProducesPipelineLoadingLike(
            [
                ['firstname' => 'john', 'lastname' => 'doe'],
                ['firstname' => 'jean', 'lastname' => 'dupont']
            ],
            [
                ['firstname' => 'john', 'lastname' => 'doe'],
                ['firstname' => 'jean', 'lastname' => 'dupont']
            ],
            $loader
        );
    }

    public function testWithLogger()
    {
        $loader = new Builder\Loader(
            filePath: 'vfs://output.jsonld'
        );

        $this->assertBuilderProducesInstanceOf(
            'Kiboko\\Component\\Flow\\JSON\\Loader',
            $loader
        );

        $this->assertBuilderProducesPipelineLoadingLike(
            [
                ['firstname' => 'john', 'lastname' => 'doe'],
                ['firstname' => 'jean', 'lastname' => 'dupont']
            ],
            [
                ['firstname' => 'john', 'lastname' => 'doe'],
                ['firstname' => 'jean', 'lastname' => 'dupont']
            ],
            $loader
        );
    }

    public function testWritingFile()
    {
        $loader = new Builder\Loader(
            filePath: 'vfs://output.jsonld'
        );

        $this->assertBuilderProducesLoaderWritingFile(
            __DIR__.'/../files/source-to-extract.jsonld',
            [
                [
                    ['firstname' => 'john', 'lastname' => 'doe'],
                    ['firstname' => 'jean', 'lastname' => 'dupont']
                ],
                [
                    ['firstname' => 'john', 'lastname' => 'doe'],
                    ['firstname' => 'jean', 'lastname' => 'dupont']
                ]
            ],
            $loader
        );
    }
}
