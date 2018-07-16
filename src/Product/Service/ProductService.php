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
        'promotion_value',
        'promotion_start',
        'promotion_end',
        'weight',
        'height',
        'width',
        'length',
    ];

    public function fieldToInsert()
    {
        return implode(',', $this->fields);
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
            return "NULL";
        }

        $value = $data[$field];


        if(in_array($field,['value', 'weight', 'promotion_value'])) {
            return $this->clearNumeric($value);
        }
        
        if(in_array($field,['name', 'photo', 'description'])) {
            return "'{$value}'";
        }
        
        if(in_array($field,['promotion_start', 'promotion_end',])) {
            $date = $this->dateToDb($value);
            return "'{$date}'";
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

    private function promotionValide($row){
        $date = new DateTime();
        $currentDate = $date->format('Y-m-d');
        $currentDate = strtotime($currentDate);
        $start = strtotime($row['promotion_start']);
        $end = strtotime($row['promotion_end']);

        if(($start <= $currentDate) && ($end >= $currentDate)) {
            return true;
        }

        return false;
    }

    public function toApp($data)
    {
        foreach($data as $key => $row){
            $data[$key]['value'] = !empty($row['value']) ? "R$ " . number_format($row['value'],2,',', '.') : '';
            $data[$key]['value_clear'] = $this->clearNumeric($data[$key]['value']);
            if($this->promotionValide($row)){
                $data[$key]['promotion_value'] = !empty($row['promotion_value']) ? "R$ " . number_format($row['promotion_value'],2,',', '.') : '';
                $data[$key]['promotion_start'] = $row['promotion_start'] ? $this->dateToBr($row['promotion_start']) : '';
                $data[$key]['promotion_end'] = $row['promotion_end'] ? $this->dateToBr($row['promotion_end']) : '';
                $data[$key]['value_clear'] = $this->clearNumeric($data[$key]['promotion_value']);
            }else{
                unset($data[$key]['promotion_value'], $data[$key]['promotion_start'], $data[$key]['promotion_end']);
            }
        }

        return $data;
    }
}