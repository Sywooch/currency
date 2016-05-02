<?php
namespace app\module\admin\models;

use Yii;
use yii\base\Model;
/**
 * Модель для импорта Xml файла
 * @author Admin
 *
 */
class AbstractStructure extends Model
{
    protected $fileContent = '';
    protected $xml = null;

    public function attributeNames()
    {
        return array ();
    }

    /**
     * Загрузить Xml файл
     */
    public function loadXML($fileName)
    {
        if (($this->fileContent = file_get_contents ($fileName))===false){
            echo "Error fetching XML\n";
        }else {
            libxml_use_internal_errors(true);
            $this->xml = simplexml_load_string ($this->fileContent);
        }
    }

    /**
     * Привести значение к типу
     * @param string $value
     * @param string $type
     * @return string|boolean|number|unknown
     */
    protected function toType($value, $type)
    {
        switch ($type) {
            case 'string' :
                return (string) $value;
            case 'bool' :
                return 'true' === (string) $value;
            case 'int' :
                return (int) $value;
            case 'double' :
                return (double) $value;
            default :
                return $value;
        }
    }

    /**
     * Получить значения из xml узла
     * @param array $struct
     * @param array $fieldVars
     * @return array
     */
    protected function getValue($struct, $fieldVars)
    {
        if ('array' == $fieldVars[ 'type' ]) {
            $params = array ();
            $names = explode ('.', $fieldVars[ 'name' ]);
            $value = $struct;
            foreach ($names as $name) {
                $value = $value->{$name};
            }
            for ($i = 0; $i < count ($value); $i ++) {
                $values = array ();
                foreach ($fieldVars[ 'values' ] as $fieldNewName => $fieldPartVars) {
                    $values[ $fieldNewName ] = $this->getValue ($value[ $i ], $fieldPartVars);
                }
                $params[ ] = $values;
            }
            
            return $params;
        }
        if (0 == substr_count ($fieldVars[ 'name' ], '.') && 0 == substr_count ($fieldVars[ 'type' ], '.')) {
            return  $this->toType ($struct->{$fieldVars[ 'name' ]}[ 0 ], $fieldVars[ 'type' ]);

        }
        if (0 == substr_count ($fieldVars[ 'name' ], '.') && 0 != substr_count ($fieldVars[ 'type' ], '.')) {
            $params = array ();
            $type = explode ('.', $fieldVars[ 'type' ]);
            for ($i = 0; $i < count ($struct->{$fieldVars[ 'name' ]}); $i ++) {
                $params[ ] = $this->toType ($struct->{$fieldVars[ 'name' ]}[ $i ], $type[ 1 ]);
            }
            return $params;
        }
        if (0 != substr_count ($fieldVars[ 'name' ], '.') && 0 == substr_count ($fieldVars[ 'type' ], '.')) {
            $names = explode ('.', $fieldVars[ 'name' ]);
            $value = $struct;
            foreach ($names as $name) {
                $value = $value->{$name};
            }
            return $this->toType ($value[ 0 ], $fieldVars[ 'type' ]);
        }
        if (0 != substr_count ($fieldVars[ 'name' ], '.') && 0 != substr_count ($fieldVars[ 'type' ], '.')) {
            $params = array ();
            $type = explode ('.', $fieldVars[ 'type' ]);
            
            $names = explode ('.', $fieldVars[ 'name' ]);
            $value = $struct;
            foreach ($names as $name) {
                $value = $value->{$name};
            }
            
            for ($i = 0; $i < count ($value); $i ++) {
                $params[ ] = $this->toType ($value[ $i ], $type[ 1 ]);
            }
            return $params;
        }
        return null;
    }
}

?>