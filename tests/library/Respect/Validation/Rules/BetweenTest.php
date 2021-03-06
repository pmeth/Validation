<?php

namespace Respect\Validation\Rules;

use Respect\Validation\Validator;
use \DateTime;

class BetweenTest extends \PHPUnit_Framework_TestCase
{

    public function providerValid()
    {
        return array(
            array(0, 1, true, 0),
            array(0, 1, true, 1),
            array(10, 20, false, 15),
            array(10, 20, true, 20),
            array(-10, 20, false, -5),
            array(-10, 20, false, 0),
            array('a', 'z', false, 'j'),
            array(
                new DateTime('yesterday'),
                new DateTime('tomorrow'),
                false,
                new DateTime('now')
            ),
        );
    }

    public function providerInvalid()
    {
        return array(
            array(0, 1, false, 0),
            array(0, 1, false, 1),
            array(0, 1, false, 2),
            array(0, 1, false, -1),
            array(10, 20, false, 999),
            array(10, 20, false, 20),
            array(-10, 20, false, -11),
            array('a', 'j', false, 'z'),
            array(
                new DateTime('yesterday'),
                new DateTime('now'),
                false,
                new DateTime('tomorrow')
            ),
        );
    }

    /**
     * @dataProvider providerValid
     */
    public function test_values_between_bounds_should_pass($min, $max, $inclusive, $input)
    {
        $o = new Between($min, $max, $inclusive);
        $this->assertTrue($o->validate($input));
        $this->assertTrue($o->assert($input));
        $this->assertTrue($o->check($input));
    }

    /**
     * @dataProvider providerInvalid
     * @expectedException Respect\Validation\Exceptions\BetweenException
     */
    public function test_values_out_bounds_should_raise_exception($min, $max, $inclusive, $input)
    {
        $o = new Between($min, $max, $inclusive);
        $this->assertFalse($o->validate($input));
        $this->assertFalse($o->assert($input));
    }
    
    /**
     * @expectedException Respect\Validation\Exceptions\ComponentException
     */
    public function test_invalid_construction_params_should_raise_exception()
    {
        $o = new Between(10, 5);
    }

}