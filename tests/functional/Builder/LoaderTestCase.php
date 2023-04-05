<?php

namespace functional\Kiboko\Plugin\JSON\Builder;

abstract class LoaderTestCase extends \PHPUnit\Framework\TestCase
{
    use \Kiboko\Component\PHPUnitExtension\BuilderAssertTrait;
    private ?\org\bovigo\vfs\vfsStreamDirectory $fs = null;
    protected function setUp(): void
    {
        $this->fs = \org\bovigo\vfs\vfsStream::setup();
    }
    protected function tearDown(): void
    {
        $this->fs = null;
        \org\bovigo\vfs\vfsStreamWrapper::unregister();
    }
    public function testWithoutOption()
    {
        $loader = new \Kiboko\Plugin\JSON\Builder\Loader(filePath: 'vfs://output.jsonld');
        $this->assertBuilderProducesInstanceOf('Kiboko\Component\Flow\JSON\Loader', $loader);
        $this->assertBuilderProducesPipelineLoadingLike([['firstname' => 'john', 'lastname' => 'doe'], ['firstname' => 'jean', 'lastname' => 'dupont']], [['firstname' => 'john', 'lastname' => 'doe'], ['firstname' => 'jean', 'lastname' => 'dupont']], $loader);
    }
    public function testWritingFile()
    {
        $loader = new \Kiboko\Plugin\JSON\Builder\Loader(filePath: 'vfs://output.jsonld');
        $this->assertBuilderProducesLoaderWritingFile(__DIR__ . '/../files/source-to-extract.jsonld', [[['firstname' => 'john', 'lastname' => 'doe'], ['firstname' => 'jean', 'lastname' => 'dupont']], [['firstname' => 'john', 'lastname' => 'doe'], ['firstname' => 'jean', 'lastname' => 'dupont']]], $loader);
    }
}
