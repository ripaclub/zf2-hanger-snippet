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
     * Snippets
     * @var array
     */
    protected $snippets = [];

    /**
     * Enabled Snippets
     * @var array
     */
    protected $enabledSnippets = [];


    /**
     * Set Enabled
     * @param string    $name       The Snippet name
     * @param bool      $enabled    The Snippet status
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
     * Set Enable All
     * @param bool $enable
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
     * Append Snippet
     * @param string    $name          The Snippet name
     * @param string    $template      The Snippet template
     * @param array     $values
     * @param bool      $enable
     * @return \HangerSnippet\View\Helper\SnippetHelper
     */
    public function appendSnippet($name, $template, array $values = [], $enable = true)
    {
        $this->snippets[$name] = [
            'template' => $template,
            'values'   => $values,
        ];

        $this->setEnabled($name, $enable);
        return $this;
    }

    /**
     * Render
     * @param string $name  The Snippet name
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
            $snippets = [$name => $snippets[$name]];
        }

        $pieces = [];
        foreach ($snippets as $name => $enabled) {
            if (!$enabled) {
                continue;
            }
            $pieces[] = $this->getView()->render($this->snippets[$name]['template'], $this->snippets[$name]['values']);
        }

        return implode(PHP_EOL, $pieces);
    }

    /**
     * To String
     * @return string
     */
    public function toString()
    {
        return $this->render();
    }

    /**
     * To String
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * View Helper Invoke
     * @return $this
     */
    public function __invoke()
    {
        return $this;
    }
}
