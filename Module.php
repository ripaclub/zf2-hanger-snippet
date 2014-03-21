<?php

namespace ZF2JsAppender;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;

/**
 * Class Module
 * @author Lorenzo Fontana <fontanalorenzo@me.com>
 */
class Module implements AutoloaderProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ],
            ],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
}
