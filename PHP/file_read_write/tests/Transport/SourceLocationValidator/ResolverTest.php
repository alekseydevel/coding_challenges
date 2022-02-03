<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Transport\Validator\LocalFileLocationValidator;
use Transport\Validator\SourceLocationValidatorResolver;
use Transport\Validator\UrlLocationValidator;

class ResolverTest extends TestCase
{
    public function getSchemas(): array
    {
        return [
            ['http'],
            ['https']
        ];
    }

    /**
     * @dataProvider getSchemas
     */
    public function testShouldReturnUrlLocationValidator(string $scheme)
    {
        $resolver = new SourceLocationValidatorResolver();
        $path = sprintf("%s://some-domain.com", $scheme);

        $this->assertInstanceOf(UrlLocationValidator::class, $resolver->getValidator($path));
    }

    public function getLocalPathArray(): array
    {
        return [
            ["www.some-domain.com"],
            ["./local_file"]
        ];
    }

    /**
     * @dataProvider getLocalPathArray
     */
    public function testShouldReturnLocalLocationValidator(string $path)
    {
        $resolver = new SourceLocationValidatorResolver();

        $this->assertInstanceOf(LocalFileLocationValidator::class, $resolver->getValidator($path));
    }

    public function testShouldThrowExceptionIfEmptyString()
    {
        $resolver = new SourceLocationValidatorResolver();

        $this->expectException(\InvalidArgumentException::class);

        $this->assertInstanceOf(LocalFileLocationValidator::class, $resolver->getValidator(""));
    }
}
