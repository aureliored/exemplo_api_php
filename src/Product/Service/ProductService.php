<?php
namespace Product\Service;

use DateTime;

class ProductService 
{
    private $fields = [
        
        'name',
        'photo',
        'description',
        'value',
        'weight',
        'height',
        'width',
        'length',
    ];


    public function __construct()
    {

    }

    public function dataToInsert($post)
    {
        $date = new DateTime();
        $data = [];
        foreach($this->fields as $field){
            $data[] = $this->validate($post, $field);
        }
        $currentDate = $date->format('Y-m-d');
        $data['created_in'] = "'{$currentDate}'";

        return implode(',', $data);
    }


    public function dataToUpdate($post)
    {
        $date = new DateTime();
        $data = [];
        foreach($this->fields as $field){
            $validate = $this->validate($post, $field); 
            $data[] = $validate ? "$field = $validate" : '';
        }


        $currentDate = $date->format('Y-m-d');
        $data['updated_in'] = "updated_in = '{$currentDate}'";

        return implode(', ', $data);
    }

    private function validate($data,$field){
        if(empty($data[$field])){
            return false;
        }

        $value = $data[$field];


        if(in_array($field,['value', 'weight'])) {
            return $this->clearNumeric($value);
        }
        
        if(in_array($field,['name', 'photo', 'description'])) {
            return "'{$value}'";
        }
        
        return $value;

    }

    private function clearNumeric($value)
    {
        $return = str_replace(['R$', '.', ','], ['', '', '.'], $value);
        return $return;
    }

    private function dateToDb($date)
    {
        $return = implode('-', array_reverse(explode('/', $date)));
        return $return;
    }
    
    private function dateToBr($date)
    {
        $return = implode('/', array_reverse(explode('-', $date)));
        return $return;
    }
}