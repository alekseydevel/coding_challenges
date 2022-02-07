<?php

namespace Transport\Export;

use Transport\Export\OutputDestination\Output;

class LocalJsonWriter implements Writeable
{
    private Output $output;

    public function __construct(Output $output)
    {
        $this->output = $output;
    }

    public function write(array $data): void
    {
        $tmp = [];
        // redundant foreach, but it was a preparation for key sanitizing (mentioned in Readme)
        foreach($data as $k => $v) {
            $tmp[$k] = $v;
        }

        file_put_contents($this->output->getDestination(), json_encode($tmp));
    }
}
