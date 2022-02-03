<?php

namespace Transport\Validator;

class UrlLocationValidator implements ValidSource
{
    public function validate(string $source): void
    {
        // we can perform HEAD request for example to ensure that resource exists, available and Content-Length > 0
    }
}
