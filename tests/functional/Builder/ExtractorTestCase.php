<?php

namespace functional\Kiboko\Plugin\JSON\Builder;

abstract class ExtractorTestCase extends \PHPUnit\Framework\TestCase
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
        $extractor = new \Kiboko\Plugin\JSON\Builder\Extractor(filePath: __DIR__ . '/../files/source-to-extract.jsonld');
        $this->assertBuilderProducesInstanceOf('Kiboko\Component\Flow\JSON\Extractor', $extractor);
        $this->assertBuilderProducesExtractorIteratesAs([['firstname' => 'john', 'lastname' => 'doe'], ['firstname' => 'jean', 'lastname' => 'dupont']], $extractor);
    }
}
