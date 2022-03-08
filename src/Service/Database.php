<?php


class Database{
    
	private $host = 'localhost';
	private $dbname = 'demo';
	private $user = 'root';
	private $password = '';

    private function GetConnection()
    {
        $conStr = "mysql:host={$this->host};dbname={$this->dbname};";

        $con = new PDO ( 
            $conStr, 
			$this->user, 
			$this->password, 
			array (
				PDO::ATTR_PERSISTENT => false,
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_EMULATE_PREPARES => false,
				PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8' 
			) 
		);
        
        return $con;
    }

    public function Disconnect($con)
    {
        $con = null;
    }

    public function Execute($sql, $param) 
    {
        $con = $this->GetConnection();

        $stmt = $con->prepare($sql);
        $result = $stmt->execute($param);

        $this->Disconnect($con);
    }

    public function Query($sql, $param = null) 
    {
        $con = $this->GetConnection();

        $stmt = $con->prepare($sql);
        $stmt->execute($param);

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->Disconnect($con);

        return $data;
    }

    public function Count($sql, $param = null) 
    {
        $con = $this->GetConnection();

        $stmt = $con->prepare($sql);
        $stmt->execute($param);
        $count = $stmt->rowCount();

        $this->Disconnect($con);

        return $count;
    }

    public function AddLimit($sql, $page = 0, $take = 10)
    {
        $skip = $page * $take;
        $sql = $sql . " Limit {$skip}, {$take}";

        return $sql;
    }
}


$database = new Database();

$sql = "SELECT * 
    FROM User
    WHERE Account like :Account
";

$param = [
    ":Account" => "%Mick%"
];

$sql = $database->AddLimit($sql, take:2);
var_dump($sql);

$data = $database->Query($sql, $param);
var_dump($data);