<?php


use Transport\Export\LocalJsonWriter;
use Transport\Export\OutputDestination\LocalFile;

class JsonProducerTest extends \PHPUnit\Framework\TestCase
{
    private string $resultFilePath = __DIR__.'/result.json';

    public function tearDown(): void
    {
        unlink($this->resultFilePath);
        parent::tearDown();
    }

    public function testShouldStoreJson()
    {
        $output = new LocalFile($this->resultFilePath);
        $writer = new LocalJsonWriter($output);

        $writer->write(['key' => 'value']);

        $this->assertEquals(['key' => 'value'], json_decode(file_get_contents($this->resultFilePath), true));
    }
}
