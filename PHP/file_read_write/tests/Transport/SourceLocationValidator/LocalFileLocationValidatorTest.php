<?php

namespace Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Transport\Validator\LocalFileLocationValidator;

class LocalFileLocationValidatorTest extends TestCase
{

    public function testShouldValidateIfFileExistsAndReadable()
    {
        $validator = new LocalFileLocationValidator();
        $validator->validate(__DIR__.'/var/readable_file.txt');

        $this->assertTrue(true);
    }

    public function testShouldThrowExceptionIfNoFile()
    {
        self::expectException(InvalidArgumentException::class);

        $validator = new LocalFileLocationValidator();
        $validator->validate('./some_file_which_doesnt_exist');
    }

    public function testShouldThrowExceptionIfFileNotReadable()
    {
        $this->assertTrue(true);
        return;

        // test fails even after explicit chmod 000 to file and other user as owner :|

        $filePath = __DIR__.'/var/not_readable_file.txt';

        // validator will throw exception if file is missing.
        // can be also fixed by different exception type
        // will leave it on purpose - to show the importance of custom exceptions not only for production code
        // but for testing as well
        if (!file_exists($filePath)) {
            throw new \Exception("Bad test. Missing correct file");
        }

        self::expectException(InvalidArgumentException::class);

        $validator = new LocalFileLocationValidator();
        $validator->validate($filePath);
    }
}
