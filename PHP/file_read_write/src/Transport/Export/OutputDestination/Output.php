<?php
declare(strict_types=1);

namespace Transport\Export\OutputDestination;

interface Output
{
    public function getDestination(): string;
}
