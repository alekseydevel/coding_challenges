<?php

declare(strict_types=1);

namespace Transport\Export;

interface Writeable
{
    public function write(array $data): void;
}
