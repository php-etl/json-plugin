<?php declare(strict_types=1);

namespace Kiboko\Plugin\JSON;

use Kiboko\Component\Satellite\ExpressionLanguage\ExpressionLanguage;
use Kiboko\Contract\Configurator;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\Definition\Exception as Symfony;

#[Configurator\Pipeline(
    name: "json",
    dependencies: [
        'php-etl/pipeline-contracts:~0.3.0@dev',
        'php-etl/bucket-contracts:~0.1.0@dev',
        'php-etl/bucket:~0.2.0@dev',
    ],
    steps: [
        'extractor' => 'extractor',
        'loader' => 'loader',
    ],
)]
final class Service implements Configurator\PipelinePluginInterface
{
    private Processor $processor;
    private Configurator\PluginConfigurationInterface $configuration;
    private ExpressionLanguage $interpreter;

    public function __construct(
        ?ExpressionLanguage $interpreter = null,
    ) {
        $this->processor = new Processor();
        $this->configuration = new Configuration();
        $this->interpreter = $interpreter ?? new ExpressionLanguage();
    }

    public function interpreter(): ExpressionLanguage
    {
        return $this->interpreter;
    }

    public function configuration(): Configurator\PluginConfigurationInterface
    {
        return $this->configuration;
    }

    public function normalize(array $config): array
    {
        try {
            return $this->processor->processConfiguration($this->configuration, $config);
        } catch (Symfony\InvalidTypeException | Symfony\InvalidConfigurationException $exception) {
            throw new Configurator\InvalidConfigurationException($exception->getMessage(), 0, $exception);
        }
    }

    public function validate(array $config): bool
    {
        if ($this->processor->processConfiguration($this->configuration, $config)) {
            return true;
        }

        return false;
    }

    public function compile(array $config): Configurator\RepositoryInterface
    {
        try {
            if (array_key_exists('extractor', $config)) {
                $extractorFactory = new Factory\Extractor();

                return $extractorFactory->compile($config['extractor']);
            } elseif (array_key_exists('loader', $config)) {
                $loaderFactory = new Factory\Loader();

                return $loaderFactory->compile($config['loader']);
            } else {
                throw new Configurator\InvalidConfigurationException(
                    'Could not determine if the factory should build an extractor or a loader.'
                );
            }
        } catch (Symfony\InvalidConfigurationException $exception) {
            throw new Configurator\InvalidConfigurationException($exception->getMessage(), previous: $exception);
        }
    }
}
