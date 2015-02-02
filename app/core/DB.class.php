<?php
class DB
{
    private $connection;
    private $statement;
    private static $instance = null;

    // Реализуем паттерн одиночка, для подключения к нашей БД
    public static function getInstance(){
        if(self::$instance === null){
            self::$instance = new DB();
            self::$instance->DBConnection();
        }
        return self::$instance;
    }

    // Метод подключения к БД
    private function DBConnection(){
        $this->connection = new PDO('mysql:dbname='.DB_NAME.';host='.DB_HOST.';port='.DB_PORT.
            ';charset='.DB_CHAR, DB_USER, DB_PASS);
    }

    public function lastInsertId(){
        return $this->connection->lastInsertId();
    }
    // Подготавливаем данные для запроса
    private function getQueryMetadata($query, $parameters){
        $parameters_string = '';
        $final_query_string = $query;
        foreach ($parameters as $k => $v) {
            if (!isset($v[2])){
                $v[2] = gettype($v[1]);
                $parameters[$k] = $v;
            }
            $parameters_string.=$v[0].$v[1].$v[2];
            $final_query_string = str_replace($v[0], $v[1], $final_query_string);
        }

        return array ('parameters' => $parameters, 'final_query_string' => $final_query_string);
    }

    // Собственно метод, в котором мы подготавливаем наш запрос
    public function executeQuery($query, $parameters = array()){
        $query_metadata = $this->getQueryMetadata($query, $parameters);
        $parameters = $query_metadata['parameters'];

        $this->statement = $this->connection->prepare($query);

        foreach ($parameters as $v){
            $type = '';
            switch ($v[2]){
                case 'boolean': $type = PDO::PARAM_BOOL; break;
                case 'integer': $type = PDO::PARAM_INT; break;
                case 'double': $type = PDO::PARAM_STR; break;
                case 'number': $type = PDO::PARAM_STR; break;
                case 'null': $type = PDO::PARAM_NULL; break;
                case 'lob': $type = PDO::PARAM_LOB; break;
                case 'string': $type = PDO::PARAM_STR; break;
                default: throw new Exception('Query error. Unsupported data type. Usually this means that you\'ve forgotten to add extra array to query parameters.');
            }
            $this->statement->bindValue($v[0], $v[1], $type);
        }
        $res = $this->statement->execute();
        $err = $this->statement->errorInfo();

        if ($res === FALSE){
            throw new Exception("Query failed: ".$query_metadata['final_query_string']);
        }

        $final_data['stmt'] = $this->statement;
        $final_data['rows'] = ($res !== FALSE) ? $this->statement->rowCount() : -1;
        $final_data['cols'] = ($res !== FALSE) ? $this->statement->columnCount() : -1;
        $final_data['errn'] = $err[1];
        $final_data['errt'] = $err[2];

        return $final_data;
    }

    private function __construct(){
    }
    private function __clone(){
    }
    private function __wakeup(){
    }
    public function __destruct(){
        if(!is_null($this->connection)){
            $this->connection = null;
        }
    }
}