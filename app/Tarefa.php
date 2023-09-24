<?php
    require 'Banco.php';

    class Tarefa{
        private $id;        
        private $id_status;
        private $tarefa;
        private $data_cadastrado;

        public function __get($atributo){            
            return $this->$atributo;
        }

        public function __set($atributo,$valor){
            $this->$atributo = $valor;
        }

        public static function cadastrarTarefa($tarefa){
            return ((new Banco())->inserir($tarefa));
        }

        public static function recuperarTarefas(){
            return ((new Banco())->selecionar());
        }

        public static function editarTarefa($coluna, $valores){
            return ((new Banco())->atualizar($coluna, $valores));
        }

        public static function alterarStatusTarefa($status, $id){
            $valores[] = $status == 'pendente' ? 2 : 1;
            $valores[] = $id;
            return ((new Banco())->atualizar('id_status', $valores));
        }

        public static function removerTarefa($id){
            return ((new Banco())->deletar($id));
        }
    }
?>