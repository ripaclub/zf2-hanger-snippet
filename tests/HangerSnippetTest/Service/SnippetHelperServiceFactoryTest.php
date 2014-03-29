<?php
namespace HangerSnippet\Service;

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
     * {@inheritdoc}
     */
    protected function setUp()
    {

        $this->viewHelperPluginManager = new HelperPluginManager();
        $this->viewHelperPluginManager->setFactory(
            'hangerSnippet',
            'HangerSnippet\Service\SnippetHelperServiceFactory'
        );

    }

    /**
     * @dataProvider serviceManagerProvider
     */
    public function testCreateService(ServiceManager $sm)
    {
        $this->viewHelperPluginManager->setServiceLocator($sm);
        $helper = $this->viewHelperPluginManager->get('hangerSnippet');
        $this->assertInstanceOf('\HangerSnippet\View\Helper\SnippetHelper', $helper);
    }

    /**
     * Service Manager Data Provider
     * @return array
     */
    public function serviceManagerProvider()
    {
        $sm = new ServiceManager();

        $sm->setService('Config', [
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
            'another' => [
                'snippets' => []
            ],
        ]);


        $sm2 = new ServiceManager();


        $sm3 = new ServiceManager();

        $sm3->setService('Config', [
            'ga'             => [
                'monitoring_id' => 'UA-XXXXXXXX-X',
                'domain'        => 'yourdomain.com'
            ],

            'hanger_snippet' => [
            ],
            'another' => [
                'snippets' => []
            ],
        ]);


        $sm4 = new ServiceManager();

        $sm4->setService('Config', [
            'ga'             => [
                'monitoring_id' => 'UA-XXXXXXXX-X',
                'domain'        => 'yourdomain.com'
            ],

            'hanger_snippet' => [
                'snippets' => 'notAnArray'
            ],
            'another' => [
                'snippets' => []
            ],
        ]);


        $sm5 = new ServiceManager();

        $sm5->setService('Config', [
            'ga'             => [
                'monitoring_id' => 'UA-XXXXXXXX-X',
                'domain'        => 'yourdomain.com'
            ],

            'hanger_snippet' => [
                'snippets' => [
                    'google-analytics' => [
                        'data' => [],
                        'values'     => [
                            //other values for the template
                        ],
                    ]
                ]
            ],
            'another' => [
                'snippets' => []
            ],
        ]);

        return [[$sm], [$sm2], [$sm3], [$sm4], [$sm5]];
    }
}
