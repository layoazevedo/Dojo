<?php

namespace spec\Dojo;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TradutorTelefoneSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Dojo\TradutorTelefone');
    }

    function it_should_transform_a_word_into_number()
    {
    	$this->translate('test')->shouldReturn(8378);
		$this->translate('verdade')->shouldReturn(8373233);
		$this->translate('huehue')->shouldReturn(483483);
    }

    function it_should_return_false_if_input_is_not_string()
    {
		$this->translate(123)->shouldReturn(false);
		$this->translate([1,2,3])->shouldReturn(false);
    }
 }
