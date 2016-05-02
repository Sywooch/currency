<?php
namespace app\module\admin\models;

use Yii;

/**
 * Модель для импорта Xml файла с валютой
 */
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

    /**
     * Получить курс валют из загруженног xml файла
     * @param array $fields
     * @return array
     */
    public function getCurrency($fields = array())
    {
        if (empty ($fields)) {
            $fields = $this->defaultCurrencyFields;
        }
        
        $currencyList = array ();
        $date = (string)$this->xml['Date'];
        
        for ($i = 0; $i < count ($this->xml->{'Valute'}); $i ++) {
            $currency = $this->xml->{'Valute'}[ $i ];

            $currencyVars = array ();
 
            foreach ($fields as $fieldNewName => $fieldVars) {
                $currencyVars[ $fieldNewName ] = $this->getValue ($currency, $fieldVars);
            }
            $currencyVars['Date'] = (string)$date;
            $currencyVars['Id'] = (string)$currency['ID'];
            $currencyList[ ] = $currencyVars;
        }
        return $currencyList;
    }
}

