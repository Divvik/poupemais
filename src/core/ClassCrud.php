<?php

# namespace
namespace Src\Core;

# Use
use Src\Core\Models;

class ClassCrud extends Models
{
    private $crud;
    private $id;

    # Responsável pela preparação da query e execução
    private function prepareExecute($prep, $exec)
    {
        $this->crud = $this->db->prepare($prep);
        $this->crud->execute($exec);
    }

    # Seleção de dados
    public function selectDB($fields, $table, $where, $exec)
    {
        $this->prepareExecute("SELECT {$fields} FROM {$table} {$where}", $exec);
        return $this->crud;
    }

    # Inserção de dados
    public function insertDB($table, $values, $exec)
    {
        $this->prepareExecute("INSERT INTO {$table} VALUES ({$values})", $exec);
        return $this->crud;
    }

    # Update dados usuario
    public function updateDB($table, $values, $where,$exec)
    {
    $this->prepareExecute("UPDATE {$table} SET {$values} WHERE {$where}", $exec);
        return $this->crud;
    }

    # Deleta dados
    public function deleteDB($table, $values,$exec)
    {
        $this->prepareExecute("DELETE FROM {$table} WHERE {$values}", $exec);
        return $this->crud;
    }    
}