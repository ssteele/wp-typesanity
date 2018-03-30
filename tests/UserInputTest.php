<?php

namespace SteveSteele\TypeSanityTest;

use SteveSteele\TypeSanity\UserInput;

class UserInputTest extends BaseTestCase
{
    /* UserInput */
    private $userInput;

    public function setup()
    {
        $this->userInput = new UserInput();
    }

    public function testStrings()
    {
        $input = 'foo';
        $expected = 'foo';
        $this->mockWpKses($input);
        $this->assertSame($expected, $this->userInput->sanitize($input, 's'));
        $this->mockWpKses($input);
        $this->assertSame($expected, $this->userInput->sanitize($input, 'str'));
        $this->mockWpKses($input);
        $this->assertSame($expected, $this->userInput->sanitize($input, 'string'));

        $input = 'foo bar';
        $expected = 'foo bar';
        $this->mockWpKses($input);
        $this->assertSame($expected, $this->userInput->sanitize($input, 's'));

        $input = '1';
        $expected = '1';
        $this->mockWpKses($input);
        $this->assertSame($expected, $this->userInput->sanitize($input, 's'));

        $input = '0';
        $expected = '0';
        $this->mockWpKses($input);
        $this->assertSame($expected, $this->userInput->sanitize($input, 's'));

        $input = '1.2';
        $expected = '1.2';
        $this->mockWpKses($input);
        $this->assertSame($expected, $this->userInput->sanitize($input, 's'));

        $input = '0.0';
        $expected = '0.0';
        $this->mockWpKses($input);
        $this->assertSame($expected, $this->userInput->sanitize($input, 's'));

        $input = 'true';
        $expected = 'true';
        $this->mockWpKses($input);
        $this->assertSame($expected, $this->userInput->sanitize($input, 's'));

        $input = 'false';
        $expected = 'false';
        $this->mockWpKses($input);
        $this->assertSame($expected, $this->userInput->sanitize($input, 's'));

        // ...`wp_kses` converts everything to a string, so the following is expected behavior
        $input = 1;
        $expected = '1';
        $this->mockWpKses($input, '1');
        $this->assertSame($expected, $this->userInput->sanitize($input, 's'));

        $input = 0;
        $expected = '0';
        $this->mockWpKses($input, '0');
        $this->assertSame($expected, $this->userInput->sanitize($input, 's'));

        $input = 1.2;
        $expected = '1.2';
        $this->mockWpKses($input, '1.2');
        $this->assertSame($expected, $this->userInput->sanitize($input, 's'));

        $input = 0.0;
        $expected = '0.0';
        $this->mockWpKses($input, '0.0');
        $this->assertSame($expected, $this->userInput->sanitize($input, 's'));

        $input = true;
        $expected = 'true';
        $this->mockWpKses($input, 'true');
        $this->assertSame($expected, $this->userInput->sanitize($input, 's'));

        $input = false;
        $expected = 'false';
        $this->mockWpKses($input, 'false');
        $this->assertSame($expected, $this->userInput->sanitize($input, 's'));

        // `wp_kses` handles tag stripping, which is mocked for tests... just noting it's invocation here
        $input = 'foo <script>malicious</script>';
        $expected = 'foo malicious';
        $this->mockWpKses($input, 'foo malicious');
        $this->assertSame($expected, $this->userInput->sanitize($input, 's'));

        $input = 'foo <strong>bold</strong>';
        $expected = 'foo bold';
        $this->mockWpKses($input, 'foo bold');
        $this->assertSame($expected, $this->userInput->sanitize($input, 's'));
    }

    public function testIntegers()
    {
        $input = 'foo';
        $expected = '';
        $this->mockWpKses($input);
        $this->assertSame($expected, $this->userInput->sanitize($input, 'i'));

        $input = 'foo bar';
        $expected = '';
        $this->mockWpKses($input);
        $this->assertSame($expected, $this->userInput->sanitize($input, 'i'));

        $input = '1';
        $expected = '1';
        $this->mockWpKses($input);
        $this->assertSame($expected, $this->userInput->sanitize($input, 'i'));

        $input = '0';
        $expected = '0';
        $this->mockWpKses($input);
        $this->assertSame($expected, $this->userInput->sanitize($input, 'i'));

        $input = '1.2';
        $expected = '1';
        $this->mockWpKses($input);
        $this->assertSame($expected, $this->userInput->sanitize($input, 'i'));

        $input = '0.0';
        $expected = '0';
        $this->mockWpKses($input);
        $this->assertSame($expected, $this->userInput->sanitize($input, 'i'));

        $input = 'true';
        $expected = '';
        $this->mockWpKses($input);
        $this->assertSame($expected, $this->userInput->sanitize($input, 'i'));

        $input = 'false';
        $expected = '';
        $this->mockWpKses($input);
        $this->assertSame($expected, $this->userInput->sanitize($input, 'i'));

        $input = 1;
        $expected = '1';
        $this->mockWpKses($input, '1');
        $this->assertSame($expected, $this->userInput->sanitize($input, 'i'));
        $this->mockWpKses($input, '1');
        $this->assertSame($expected, $this->userInput->sanitize($input, 'int'));
        $this->mockWpKses($input, '1');
        $this->assertSame($expected, $this->userInput->sanitize($input, 'integer'));

        $input = 0;
        $expected = '0';
        $this->mockWpKses($input, '0');
        $this->assertSame($expected, $this->userInput->sanitize($input, 'i'));

        $input = 1.2;
        $expected = '1';
        $this->mockWpKses($input, '1.2');
        $this->assertSame($expected, $this->userInput->sanitize($input, 'i'));

        $input = 0.0;
        $expected = '0';
        $this->mockWpKses($input, '0.0');
        $this->assertSame($expected, $this->userInput->sanitize($input, 'i'));

        $input = true;
        $expected = '';
        $this->mockWpKses($input, 'true');
        $this->assertSame($expected, $this->userInput->sanitize($input, 'i'));

        $input = false;
        $expected = '';
        $this->mockWpKses($input, 'false');
        $this->assertSame($expected, $this->userInput->sanitize($input, 'i'));
    }

    public function testFloats()
    {
        $input = 'foo';
        $expected = '';
        $this->mockWpKses($input);
        $this->assertSame($expected, $this->userInput->sanitize($input, 'f'));

        $input = 'foo bar';
        $expected = '';
        $this->mockWpKses($input);
        $this->assertSame($expected, $this->userInput->sanitize($input, 'f'));

        $input = '1';
        $expected = '1';
        $this->mockWpKses($input);
        $this->assertSame($expected, $this->userInput->sanitize($input, 'f'));

        $input = '0';
        $expected = '0';
        $this->mockWpKses($input);
        $this->assertSame($expected, $this->userInput->sanitize($input, 'f'));

        $input = '1.2';
        $expected = '1.2';
        $this->mockWpKses($input);
        $this->assertSame($expected, $this->userInput->sanitize($input, 'f'));

        $input = '0.0';
        $expected = '0.0';
        $this->mockWpKses($input);
        $this->assertSame($expected, $this->userInput->sanitize($input, 'f'));

        $input = 'true';
        $expected = '';
        $this->mockWpKses($input);
        $this->assertSame($expected, $this->userInput->sanitize($input, 'f'));

        $input = 'false';
        $expected = '';
        $this->mockWpKses($input);
        $this->assertSame($expected, $this->userInput->sanitize($input, 'f'));

        $input = 1;
        $expected = '1';
        $this->mockWpKses($input, '1');
        $this->assertSame($expected, $this->userInput->sanitize($input, 'f'));

        $input = 0;
        $expected = '0';
        $this->mockWpKses($input, '0');
        $this->assertSame($expected, $this->userInput->sanitize($input, 'f'));

        $input = 1.2;
        $expected = '1.2';
        $this->mockWpKses($input, '1.2');
        $this->assertSame($expected, $this->userInput->sanitize($input, 'f'));
        $this->mockWpKses($input, '1.2');
        $this->assertSame($expected, $this->userInput->sanitize($input, 'float'));

        $input = 0.0;
        $expected = '0.0';
        $this->mockWpKses($input, '0.0');
        $this->assertSame($expected, $this->userInput->sanitize($input, 'f'));

        $input = true;
        $expected = '';
        $this->mockWpKses($input, 'true');
        $this->assertSame($expected, $this->userInput->sanitize($input, 'f'));

        $input = false;
        $expected = '';
        $this->mockWpKses($input, 'false');
        $this->assertSame($expected, $this->userInput->sanitize($input, 'f'));
    }
}
