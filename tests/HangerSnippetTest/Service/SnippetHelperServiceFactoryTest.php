<?php
namespace HangerSnippetTest\Service;

use Zend\View\HelperPluginManager;
use Zend\ServiceManager\ServiceManager;

/**
 * Class SnippetHelperServiceFactoryTest
 * @author Leonardo Grasso <me@leonardograsso.com>
 * @author Lorenzo Fontana <fontanalorenzo@me.com>
 */
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

        $this->serviceManager = new ServiceManager();

        $this->serviceManager->setService('Config', [
            'ga'             => [
                'monitoring_id' => 'UA-XXXXXXXX-X',
                'domain'        => 'yourdomain.com'
            ],

            'hanger_snippet' => [
                'snippets' => [
                    'google-analytics' => [
                        'config_key' => 'ga', //the config node in the global config, if any
                        'values'     => [
                            //other values for the template
                        ],
                    ]
                ]
            ],
        ]);

        $this->viewHelperPluginManager = new HelperPluginManager();
        $this->viewHelperPluginManager->setFactory(
            'hangerSnippet',
            'HangerSnippet\Service\SnippetHelperServiceFactory'
        );
        $this->viewHelperPluginManager->setServiceLocator($this->serviceManager);
    }

    public function testCreateService()
    {
        $helper = $this->viewHelperPluginManager->get('hangerSnippet');
        $this->assertInstanceOf('\HangerSnippet\View\Helper\SnippetHelper', $helper);
    }
}
