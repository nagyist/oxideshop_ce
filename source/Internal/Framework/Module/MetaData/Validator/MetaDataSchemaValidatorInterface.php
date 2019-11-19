<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\EshopCommunity\Internal\Framework\Module\MetaData\Validator;

interface MetaDataSchemaValidatorInterface
{
    /**
     * @param string $metaDataFilePath
     * @param string $metaDataVersion
     * @param array  $metaData
     */
    public function validate(string $metaDataFilePath, string $metaDataVersion, array $metaData);
}
