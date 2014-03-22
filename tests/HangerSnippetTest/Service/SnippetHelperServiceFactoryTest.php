<?php
namespace HangerSnippetTest\Service;

use Zend\View\HelperPluginManager;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager\ServiceManager;

class SnippetHelperServiceFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Zend\View\HelperPluginManager
     */
    private $viewHelperPluginManager;

    /**
     *
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    protected function setUp()
    {

        $this->serviceManager =  new ServiceManager();

        $this->serviceManager->setService('Config', array(

        ));

//         $this->viewHelperPluginManager = new HelperPluginManager(new ServiceManagerConfig(array(
//             'factories' => [
//                 'hangerSnippet' => 'HangerSnippet\Service\SnippetHelperServiceFactory'
//              ],
//             )
//         ));
        //$this->viewHelperPluginManager->setServiceLocator($this->serviceManager);

    }

    public function testCreateService()
    {
        $this->markTestSkipped('TODO');
        return;
        $helper = $this->viewHelperPluginManager->get('hangerSnippet');
        echo get_class($helper);exit;

        $this->assertInstanceOf('\HangerSnippet\View\Helper\SnippetHelper', $helper);
    }

}