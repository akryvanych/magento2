<?php

class My_ToJson_Model_System_Config_Backend_Serialized_Array extends
    Mage_Adminhtml_Model_System_Config_Backend_Serialized_Array
{
    /**
     * Refactor json encode data into array
     *
     * @return Mage_Adminhtml_Model_System_Config_Backend_Serialized|void
     * @throws Mage_Core_Exception
     */
    protected function _afterLoad()
    {
        if (!is_array($this->getValue())) {
            $encodeJsonValue = $this->getValue();
            $this->_beforeSave();
            $undecodeJsonValue = false;
            if (!empty($encodeJsonValue)) {
                try {
                    $undecodeJsonValue = Mage::helper('core')
                        ->jsonDecode($encodeJsonValue);
                } catch (Exception $e) {
                    Mage::logException($e);
                }
            }
            $this->setValue($undecodeJsonValue);
        }
    }

    /**
     * Check object existence in incoming data and unset array element with '__empty' key
     *
     * @return void
     * @throws Mage_Core_Exception
     */
    protected function _beforeSave()
    {
       $isJson = Mage::helper('core')->isJson($this->getValue());
        if ($isJson === true)
        {
            $value = $this->getValue();
            if (is_array($value)) {
                unset($value['__empty']);
            }
            $this->setValue($value);
            parent::_beforeSave();
        } else {
            Mage::throwException(Mage::helper('adminhtml')->__('Json data is incorrect'));
        }
    }
}