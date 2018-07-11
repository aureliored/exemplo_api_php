<?php
namespace Product\Repository;

use Application\Db\Connect;
use Application\Service\Response;
use Product\Service\ProductService;

class ProductRepository
{
    private $db;
    private $service;
    private $response;

    public function __construct()
    {
        
        $this->db = new Connect();
        $this->service = new ProductService();
        $this->response = new Response();
    }

    public function insert($values)
    {
        
        $data = $this->service->dataToInsert($values);

        $insert = "INSERT INTO tb_product 
        (name, photo, description, value,length, height, width,  weight, created_in) 
        VALUES ({$data})";

        try {
            $this->db->execute($insert);
            return $this
                    ->response
                    ->setSuccess('Inserido com sucesso.', 'Novo produto criado')
                    ->getReturn();
        } catch(PDOException $e) {
            return $this
                    ->response
                    ->setFail('Erro ao inserir.', $e->message)
                    ->getReturn();
        }
    }

    public function update($values,$id)
    {
        $name = $values['name'];
        $data = $this->service->dataToUpdate($values);
        
        $update = "UPDATE tb_product SET {$data} WHERE id = {$id}";

        try {
            $this->db->execute($update);
            return $this
                    ->response
                    ->setSuccess('Atualizado com sucesso.', "Produto: {$name} atualizado.")
                    ->getReturn();
        } catch(PDOException $e) {
            return $this
                    ->response
                    ->setFail('Erro ao inserir.', $e->message)
                    ->getReturn();
        }
    }

    public function remove($id){
        $delete = "DELETE FROM tb_product WHERE id = {$id}";
        try {
            $this->db->execute($delete);
            return $this
                    ->response
                    ->setSuccess('Removido com sucesso.', "Produto removido.")
                    ->getReturn();
        } catch(PDOException $e) {
            return $this
                    ->response
                    ->setFail('Erro ao inserir.', $e->message)
                    ->getReturn();
        }
    }

    public function find($where = null, $order = false, $limit = false)
    {
        $sql = "SELECT * FROM tb_product ";
        $sql .= $where ?? '';
        $sql .= $order ? " ORDER BY {$order}" : ' ORDER BY updated_in DESC';
        $sql .= $limit ?? '';

        try {
            return $this->db->fetchAll($sql);
        } catch(PDOException $e) {
            return $e->message;
        } 
    }

    public function findId($id)
    {  
        return $this->find("where id = {$id}");
    }
}   