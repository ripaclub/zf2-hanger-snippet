<?php

namespace ZF2JsAppender\View\Helper;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\View\Helper\AbstractHelper;
use ZF2JsAppender\Exception\DomainException;

/**
 * Class AppenderHelper
 * @author Lorenzo Fontana <fontanalorenzo@me.com>
 */
class AppenderHelper extends AbstractHelper implements ServiceLocatorAwareInterface
{

    use ServiceLocatorAwareTrait;

    /**
     * View Helper Invoke
     * @param $configuration The required configuration
     * @return string
     * @throws \ZF2JsAppender\Exception\DomainException
     */
    public function __invoke($configuration)
    {
        $config = $this->getConfig($configuration);
        $type = $config['type'];
        $template = "zf2-js-appender/{$type}.phtml";
        $resolver = $this->getServiceManager()->get('Zend\View\Resolver\TemplatePathStack');

        if (false === $resolver->resolve($template)) {
            throw new DomainException("Cannot find a template matching the configuration provided.");
        }
        $values = $config['values'] ? $config['values'] : [];
        return $this->getView()->render($template, $values);
    }

    /**
     * Get zf2 appender configuration
     * @param string $configuration
     * @return array
     * @throws \ZF2JsAppender\Exception\DomainException
     */
    protected function getConfig($configuration)
    {
        $config = $this->getServiceManager()->get("Config");
        $moduleConfig = $config['zf2_js_appender'];
        if (!array_key_exists($configuration, $moduleConfig)) {
            throw new DomainException("The required configuration is missing.");
        }
        return $moduleConfig[$configuration];
    }

    /**
     * Get Service Manager
     * @return \Zend\ServiceManager\ServiceManager
     */
    protected function getServiceManager()
    {
        return $this->getServiceLocator()->getServiceLocator();
    }
}
