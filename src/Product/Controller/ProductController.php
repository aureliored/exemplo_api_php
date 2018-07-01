<?php
namespace Product\Controller;

class ProductController
{
    function __construct()
	{
    }
    
    public function indexAction()
    {
        echo json_encode([
            'status' => true,
            'code' => 200,
            'data' => 'Deu certo',
            'message' => 'Success', 
        ]);
    }
}