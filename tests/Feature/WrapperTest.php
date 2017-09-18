<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WrapperTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function try_wrap_a_sentence()
    {
        $string = "Hello! My name is Enrique and I am enjoying this test, thanks for that! Cheeeeeeeeeeeeeeeeeeeers";
        //         0123456                   0123456     0123456
        /**
         *    Hello!
         *    My nam
         *    e is E
         *    nrique
         *    and I
         *    am enj
         *    oying
         *    this t
         *    est, t
         *    hanks
         *    for th
         *    at! Ch
         *    eeeeee
         *    eeeeee
         *    eeeeee
         *    eers
         */
        $length = 6;
        print_r($this->foo($string, $length));

        //str_split($output, $length);

        //dd($words);
    }

    /**
     * @param $s
     * @param $len
     * @return array
     */
    protected function foo($s, $len)
    {
        $r = [];
        for ($i = 0; $i < strlen($s); $i += $len) {
            $t =  ltrim(substr($s,$i, $len));//$i = 6 $t=My na -> t.len = 5
            if (strlen($t)<$len)
            {
                $k = $len - strlen($t); //$k=1
                $t .= substr($s, $i + $len, $k);
                $i += $k;
            }

            $r[] = $t;
        }

        return $r;
    }

    //
    //protected function wrap($string, $length)
    //{
    //    $r = [];
    //    for ($i = 0; $i < strlen($string); $i += $length) {
    //        $t = ltrim(substr($string, $i, $length));
    //        if (strlen($t) < $length) {
    //            $k = $length - strlen($t);//My na -> strlen=5 $k = 1
    //            $t .= substr($string, $i + $length, $k);//My na
    //            $i += $k; //
    //        }
    //        $r[] = $t."\n";
    //    }
    //
    //    return implode("", $r);
    //}
}
