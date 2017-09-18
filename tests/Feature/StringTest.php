<?php

namespace Tests\Feature;

use Tests\TestCase;

class StringTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_length_of_the_num()
    {

        $array = array(0 => 'blue', 1 => 'red', 2 => 'green', 3 => 'red');

        $key = array_search('green', $array); // $key = 2;
        dd($key);
        //$key = array_search('red', $array);   // $key = 1;
        $this->assertTrue(1);
    }

    /**
     * @param $x
     * @return bool
     */
    public function isPalindrome($x)
    {
        if ($x == strrev($x)) {
            return true;
        }

        return false;
    }

    public function whatOutput()
    {
        $referenceTable = array();
        $referenceTable['val1'] = array(1, 2);
        $referenceTable['val2'] = 3;
        $referenceTable['val3'] = array(4, 5);

        $testArray = array();

        $testArray = array_merge($testArray, $referenceTable['val1']);
        var_dump($testArray); // 0=>1, 1=>2
        $testArray = array_merge($testArray, $referenceTable['val2']); //
        var_dump($testArray);
        $testArray = array_merge($testArray, $referenceTable['val3']);
        var_dump($testArray);

    }
}
