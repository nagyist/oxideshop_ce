<?php
/**
 * This file is part of OXID eShop Community Edition.
 *
 * OXID eShop Community Edition is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * OXID eShop Community Edition is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with OXID eShop Community Edition.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @link      http://www.oxid-esales.com
 * @copyright (C) OXID eSales AG 2003-2016
 * @version   OXID eShop CE
 */
namespace OxidEsales\Eshop\Core;

use oxDb;
use oxUtilsObject;

/**
 * Settings handler class.
 */
class SettingsHandler extends \oxSuperCfg
{
    /**
     * Module type.
     *
     * e.g. 'module' or 'theme'
     *
     * @var string
     */
    protected $moduleType;

    /**
     * Sets the Module type
     *
     * @param string $moduleType can be either 'module' or 'theme'
     *
     * @return oxSettingsHandler
     */
    public function setModuleType($moduleType)
    {
        $this->moduleType = $moduleType;

        return $this;
    }

    /**
     * Get settings and module id and starts import process.
     *
     * Run module settings import logic only if it has settings array
     * On empty settings array, it will remove the settings.
     *
     * @param object $module Module or Theme Object
     */
    public function run($module)
    {
        $moduleSettings = $module->getInfo('settings');
        if (is_array($moduleSettings)) {
            $this->addModuleSettings($moduleSettings, $module->getId());
        }
    }

    /**
     * Adds settings to database.
     *
     * @param array  $moduleSettings Module settings array
     * @param string $moduleId       Module id
     */
    protected function addModuleSettings($moduleSettings, $moduleId)
    {
        $this->removeNotUsedSettings($moduleSettings, $moduleId);
        $config = $this->getConfig();
        $shopId = $config->getShopId();
        $moduleConfigs = $this->getModuleConfigs($moduleId);
        $db = oxDb::getDb();

        if (is_array($moduleSettings)) {
            foreach ($moduleSettings as $setting) {
                $oxid = oxUtilsObject::getInstance()->generateUId();

                $module = $this->getModuleConfigId($moduleId);
                $name = $setting["name"];
                $type = $setting["type"];

                $themeTypeCondition = "@^" . Config::OXMODULE_THEME_PREFIX . "@i";
                if (preg_match($themeTypeCondition, $module)) {
                    $value = array_key_exists($name, $moduleConfigs) ? $moduleConfigs[$name] : $setting["value"];
                } else {
                    $value = is_null($config->getConfigParam($name)) ? $setting["value"] : $config->getConfigParam($name);
                }

                $group = $setting["group"];

                $constraints = "";
                if ($setting["constraints"]) {
                    $constraints = $setting["constraints"];
                } elseif ($setting["constrains"]) {
                    $constraints = $setting["constrains"];
                }

                $position = $setting["position"] ? $setting["position"] : 1;

                $config->setConfigParam($name, $value);
                $config->saveShopConfVar($type, $name, $value, $shopId, $module);

                $deleteSql = "DELETE FROM `oxconfigdisplay` WHERE OXCFGMODULE=" . $db->quote($module) . " AND OXCFGVARNAME=" . $db->quote($name);
                $insertSql = "INSERT INTO `oxconfigdisplay` (`OXID`, `OXCFGMODULE`, `OXCFGVARNAME`, `OXGROUPING`, `OXVARCONSTRAINT`, `OXPOS`) " .
                "VALUES ('{$oxid}', " . $db->quote($module) . ", " . $db->quote($name) . ", " . $db->quote($group) . ", " . $db->quote($constraints) . ", " . $db->quote($position) . ")";

                $db->execute($deleteSql);
                $db->execute($insertSql);
            }
        }
    }

    /**
     * Removes configs which are removed from module metadata
     *
     * @param array  $moduleSettings Module settings
     * @param string $moduleId       Module id
     */
    protected function removeNotUsedSettings($moduleSettings, $moduleId)
    {
        $moduleConfigs = array_keys($this->getModuleConfigs($moduleId));
        $moduleSettings = $this->parseModuleSettings($moduleSettings);

        $configsToRemove = array_diff($moduleConfigs, $moduleSettings);
        if (!empty($configsToRemove)) {
            $this->removeModuleConfigs($moduleId, $configsToRemove);
        }
    }

    /**
     * Returns module configuration from database
     *
     * @param string $moduleId Module id
     *
     * @return array key=>value
     */
    protected function getModuleConfigs($moduleId)
    {
        $db = oxDb::getDb(oxDb::FETCH_MODE_ASSOC);
        $config = $this->getConfig();
        $shopId = $config->getShopId();
        $module = $this->getModuleConfigId($moduleId);

        $decodeValueQuery = $config->getDecodeValueQuery();
        $moduleConfigsQuery = "SELECT oxvarname, oxvartype, {$decodeValueQuery} as oxvardecodedvalue FROM oxconfig WHERE oxmodule = ? AND oxshopid = ?";
        $dbConfigs = $db->getAll($moduleConfigsQuery, [$module, $shopId]);

        $result = [];
        foreach ($dbConfigs as $oneModuleConfig) {
            $result[$oneModuleConfig['oxvarname']] = $config->decodeValue($oneModuleConfig['oxvartype'], $oneModuleConfig['oxvardecodedvalue']);
        }

        return $result;
    }

    /**
     * Parses module config variable names to array from module settings
     *
     * @param array $moduleSettings Module settings
     *
     * @return array
     */
    protected function parseModuleSettings($moduleSettings)
    {
        $settings = array();

        if (is_array($moduleSettings)) {
            foreach ($moduleSettings as $setting) {
                $settings[] = $setting['name'];
            }
        }

        return $settings;
    }

    /**
     * Removes module configs from database
     *
     * @param string $moduleId        Module id
     * @param array  $configsToRemove Configs to remove
     */
    protected function removeModuleConfigs($moduleId, $configsToRemove)
    {
        $db = oxDb::getDb();
        $quotedShopId = $db->quote($this->getConfig()->getShopId());
        $quotedModuleId = $db->quote($this->getModuleConfigId($moduleId));

        $quotedConfigsToRemove = array_map(array($db, 'quote'), $configsToRemove);
        $deleteSql = "DELETE
                       FROM `oxconfig`
                       WHERE oxmodule = $quotedModuleId AND
                             oxshopid = $quotedShopId AND
                             oxvarname IN (" . implode(", ", $quotedConfigsToRemove) . ")";

        $db->execute($deleteSql);
    }

    /**
     * Get config tables specific module id
     *
     * @param string $moduleId
     * @return string
     */
    protected function getModuleConfigId($moduleId)
    {
        return $this->moduleType . ':' . $moduleId;
    }
}
