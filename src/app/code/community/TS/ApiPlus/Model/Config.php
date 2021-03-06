<?php
/**
 * Tiago Sampaio
 *
 * Do not edit this file if you want to update this module for future new versions.
 *
 * @category  TS
 * @package   TS_ApiPlus
 *
 * @copyright Copyright (c) 2016 Tiago Sampaio. (http://tiagosampaio.com)
 * @license   https://opensource.org/licenses/MIT The MIT License
 *
 * @author    Tiago Sampaio <tiago@tiagosampaio.com>
 */
class TS_ApiPlus_Model_Config extends Mage_Api_Model_Config
{

    use TS_ApiPlus_Trait_Data;

    /** @var string */
    const CACHE_TAG = 'API_PLUS_RESULTS';


    /**
     * @param string|null $resourceName
     *
     * @return array
     */
    public function getFaults($resourceName = null)
    {
        if (is_null($resourceName)
            || !isset($this->getResources()->$resourceName)
            || !isset($this->getResources()->$resourceName->faults)) {
            $faultsNode = $this->getNode('faults');
        } else {
            $faultsNode = $this->getResources()->$resourceName->faults;
        }
        /* @var $faultsNode Varien_Simplexml_Element */

        $translateModule = 'api';

        if (isset($faultsNode['module'])) {
            $translateModule = (string) $faultsNode['module'];
        }

        $faults = array();

        foreach ($faultsNode->children() as $faultName => $fault) {
            $faults[$faultName] = array(
                'code'      => (string) $fault->code,
                'http_code' => (int)    $fault->http_code,
                'message'   => Mage::helper($translateModule)->__((string)$fault->message)
            );
        }

        return $faults;
    }

}
