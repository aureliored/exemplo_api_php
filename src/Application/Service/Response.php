<?php
namespace Application\Service;

class Response 
{
    private $return;

    public function jsonResponse()
    {
        return json_encode($this->return);
    }

    public function setSuccess($message, $data)
    {
        $this->return = [
            'status' => true, 
            'code' => 200, 
            'message' => $message, 
            'data' => $data,
           ];
        return $this;
    }

    public function setFail($message, $data, $code = 500)
    {
         $this->return = [
             'status' => false, 
             'code' => $code, 
             'message' => $message, 
             'data' => $data,
            ];
        return $this;
    }

    public function getReturn()
    {
        return $this->return;
    }
}