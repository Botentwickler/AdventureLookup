<?php
declare(strict_types=1);


namespace Tests\Twig;

use AppBundle\Twig\AppExtension;
use PHPUnit\Framework\TestCase;

class AppExtensionTest extends TestCase
{
    /**
     * @var AppExtension
     */
    private $extension;

    public function setUp()
    {
        $this->extension = new AppExtension([
            [
                'domains' => ['example.com', 'example.org'],
                'param' => 'aff_id',
                'code' => 'aff_code'
            ],
            [
                'domains' => ['foo.bar'],
                'param' => 'aff_id2',
                'code' => 'aff_code2'
            ],
        ]);
    }
    /**
     * @dataProvider urlDataProvider
     */
    public function testAddAffiliateCode(string $inputUrl = null, string $expectedOutputUrl = null)
    {
        $this->assertEquals($expectedOutputUrl, $this->extension->addAffiliateCode($inputUrl));
    }

    public function urlDataProvider()
    {
        $unrelatedUrl = 'https://www.123.co.uk/foo/bar/../baz/test 123?a=abc&b= aaa&id=1000#foo-bar&x=100';

        return [
            [null, null],
            ['', ''],
            [$unrelatedUrl, $unrelatedUrl],
            ['http://example.com/foo/bar/../baz/test 123?a=abc&b= aaa&id=1000#foo-bar&x=100', 'http://example.com/foo/bar/../baz/test 123?a=abc&b= aaa&id=1000&aff_id=aff_code#foo-bar&x=100'],
            ['http://example.org/?aff_id=test', 'http://example.org/?aff_id=aff_code'],
            ['http://www.foo.bar/?aff_id=test&aff_id2=test2', 'http://www.foo.bar/?aff_id=test&aff_id2=aff_code2'],
        ];
    }
}
