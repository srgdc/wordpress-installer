<?php

namespace spec\MVPDesign\WordpressInstaller;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MagicSpec extends ObjectBehavior
{
    public function getMatchers()
    {
        return [
            'haveLength' => function($subject, $length) {
                return strlen($subject) === $length;
            },
        ];
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('MVPDesign\WordpressInstaller\Magic');
    }

    function it_should_generate_a_salt()
    {
        $this->generateSalt()->shouldBeString();
    }

    function it_should_generate_a_random_salt()
    {
        $salt1 = $this->generateSalt();

        $this->generateSalt()->shouldNotBeEqualTo($salt1);
    }

    function it_should_generate_a_salt_with_the_specified_length()
    {
        $this->generateSalt(8)->shouldHaveLength(8);
        $this->generateSalt(16)->shouldHaveLength(16);
        $this->generateSalt(32)->shouldHaveLength(32);
        $this->generateSalt()->shouldHaveLength(64);
    }
}