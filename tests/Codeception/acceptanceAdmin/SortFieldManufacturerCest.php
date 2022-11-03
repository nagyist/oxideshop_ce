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
    /** @param AcceptanceAdminTester $I */
    public function sortField(AcceptanceAdminTester $I): void
    {
        $I->wantToTest('whether oxsort field exists and whether it saves the entered values');

        $I->loginAdmin();
        $I->selectNavigationFrame();
        $I->retryClick(Translator::translate('mxmainmenu'));
        $I->retryClick(Translator::translate('MANUFACTURER_LIST_MENUSUBITEM'));
        $I->selectEditFrame();
        $I->see(Translator::translate('GENERAL_SORT'));

        $I->fillField(Translator::translate('editval[oxmanufacturers__oxtitle]'), 'test_manufacturer');
        $I->fillField('editval[oxmanufacturers__oxsort]', 3);
        $I->click(Translator::translate('saveArticle'));

        $I->seeInField('editval[oxmanufacturers__oxsort]', '3');
        $I->seeInDatabase(
            'oxmanufacturers',
            [
                'OXTITLE' => 'test_manufacturer',
                'OXSORT' => 3
            ]
        );


        $I->selectNavigationFrame();
//        $I->retryClick(Translator::translate('mxmainmenu'));
        $I->retryClick(Translator::translate('MANUFACTURER_LIST_MENUSUBITEM'));
        $I->selectEditFrame();
        $I->fillField(Translator::translate('editval[oxmanufacturers__oxtitle]'), 'test_manufacturer2');
        $I->click(Translator::translate('saveArticle'));

        $I->seeInField('editval[oxmanufacturers__oxsort]', '0');
        $I->seeInDatabase(
            'oxmanufacturers',
            [
                'OXTITLE' => 'test_manufacturer2',
                'OXSORT' => 0
            ]
        );


        $I->selectNavigationFrame();
        $I->retryClick(Translator::translate('MANUFACTURER_LIST_MENUSUBITEM'));
        $I->selectEditFrame();
        $I->fillField(Translator::translate('editval[oxmanufacturers__oxtitle]'), 'test_manufacturer3');
        $I->fillField('editval[oxmanufacturers__oxsort]', 'Invalid input');
        $I->click(Translator::translate('saveArticle'));

        $I->seeInField('editval[oxmanufacturers__oxsort]', '0');
        $I->seeInDatabase(
            'oxmanufacturers',
            [
                'OXTITLE' => 'test_manufacturer3',
                'OXSORT' => 0
            ]
        );
    }
}
