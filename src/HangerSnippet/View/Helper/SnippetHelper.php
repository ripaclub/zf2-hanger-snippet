<?php

namespace HangerSnippet\View\Helper;

use Traversable;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\View\Helper\AbstractHelper;
use Zend\Stdlib\ArrayUtils;
use HangerSnippet\Exception\DomainException;
use HangerSnippet\Exception\InvalidArgumentException;

/**
 * Class SnippetHelper
 * @author Lorenzo Fontana <fontanalorenzo@me.com>
 * @author Leonardo Grasso <me@leonardograsso.com>
 */
class SnippetHelper extends AbstractHelper implements ServiceLocatorAwareInterface
{

    use ServiceLocatorAwareTrait;

    /**
     * @var array
     */
    protected $snippets = array();

    /**
     * @var array
     */
    protected $enabledSnippets = array();


    /**
     * @param string $name
     * @param bool $enabled
     * @throws InvalidArgumentException
     * @return \HangerSnippet\View\Helper\SnippetHelper
     */
    public function setEnabled($name, $enabled = true)
    {
        if (!isset($this->snippets[$name])) {
            throw new InvalidArgumentException("Cannot find a snippet with name '{$name}'");
        }
        $this->enabledSnippets[$name] = (bool) $enabled;
        return $this;
    }

    /**
     * @param string $enable
     * @return \HangerSnippet\View\Helper\SnippetHelper
     */
    public function setEnableAll($enable = true)
    {
        foreach ($this->snippets as $name => $config) {
            $this->enabledSnippets[$name] = (bool) $name;
        }
        return $this;
    }

    /**
     * @param string $name
     * @param string $template
     * @param array $values
     * @param string $enable
     * @return \HangerSnippet\View\Helper\SnippetHelper
     */
    public function appendSnippet($name, $template, array $values = array(), $enable = true)
    {
        $this->snippets[$name] = array(
            'template' => $template,
            'values'   => $values,
        );

        $this->setEnabled($name, $enable);
        return $this;
    }

    /**
     * @param string $name
     * @throws InvalidArgumentException
     * @return string
     */
    public function render($name = null)
    {
        $snippets = $this->enabledSnippets;

        if (null !== $name) {
            if (!isset($snippets[$name])) {
                throw new InvalidArgumentException("Cannot find a snippet with name '{$name}'");
            }
            $snippets = array($name => $snippets[$name]);
        }

        $pieces = array();
        foreach ($snippets as $name => $enabled) {
            if (!$enabled) {
                continue;
            }
            $pieces[] = $this->getView()->render($this->snippets[$name]['template'], $this->snippets[$name]['values']);
        }

        return implode(PHP_EOL, $pieces);
    }


    public function toString()
    {
        return $this->render();
    }

    public function __toString()
    {
        return $this->render();
    }

    /**
     * View Helper Invoke
     *
     * @return string
     */
    public function __invoke()
    {
       return $this;
    }

}
