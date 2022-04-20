<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\EshopCommunity\Internal\Framework\Theme\Event;

use Symfony\Contracts\EventDispatcher\Event;

/**
 * @stable
 * @see OxidEsales/EshopCommunity/Internal/README.md
 */
class ThemeSettingChangedEvent extends Event
{
    /**
     * @deprecated constant will be removed in v7.0.
     */
    public const NAME = self::class;

    /**
     * @param string $theme Theme information as in oxconfig.oxmodule
     */
    public function __construct(
        private string $configurationVariable,
        private int $shopId,
        private string $theme
    ) {
    }

    /**
     * Getter for configuration variable name.
     *
     * @return string
     */
    public function getConfigurationVariable(): string
    {
        return $this->configurationVariable;
    }

    /**
     * Getter for shop id.
     *
     * @return integer
     */
    public function getShopId(): int
    {
        return $this->shopId;
    }

    /**
     * Getter for theme information.
     *
     * @return string
     */
    public function getTheme(): string
    {
        return $this->theme;
    }
}
