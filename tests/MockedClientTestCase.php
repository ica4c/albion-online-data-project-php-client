<?php

declare(strict_types=1);

namespace Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use RuntimeException;

abstract class MockedClientTestCase extends TestCase
{
    /**
     * @param array<array-key, mixed> $samples
     *
     * @return Client
     */
    protected function mockClient(array $samples): Client
    {
        $mock = new MockHandler($samples);
        $handler = HandlerStack::create($mock);
        return new Client(['handler' => $handler]);
    }

    /**
     * @param string $name
     *
     * @return array<array-key, Response>
     *
     * @throws \JsonException
     */
    protected function loadResponseSamplesFromSamplesJson(string $name): array
    {
        $sample_content = file_get_contents(__DIR__ . "/samples/{$name}");

        if ($sample_content === false) {
            throw new RuntimeException('Requested sample resource not found');
        }

        /** @var array<array-key, array<array-key, mixed>> $samples */
        $samples = json_decode(
            $sample_content,
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        return array_map(
            static fn (array $content) => new Response(
                /** @phpstan-ignore-next-line */
                $content['code'] ?? 200,
                ['Content-Type' => 'application/json'],
                json_encode($content, JSON_THROW_ON_ERROR)
            ),
            $samples
        );
    }

    protected function makeSampleByResource(int $code, string $contentType, string $name): Response
    {
        $sample_content = file_get_contents(__DIR__ . "/samples/{$name}");

        if ($sample_content === false) {
            throw new RuntimeException('Requested sample resource not found');
        }

        return new Response(
            $code,
            ['Content-Type' => $contentType],
            $sample_content
        );
    }
}
