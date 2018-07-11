<?php
namespace Product\Controller;

use Product\Repository\ProductRepository;
use Application\Service\Response;

class ProductController
{
    function __construct()
	{
    }
    
    public function indexAction()
    {
        print $response->setSuccess('Success',$data)
                    ->jsonResponse();
        return true;
    }

    public function newAction()
    {  
        $repository = new ProductRepository();
        $response = new Response();
        $values = json_decode(file_get_contents('php://input'), true);
        $data = $repository->insert($values);
        print $response->setSuccess('Success',$data)
                    ->jsonResponse();
        return true;
    }

    public function allAction()
    {
        $repository = new ProductRepository();
        $response = new Response();
        $data = $repository->find();
        print $response->setSuccess('Success',$data)
                    ->jsonResponse();
        return true;
    }

    public function getAction()
    {
        $repository = new ProductRepository();
        $response = new Response();
        $data = $repository->findId($_GET['id']);
        print $response->setSuccess('Success',$data)
                    ->jsonResponse();
        return true;
    }

    public function removeAction()
    {
        $repository = new ProductRepository();
        $response = new Response();
        $data = $repository->remove($_GET['id']);
        print $response->setSuccess('Success',$data)
                    ->jsonResponse();
        return true;
    }

    public function editAction()
    {
        $repository = new ProductRepository();
        $response = new Response();
        $values = json_decode(file_get_contents('php://input'), true);
        $data = $repository->update($values, $_GET['id']);
        print $response->setSuccess('Success',$data)
                    ->jsonResponse();
        return true;
    }
}