<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\EshopCommunity\Tests\CodeceptionAdmin;

use OxidEsales\Codeception\Module\Translation\Translator;
use OxidEsales\EshopCommunity\Tests\Codeception\AcceptanceAdminTester;

final class SortFieldManufacturerCest
{
    /** @param AcceptanceAdminTester $I
     * @group manufacturer
     */
    public function sortField(AcceptanceAdminTester $I): void
    {
        $I->wantToTest('whether oxsort field exists and whether it saves the entered values');

        $adminPanel = $I->loginAdmin();

        $manufacturerTab = $adminPanel->openManufacturerTab();

        $manufacturerTab->createNewManufacturer('Test', '3');

        $manufacturerTab->createNewManufacturer('Test2', 'Invalid value');

        $manufacturerTab->createNewManufacturer('Test3', '');

        $manufacturerTab->SortHelpIsAvailable();
    }
}
