<?php
namespace app\module\admin\models;

use Yii;
class CurrencyStructure extends AbstractStructure
{
    protected $defaultCurrencyFields = array (
        'NumCode' => array (
            'name' => 'NumCode', 
            'type' => 'string'
        ), 
        'CharCode' => array (
            'name' => 'CharCode', 
            'type' => 'string'
        ), 
        'Nominal' => array (
            'name' => 'Nominal', 
            'type' => 'int'
        ), 
        'Name' => array (
            'name' => 'Name', 
            'type' => 'string'
        ), 
        'Value' => array (
            'name' => 'Value', 
            'type' => 'double'
        ), 
        
    );

    public function getCurrency($fields = array())
    {
        if (empty ($fields)) {
            $fields = $this->defaultCurrencyFields;
        }
        
        $currencyList = array ();

        for ($i = 0; $i < count ($this->xml->{'Valute'}); $i ++) {
            $currency = $this->xml->{'Valute'}[ $i ];
            $currencyVars = array ();
 
            foreach ($fields as $fieldNewName => $fieldVars) {
                $currencyVars[ $fieldNewName ] = $this->getValue ($currency, $fieldVars);
            }
            $currencyList[ ] = $currencyVars;
        }
        return $currencyList;
    }
}

