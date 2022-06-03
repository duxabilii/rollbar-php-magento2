<?php

namespace Rollbar\Magento2\Plugin;

use Rollbar\Rollbar;

class HttpPlugin
{
	public function aroundCatchException($subject, $callable, $bootstrap, $exception)
	{
        Rollbar::error($exception);

        $callable($bootstrap, $exception);

    }
}
