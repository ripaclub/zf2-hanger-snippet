<?php
use HangerSnippetTest\View\Helper\SnippetHelper;
use Zend\View\Renderer\PhpRenderer as View;
class SnippetHelperTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \HangerSnippet\View\Helper\SnippetHelper
     */
    public $helper;

    /**
     * @var string
     */
    public $basePath;

    protected function setUp()
    {
        $this->basePath = __DIR__ . '/_files/modules';
        $this->helper   = new \HangerSnippet\View\Helper\SnippetHelper();
        $this->helper->appendSnippet('test', 'hanger-snippet/test', array('foo' => 'ABC'));
    }

    public function tearDown()
    {
        unset($this->helper);
    }

    public function testRender()
    {
        $view = new View();
        $view->resolver()->addPath($this->basePath);
        $this->helper->setView($view);

        //render one
        $return = $this->helper->renderSnippet('test');
        $this->assertContains('<script type="text/javascript">var foo = \'ABC\';</script>', $return);

        //render all
        $return = $this->helper->render();
        $this->assertContains('<script type="text/javascript">var foo = \'ABC\';</script>', $return);

        $this->assertSame($return, $this->helper->toString());
        $this->assertSame($return, (string) $this->helper);

    }


}