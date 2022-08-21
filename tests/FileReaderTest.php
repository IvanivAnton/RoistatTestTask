<?php

class FileReaderTest extends \PHPUnit\Framework\TestCase
{
    public function testNotExistingFile()
    {
        $notExistingFilePath = '121231231233';
        $this->expectException(Parser\Exceptions\FileNotFoundException::class);
        $this->expectExceptionMessage("No such as '$notExistingFilePath'");
        new Parser\Helpers\FileReader($notExistingFilePath);
    }

    public function testFileRead()
    {
        $testFileReader = new Parser\Helpers\FileReader(__DIR__ . '/resources/test_text.txt');
        $testText = [
            "Hello\n",
            "world\n",
            "1\n",
            "2\n",
            "3\n",
            "5\n",
        ];
        $testTextLength = count($testText);

        $i = 0;
        foreach ($testFileReader->lines() as $line) {
            if ($i >= $testTextLength) {
                break;
            }

            $this->assertEquals($testText[$i], $line);
            ++$i;
        }
    }
}
