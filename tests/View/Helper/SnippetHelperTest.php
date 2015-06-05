<?php
namespace HangerSnippetTest\View\Helper;

use HangerSnippet\View\Helper\SnippetHelper;
use Zend\View\Renderer\PhpRenderer;

/**
 * Class SnippetHelperTest
 */
class SnippetHelperTest extends \PHPUnit_Framework_TestCase
{

    /**
     * The Helper
     * @var \HangerSnippet\View\Helper\SnippetHelper
     */
    public $helper;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->helper = new SnippetHelper();
        $view = new PhpRenderer();
        $view->resolver()->addPath(__DIR__ . '/../../../view');
        $view->resolver()->addPath(__DIR__ . '/_files/modules');
        $this->helper->setView($view);
    }

    /**
     * {@inheritdoc}
     */
    public function tearDown()
    {
        unset($this->helper);
    }

    /**
     * Test Append Snippet
     */
    public function testAppendSnippet()
    {
        $this->helper->appendSnippet('appended', 'hanger-snippet/test', ['foo' => 'ABC']);
        $this->assertCount(1, $this->helper->getSnippets());
        $this->assertCount(1, $this->helper->getEnabledSnippets());
        $this->assertEmpty($this->helper->getDisabledSnippets());
    }

    /**
     * Test Append Snippet
     */
    public function testAppendSnippetWithPlacement()
    {
        $this->helper->appendSnippet('appended', 'hanger-snippet/test', ['foo' => 'ABC'], 'example');
        $this->assertCount(1, $this->helper->getSnippets());
    }

    /**
     * Test Enable Snippet
     */
    public function testEnableSnippet()
    {
        $this->helper->appendSnippet('test', 'hanger-snippet/test', ['foo' => 'ABC']);
        $this->helper->setEnabled('test');
        $this->assertArrayHasKey('test', $this->helper->getEnabledSnippets());
    }

    /**
     * Test Enable All Snippets
     */
    public function testEnableAllSnippets()
    {
        foreach ($this->snippetsProvider() as $snippet) {
            $this->helper->appendSnippet($snippet[0], $snippet[1], $snippet[2]);
        }
        $this->helper->setEnableAll();


        foreach ($this->snippetsProvider() as $snippet) {
            $this->assertArrayHasKey($snippet[0], $this->helper->getEnabledSnippets());
            $this->assertArrayNotHasKey($snippet[0], $this->helper->getDisabledSnippets());
        }
    }

    /**
     * Test Disable All Snippets
     */
    public function testDisableAllSnippets()
    {
        foreach ($this->snippetsProvider() as $snippet) {
            $this->helper->appendSnippet($snippet[0], $snippet[1], $snippet[2]);
        }
        $this->helper->setDisableAll();


        foreach ($this->snippetsProvider() as $snippet) {
            $this->assertArrayHasKey($snippet[0], $this->helper->getDisabledSnippets());
            $this->assertArrayNotHasKey($snippet[0], $this->helper->getEnabledSnippets());
        }
    }

    /**
     * Test Disable Snippet
     */
    public function testDisableSnippet()
    {
        $this->helper->appendSnippet('test', 'hanger-snippet/test', ['foo' => 'ABC']);
        $this->assertArrayHasKey('test', $this->helper->getEnabledSnippets());
        $this->assertArrayNotHasKey('test', $this->helper->getDisabledSnippets());
        $this->helper->setDisabled('test');
        $this->assertArrayNotHasKey('test', $this->helper->getEnabledSnippets());
        $this->assertArrayHasKey('test', $this->helper->getDisabledSnippets());
    }

    /**
     * @param $name
     * @param $template
     * @param $values
     * @param $expected
     * @dataProvider snippetsProvider
     */
    public function testRender($name, $template, $values, $expected)
    {
        $this->helper->appendSnippet($name, $template, $values);
        $return = $this->helper->renderSnippet($name);
        $this->assertEquals($expected, $return);
    }

    /**
     * Test Render All
     */
    public function testRenderAll()
    {
        $snippetExpected = [];
        foreach ($this->snippetsProvider() as $snippet) {
            $this->helper->appendSnippet($snippet[0], $snippet[1], $snippet[2]);
            $snippetExpected[] = $snippet[3];
        }
        $expected = implode(PHP_EOL, $snippetExpected);
        $return = $this->helper->render();
        $this->assertEquals($expected, $return);
    }

    /**
     * @param $name
     * @param $template
     * @param $values
     * @param $expected
     * @dataProvider snippetsProvider
     */
    public function testToString($name, $template, $values, $expected)
    {
        $this->helper->appendSnippet($name, $template, $values);
        $return = $this->helper->toString();
        $this->assertEquals($expected, $return);
    }

    /**
     * @param $name
     * @param $template
     * @param $values
     * @dataProvider snippetsProvider
     */
    public function testInvoke($name, $template, $values)
    {
        $this->helper->appendSnippet($name, $template, $values);
        $invoke = $this->helper->__invoke();
        $this->assertInstanceOf('\HangerSnippet\View\Helper\SnippetHelper', $invoke);
        $this->assertCount(1, $invoke->getSnippets());
    }

    /**
     * @expectedException \HangerSnippet\Exception\InvalidArgumentException
     */
    public function testInvalidArgumentException()
    {
        $this->helper->renderSnippet("invalidSnippet");
    }

    /**
     * @expectedException \HangerSnippet\Exception\InvalidArgumentException
     */
    public function testSetEnabled()
    {
        $this->helper->setEnabled("invalidSnippet");
    }


    /**
     * Snippets Data Provider
     * @return array
     */
    public function snippetsProvider()
    {
        $testSnippet = <<<HTML
<script type="text/javascript">
    <!--
    var foo = 'abc';
    -->
</script>
HTML;

        $anotherTestSnippet = <<<HTML
<script type="text/javascript">
    <!--
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'FOOOOOOO', 'BAAAAAAAARRRRR');
    ga('send', 'pageview');
    -->
</script>
HTML;

        $gaAnonymizeIP = <<<HTML
<script type="text/javascript">
    <!--
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
        ga('create', 'FOOOOOOO', 'BAAAAAAAARRRRR');
        ga('set', 'anonymizeIp', true);
        ga('send', 'pageview');
    -->
</script>
HTML;

        $nocaptchaSnippet1 = <<<HTML
<script src="http&#x3A;&#x2F;&#x2F;www.google.com&#x2F;justatry.js" async defer></script>
<div
    class="g-recaptcha"
    data-sitekey="qwertyuiop"
    ></div>
HTML;

        $nocaptchaSnippet2 = <<<HTML
<script src="http&#x3A;&#x2F;&#x2F;www.google.com&#x2F;justatry.js&#x3F;render&#x3D;explicit" async defer></script>

HTML;

        $nocaptchaSnippet3 = <<<HTML
<script src="http&#x3A;&#x2F;&#x2F;www.google.com&#x2F;justatry.js" async defer></script>
<div
    class="g-recaptcha"
    data-sitekey="qwertyuiop"
     data-theme="dark"></div>
HTML;


        return [
            [
                'test',
                'hanger-snippet/test',
                [
                    'foo' => 'abc'
                ],
                $testSnippet
            ],
            [
                'another',
                'hanger-snippet/anothertest',
                [
                    'foo' => 'FOOOOOOO',
                    'bar' => 'BAAAAAAAARRRRR',
                ],
                $anotherTestSnippet
            ],
            [
                'ga-anonymize-ip',
                'hanger-snippet/google-analytics',
                [
                    'monitoring_id' => 'FOOOOOOO',
                    'domain' => 'BAAAAAAAARRRRR',
                    'anonymize_ip' => true
                ],
                $gaAnonymizeIP
            ],
            [
                'google-nocaptcha-recaptcha-1',
                'hanger-snippet/google-nocaptcha-recaptcha',
                [
                    'uri' => 'http://www.google.com/justatry.js',
                    'sitekey' => 'qwertyuiop',
                ],
                $nocaptchaSnippet1
            ],
            [
                'google-nocaptcha-recaptcha-2',
                'hanger-snippet/google-nocaptcha-recaptcha',
                [
                    'uri' => 'http://www.google.com/justatry.js',
                    'sitekey' => 'qwertyuiop',
                    'parameters' => [
                        'render' => 'explicit',
                    ],
                ],
                $nocaptchaSnippet2
            ],
            [
                'google-nocaptcha-recaptcha-3',
                'hanger-snippet/google-nocaptcha-recaptcha',
                [
                    'uri' => 'http://www.google.com/justatry.js',
                    'sitekey' => 'qwertyuiop',
                    'theme' => 'dark',
                ],
                $nocaptchaSnippet3
            ],
        ];
    }
}
