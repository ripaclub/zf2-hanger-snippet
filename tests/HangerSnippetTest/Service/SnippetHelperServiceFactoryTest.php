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
     * @var \Zend\ServiceManager\ServiceManager
     */
    private $serviceManager;

    /**
     *
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    protected function setUp()
    {

        $this->serviceManager =  new ServiceManager();

        $this->serviceManager->setService('Config', array(
            'google-analytics' => array(
                'monitoring_id' => 'UA-XXXXXXXX-X',
                'domain'        => 'yourdomain.com'
            ),

            'hanger-snippet' => array(
                'ga' => array(
                    'config_key' => 'google-analytics', //the config node in the global config, if any
                    'template'   => 'google-analytics.phtml',
                    'values' => array(
                        //other values for the template
                    ),
                )
            ),
        ));

        $this->viewHelperPluginManager = new HelperPluginManager();
        $this->viewHelperPluginManager->setFactory('hangerSnippet', 'HangerSnippet\Service\SnippetHelperServiceFactory');
        $this->viewHelperPluginManager->setServiceLocator($this->serviceManager);
    }

    public function testCreateService()
    {
        $helper = $this->viewHelperPluginManager->get('hangerSnippet');
        $this->assertInstanceOf('\HangerSnippet\View\Helper\SnippetHelper', $helper);
    }

}