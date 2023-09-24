<?php
    class Banco{

        const HOST = 'localhost';
        const DB = 'app_lista_de_tarefas';
        const USER = 'root';
        const PASSWORD = '';
        private $tabela;
        private $conexao;

        public function __construct(){
            $this->tabela = 'tb_tarefas';
            $this->definirConexao();
        }

        public function definirConexao(){
            try{
                $this->conexao = new PDO('mysql:host='. self::HOST .';dbname='. self::DB, self::USER, self::PASSWORD);
                $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch(PDOException $e){
                die('<p>erro ao executar query: '. $e->getMessage() .'</p>');
            }
        }

        public function executarQuery($query, $valores = []){
            try{
                $stmt = $this->conexao->prepare($query);
                $stmt->execute($valores);
                return $stmt;
            }
            catch(PDOException $e){
                die('<pre>erro: '. $e .'</pre>');
            }
        }

        public function inserir($tarefa){
            $query = 'INSERT INTO '. $this->tabela .'(tarefa) VALUES (?)';
            $valores[] = $tarefa;
            return $this->executarQuery($query, $valores);
        }

        public function selecionar(){
            $query = 'SELECT '. $this->tabela .'.id, tarefa, tb_status.status FROM '. $this->tabela . ' LEFT JOIN tb_status on ('.$this->tabela.'.id_status = tb_status.id)';
            return $this->executarQuery($query, null)->fetchAll(PDO::FETCH_ASSOC);
        }

        public function atualizar($campo, $valores){
            $query = 'UPDATE '. $this->tabela .' SET '. $campo .' = ? WHERE id = ?';
            return $this->executarQuery($query, $valores);
        }

        public function deletar($id){
            $query = 'DELETE FROM '. $this->tabela .' WHERE id = ?';
            $valores[] = $id;
            return $this->executarQuery($query, $valores);
        }
    }
?>