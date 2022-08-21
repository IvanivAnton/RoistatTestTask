<?php

namespace Parser\Helpers;

use Parser\Exceptions\FileNotFoundException;

class FileReader
{
    private $file;

    /**
     * @param string $filePath
     * @throws FileNotFoundException
     */
    public function __construct(string $filePath)
    {
        try {
            $this->file = fopen($filePath, "r");
        } catch (\Throwable $throwable) {
            throw new FileNotFoundException("No such as '$filePath'");
        }
    }

    public function lines(): \Generator
    {
        while (!feof($this->file)) {
            $row = fgets($this->file, 10000);

            yield $row;
        }
    }
}
