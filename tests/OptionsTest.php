<?php

declare(strict_types=1);

namespace Tests;

use Geocaching\Options;
use Geocaching\ClientBuilder;
use Geocaching\Enum\Environment;
use Geocaching\Plugin\GeocachingHttpLoggerPlugin;
use Http\Mock\Client;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Monolog\Logger;
use Monolog\Level;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;

class OptionsTest extends TestCase
{
    public function testConstructorCoversDefaultBaseUriMatch(): void
    {
        $mockClientBuilder = $this->getMockBuilder(ClientBuilder::class)
            ->onlyMethods(['setBaseUri', 'addPlugin'])
            ->getMock();
        $mockClientBuilder->expects($this->once())
            ->method('setBaseUri')
            ->with($this->equalTo(\Geocaching\Enum\BaseUri::PRODUCTION->value));
        $mockClientBuilder->expects($this->any())
            ->method('addPlugin');
        new Options([
            'access_token' => 'test-token',
            'client_builder' => $mockClientBuilder,
            'environment' => \Geocaching\Enum\Environment::PRODUCTION,
        ]);
        // Le test passe si setBaseUri est appelé avec la bonne valeur (branche default du match)
    }
    public function testEnableHttpLoggingWithUnknownLevelUsesDefaultInfo(): void
    {
        $clientBuilder = new ClientBuilder(new \Http\Mock\Client());
        $options = new Options([
            'access_token' => 'test-token',
            'client_builder' => $clientBuilder,
            'environment' => Environment::STAGING,
        ]);
        $options->enableHttpLogging('php://memory', 'foo'); // 'foo' est un niveau inconnu
        // Vérifie que le plugin ajouté utilise un logger avec Level::Info
        $reflection = new \ReflectionClass($clientBuilder);
        $pluginsProperty = $reflection->getProperty('plugins');
        $plugins = $pluginsProperty->getValue($clientBuilder);
        $loggerPlugin = end($plugins);
        $reflectionPlugin = new \ReflectionClass($loggerPlugin);
        $loggerProperty = $reflectionPlugin->getProperty('logger');
        $logger = $loggerProperty->getValue($loggerPlugin);
        $handlers = $logger->getHandlers();
        $handler = $handlers[0];
        $this->assertSame(\Monolog\Level::Info, $handler->getLevel());
    }

    private LoggerInterface $logger;
    private ClientBuilder $clientBuilder;
    private Options $options;

    protected function setUp(): void
    {
        parent::setUp();
        $this->logger = $this->createStub(LoggerInterface::class);
        $this->clientBuilder = new ClientBuilder(new Client());
        $this->options = new Options([
            'access_token' => 'test-token',
            'client_builder' => $this->clientBuilder,
            'environment' => Environment::STAGING,
        ]);
    }

    public function testEnableHttpLoggingAddsPluginToClientBuilder(): void
    {
        $initialPluginCount = $this->getPluginCount();
        $this->options->enableHttpLoggingWithLogger($this->logger);
        $newPluginCount = $this->getPluginCount();
        $this->assertSame($initialPluginCount + 1, $newPluginCount);
        $plugins = $this->getPlugins();
        $lastPlugin = end($plugins);
        $this->assertInstanceOf(GeocachingHttpLoggerPlugin::class, $lastPlugin);
    }

    public function testEnableHttpLoggingWithCustomParameters(): void
    {
        $this->options->enableHttpLoggingWithLogger(
            $this->logger,
            LogLevel::DEBUG,
            true,
            false,
            2000
        );
        $plugins = $this->getPlugins();
        $loggerPlugin = end($plugins);
        $this->assertInstanceOf(GeocachingHttpLoggerPlugin::class, $loggerPlugin);
        $this->assertTrue(true);
    }

    public function testEnableHttpLoggingWithDefaultParameters(): void
    {
        $this->options->enableHttpLogging();
        $plugins = $this->getPlugins();
        $loggerPlugin = end($plugins);
        $this->assertInstanceOf(GeocachingHttpLoggerPlugin::class, $loggerPlugin);
    }

    public function testMultipleLoggingPluginsCanBeAdded(): void
    {
        $logger1 = $this->createStub(LoggerInterface::class);
        $logger2 = $this->createStub(LoggerInterface::class);
        $initialCount = $this->getPluginCount();
        $this->options->enableHttpLoggingWithLogger($logger1);
        $this->options->enableHttpLoggingWithLogger($logger2);
        $finalCount = $this->getPluginCount();
        $this->assertSame($initialCount + 2, $finalCount);
        $plugins = $this->getPlugins();
        $this->assertInstanceOf(GeocachingHttpLoggerPlugin::class, $plugins[array_key_last($plugins) - 1]);
        $this->assertInstanceOf(GeocachingHttpLoggerPlugin::class, $plugins[array_key_last($plugins)]);
    }

    public function testSimpleHttpLoggingConfiguration(): void
    {
        $initialCount = $this->getPluginCount();
        $this->options->enableHttpLogging(
            'php://memory',
            LogLevel::DEBUG,
            true,
            false,
            2000
        );
        $finalCount = $this->getPluginCount();
        $this->assertSame($initialCount + 1, $finalCount);
        $plugins = $this->getPlugins();
        $loggerPlugin = end($plugins);
        $this->assertInstanceOf(GeocachingHttpLoggerPlugin::class, $loggerPlugin);
    }

    private function getPluginCount(): int
    {
        return count($this->getPlugins());
    }

    private function getPlugins(): array
    {
        $reflection = new \ReflectionClass($this->clientBuilder);
        $pluginsProperty = $reflection->getProperty('plugins');
        return $pluginsProperty->getValue($this->clientBuilder);
    }

    public function testCreateConfiguredLoggerReturnsLoggerInstance(): void
    {
        $options = $this->createStub(Options::class);
        $reflection = new \ReflectionClass($options);
        $method = $reflection->getMethod('createConfiguredLogger');
        $logger = $method->invoke($options, 'php://memory', 'info');
        $this->assertInstanceOf(Logger::class, $logger);
    }

    public function testCreateConfiguredLoggerSetsLevelAndFormat(): void
    {
        $options = $this->createStub(Options::class);
        $reflection = new \ReflectionClass($options);
        $method = $reflection->getMethod('createConfiguredLogger');
        $customFormat = '[%level_name%] %message%';
        $logger = $method->invoke($options, 'php://memory', 'error', $customFormat);
        $handlers = $logger->getHandlers();
        $this->assertNotEmpty($handlers);
        $handler = $handlers[0];
        $this->assertInstanceOf(StreamHandler::class, $handler);
        $this->assertSame(Level::Error, $handler->getLevel());
        $formatter = $handler->getFormatter();
        $this->assertInstanceOf(LineFormatter::class, $formatter);
        $reflectionFormatter = new \ReflectionClass($formatter);
        $formatProperty = $reflectionFormatter->getProperty('format');
        $this->assertSame($customFormat, $formatProperty->getValue($formatter));
    }

    public function testDefaultFormatAndLevelAreUsedWhenNotProvided(): void
    {
        $options = $this->createStub(Options::class);
        $reflection = new \ReflectionClass($options);
        $method = $reflection->getMethod('createConfiguredLogger');
        $logger = $method->invoke($options, 'php://memory', 'unknownlevel');
        $handlers = $logger->getHandlers();
        $handler = $handlers[0];
        $this->assertSame(Level::Info, $handler->getLevel());
        $formatter = $handler->getFormatter();
        $reflectionFormatter = new \ReflectionClass($formatter);
        $formatProperty = $reflectionFormatter->getProperty('format');
        $this->assertSame("[%datetime%] %channel%.%level_name%: %message% %context%\n", $formatProperty->getValue($formatter));
    }

    public function testAllPsr3LevelsAreSupported(): void
    {
        $levels = [
            'debug' => Level::Debug,
            'info' => Level::Info,
            'notice' => Level::Notice,
            'warning' => Level::Warning,
            'error' => Level::Error,
            'critical' => Level::Critical,
            'alert' => Level::Alert,
            'emergency' => Level::Emergency,
        ];
        $options = $this->createStub(Options::class);
        $reflection = new \ReflectionClass($options);
        $method = $reflection->getMethod('createConfiguredLogger');
        foreach ($levels as $levelStr => $expectedLevel) {
            $logger = $method->invoke($options, 'php://memory', $levelStr);
            $handlers = $logger->getHandlers();
            $handler = $handlers[0];
            $this->assertSame($expectedLevel->value, $handler->getLevel()->value, "Level $levelStr should map to value {$expectedLevel->value}");
        }
    }

    public function testLogFormatNullUsesDefault(): void
    {
        $options = $this->createStub(Options::class);
        $reflection = new \ReflectionClass($options);
        $method = $reflection->getMethod('createConfiguredLogger');
        $logger = $method->invoke($options, 'php://memory', 'info', null);
        $handlers = $logger->getHandlers();
        $formatter = $handlers[0]->getFormatter();
        $reflectionFormatter = new \ReflectionClass($formatter);
        $formatProperty = $reflectionFormatter->getProperty('format');
        $this->assertSame("[%datetime%] %channel%.%level_name%: %message% %context%\n", $formatProperty->getValue($formatter));
    }
}
