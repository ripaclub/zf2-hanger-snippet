<?php
namespace HangerSnippet\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use HangerSnippet\View\Helper\SnippetHelper;


class SnippetHelperServiceFactory implements FactoryInterface
{
    /**
     * Create an appender helper service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return SnippetHelper
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');


        $snippetsConfig = isset($config['hanger_snippet']) ? $config['hanger_snippet'] : array();

        $snippetHelper = new SnippetHelper();

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
                    isset($snippetsConfig['enabled']) ? $snippetsConfig['enabled'] : $enableAll
                );
            }
        }

        return $snippetHelper;
    }
}
