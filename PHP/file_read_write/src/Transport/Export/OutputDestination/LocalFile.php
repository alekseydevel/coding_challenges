<?php

namespace Transport\Export\OutputDestination;

class LocalFile implements Output
{
    private string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function getDestination(): string
    {
        return $this->path;
    }
}
