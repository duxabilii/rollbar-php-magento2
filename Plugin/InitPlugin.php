<?php

namespace Rollbar\Magento2\Plugin;

use Magento\Framework\AppInterface;
use Rollbar\Magento2\Helper\Data as DataHelper;
use Rollbar\Rollbar;

class InitPlugin
{
    /**
     * @var DataHelper
     */
    private $dataHelper;

    public function __construct(
        DataHelper $dataHelper
    ) {
        $this->dataHelper = $dataHelper;
    }

    public function beforeLaunch(AppInterface $subject)
    {
        if ($this->dataHelper->getEnabled() and $this->dataHelper->getAccessToken()) {
            $rollbarConfig = [
                'enabled' => $this->dataHelper->getEnabled(),
                'access_token' => $this->dataHelper->getAccessToken(),
                'environment' => $this->dataHelper->getEnvironment(),
            ];
            Rollbar::init($rollbarConfig);
        }
    }
}
