<?php
namespace HangerSnippet\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\HelperPluginManager;
use HangerSnippet\View\Helper\SnippetHelper;

/**
 * Class SnippetHelperServiceFactory
 * @author Leonardo Grasso <me@leonardograsso.com>
 */
class SnippetHelperServiceFactory implements FactoryInterface
{
    /**
     * @var string
     */
    protected $configKey = 'hanger_snippet';

    /**
     * Create an appender helper service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return SnippetHelper
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $snippetHelper = new SnippetHelper();

        //Get the top level service locator
        $serviceManager = $serviceLocator;
        if ($serviceManager instanceof HelperPluginManager) {
            $serviceManager = $serviceManager->getServiceLocator();
        }

        if (!$serviceManager->has('Config')) {
            return $snippetHelper;
        }

        $config = $serviceManager->get('Config');

        $snippetsConfig = isset($config[$this->configKey]) ? $config[$this->configKey] : array();

        if (isset($snippetsConfig['snippets']) && is_array($snippetsConfig['snippets'])) {

            $enableAll = isset($snippetsConfig['enable_all']) ? (bool) $snippetsConfig['enable_all'] : true; //enable all by default

            foreach ($snippetsConfig['snippets'] as $name => $snippetsConfig) {

                $values = array();

                //Retrive values from global config if a config key was provided
                if (isset($snippetsConfig['config_key']) && isset($config[$snippetsConfig['config_key']])) {
                    $values = $config[$snippetsConfig['config_key']];
                }

                //Merge provided values, if any
                if (isset($snippetsConfig['data'])) {
                    $values = array_merge_recursive($values, $snippetsConfig['data']);
                }

                $snippetHelper->appendSnippet(
                    $name,
                    isset($snippetsConfig['template']) ? $snippetsConfig['template'] : 'hanger-snippet/' . $name,
                    $values,
                    isset($snippetsConfig['placement']) ? $snippetsConfig['placement'] : null,
                    isset($snippetsConfig['enabled']) ? $snippetsConfig['enabled'] : $enableAll
                );
            }
        }

        return $snippetHelper;
    }
}
