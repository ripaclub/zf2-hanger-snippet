<?php
namespace HangerSnippet\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\HelperPluginManager;
use HangerSnippet\View\Helper\SnippetHelper;

/**
 * Class SnippetHelperServiceFactory
 * @author Leonardo Grasso <me@leonardograsso.com>
 * @author Lorenzo Fontana <fontanalorenzo@me.com>
 */
class SnippetHelperServiceFactory implements FactoryInterface
{
    /**
     * Config Key
     * @var string
     */
    protected $configKey = 'hanger_snippet';

    /**
     * Create an appender helper service
     * @param ServiceLocatorInterface $serviceLocator
     * @return SnippetHelper
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $snippetHelper = new SnippetHelper();

        // Get the top level service locator
        $serviceManager = $serviceLocator;
        if ($serviceManager instanceof HelperPluginManager) {
            $serviceManager = $serviceManager->getServiceLocator();
        }

        if (!$serviceManager->has('Config')) {
            return $snippetHelper;
        }


        $config = $serviceManager->get('Config');

        $snippetsConfig = isset($config[$this->configKey]) ? $config[$this->configKey] : [];

        if (!isset($snippetsConfig['snippets'])) {
            return $snippetHelper;
        }

        $snippets = $snippetsConfig['snippets'];


        if (!is_array($snippets)) {
            return $snippetHelper;
        }

        return $this->configureSnippetHelper($snippetHelper, $config, $snippetsConfig);

    }


    /**
     * Configure Snippet Helper
     * @param SnippetHelper $snippetHelper
     * @param array         $config
     * @param array         $snippetsConfig
     * @return SnippetHelper
     */
    protected function configureSnippetHelper(SnippetHelper $snippetHelper, array $config, array $snippetsConfig)
    {
        $enableAll = isset($snippetsConfig['enable_all']) ?
            (bool)$snippetsConfig['enable_all'] :
            true;

        foreach ($snippetsConfig['snippets'] as $name => $snippetsConfig) {

            $values = [];

            // Retrive values from global config if a config key was provided
            if (isset($snippetsConfig['config_key']) && isset($config[$snippetsConfig['config_key']])) {
                $values = $config[$snippetsConfig['config_key']];
            }

            // Merge provided values, if any
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

        return $snippetHelper;
    }
}
