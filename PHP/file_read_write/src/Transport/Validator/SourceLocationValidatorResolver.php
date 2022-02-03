<?php

declare(strict_types=1);

namespace Transport\Validator;

final class SourceLocationValidatorResolver
{
    public function getValidator(string $path): ValidSource
    {
        if (empty($path)) {
            throw new \InvalidArgumentException("Path is required");
        }

        $data = parse_url($path);

        if (!empty($data['scheme']) && in_array($data['scheme'], ['http', 'https'])) {
            return new UrlLocationValidator($path);
        }

        return new LocalFileLocationValidator($path);
    }
}
