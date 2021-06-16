<?php


namespace functional\Kiboko\Plugin\JSON\Builder;

use Kiboko\Plugin\JSON\Builder;
use Kiboko\Component\PHPUnitExtension\BuilderAssertTrait;
use PHPUnit\Framework\TestCase;
use Vfs\FileSystem;
use Kiboko\Plugin\Log;

class ExtractorTest extends TestCase
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
        $extractor = new Builder\Extractor(
            filePath: __DIR__.'/../files/source-to-extract.jsonld'
        );

        $this->assertBuilderProducesInstanceOf(
            'Kiboko\\Component\\Flow\\JSON\\Extractor',
            $extractor
        );

        $this->assertBuilderProducesExtractorIteratesAs(
            [
                ['firstname' => 'john', 'lastname' => 'doe'],
                ['firstname' => 'jean', 'lastname' => 'dupont']
            ],
            $extractor
        );
    }
}
