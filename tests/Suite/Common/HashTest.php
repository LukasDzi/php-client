<?php
namespace SplitIO\Test\Suite\Common;

class HashTest extends \PHPUnit_Framework_TestCase
{

    public function testHashFunction()
    {
        $handle = fopen(__DIR__."/../../files/sample-data.csv", "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {

                $_line = explode(',', $line);

                if ($_line[0] == '#seed') {
                    continue;
                }

                $hash = \SplitIO\splitHash($_line[1], $_line[0]);
                $bucket = abs(\SplitIO\hash($_line[1], $_line[0]) % 100) + 1;

                $this->assertEquals((int)$_line[2], (int)$hash, "Hash doesn't match, Expected: ".$_line[2]." Calculated: ".$hash);

                $this->assertEquals((int)$_line[3], (int)$bucket, "Bucket doesn't match, Expected: ".
                    $_line[3]." Calculated: ".$bucket);

            }

            fclose($handle);
        } else {
            $this->assertTrue(false, "Sample Data not found");
        }

    }
}