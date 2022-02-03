<?php

namespace Transport\Validator;

class LocalFileLocationValidator implements ValidSource
{
    public function validate(string $source): void
    {
        if(file_exists($source) && is_file($source) && is_readable($source)) {
            return;
        }

        throw new \InvalidArgumentException("Invalid local source file. Please, check if it exists and readable");
    }
}
