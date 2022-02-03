<?php

namespace Transport\Validator;

interface ValidSource
{
    public function validate(string $source): void;
}
