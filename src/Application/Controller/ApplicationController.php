<?php

namespace Application\Controller;



class ApplicationController
{
    private $router;
    
    public function error404Action()
    {
        echo json_encode([
            "status" => false,
            "code" => 404,
            "message" => "Pagina não encontrada.",
            ]);
        return $this;
    }
}