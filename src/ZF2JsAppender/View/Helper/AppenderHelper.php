<?php

namespace ZF2JsAppender\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * Class AppenderHelper
 * @author Lorenzo Fontana <fontanalorenzo@me.com>
 */
class AppenderHelper extends AbstractHelper
{
    /**
     * Invoke
     * @return string
     */
    public function __invoke()
    {
        return "javascript";
    }
}
