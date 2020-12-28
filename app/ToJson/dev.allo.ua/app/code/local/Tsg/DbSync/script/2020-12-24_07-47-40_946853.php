<?php
/** @var Mage_Core_Model_Resource_Setup $installer */
$installer = $this->getInstaller();
//Do not use $this, use $installer;

$installer->startSetup();

/**
 * Rewrite data from serialize to json
 */
$table           = $installer->getTable('core_config_data');
$fieldsForInsert = ['config_id','value'];
$selectForTable  = $installer->getConnection()->select()->from($table, $fieldsForInsert);
$dataForInsert   = $installer->getConnection()->fetchAll($selectForTable);
$newData = [];

if ($dataForInsert) {
    foreach ($dataForInsert as $key => $value) {
        if ($value['value'] !== null && @unserialize($value['value']) !== false) {
            $val = unserialize($value['value']);
            $newData[] =
                [
                    'config_id' => $value['config_id'],
                    'value' => json_encode($val, JSON_UNESCAPED_UNICODE),
                ];
        }
    }
    $installer->getConnection()->insertOnDuplicate($table, $newData, ['value']);
}
$installer->endSetup();