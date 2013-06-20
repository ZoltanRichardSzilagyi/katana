<?php
namespace classes\utils\json;

use classes\utils\json\JSONSerializable;

class JSONUtils{
    
    public static function decode($json){
        return json_decode($json);
    }
    
    public static function encode($value){
        if($value instanceof JSONSerializable){
            $values = $value->toJSONSerialize();
            return json_encode($values);
        }else{
            return json_encode($value);
        }
    }
    
}
