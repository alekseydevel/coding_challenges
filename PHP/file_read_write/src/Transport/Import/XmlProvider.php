<?php

namespace Transport\Import;

use SimpleXMLElement;
use XMLReader;

class XmlProvider implements Readable
{
    const DATA_ELEMENT = 'item';

    public function read(string $path): array
    {
        $xml = new XMLReader();
        $xml->open('compress.zlib://'.$path);

        // skip all irrelevant nodes
        while($xml->read() && $xml->name != self::DATA_ELEMENT) {
            ;
        }

        $data = [];
        $i = 0;

        try {
            while($xml->name == self::DATA_ELEMENT)
            {
                if($xml->name != self::DATA_ELEMENT) {
                    continue;
                }
                $dataString = $xml->readOuterXml();

                $element = new SimpleXMLElement($dataString);

                $tmp = [];
                foreach((array) $element->children() as $key => $val) {
                    $tmp[trim((string) $key)] = trim((string) $val);
                }
                $data[] = $tmp;

                $xml->next(self::DATA_ELEMENT);
                $i++;
            }
        } finally {
            $xml->close();
        }

        return $data;
    }
}
