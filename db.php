<?php
class Db{
    const DB_NAME = "test.db";   
    private $_db = NULL;
    
	function __construct(){
		if(is_file(self::DB_NAME)){
			$this->_db = new SQLite3(self::DB_NAME);
		}else{
			$this->_db = new SQLite3(self::DB_NAME);
			$sql = "CREATE TABLE seals(
									id INTEGER PRIMARY KEY AUTOINCREMENT,
									title TEXT,
									number INTEGER
									)";
            $this->_db->exec($sql) or $this->_db->lastErrorMsg();
            $sql = "CREATE TABLE product(
									id INTEGER PRIMARY KEY AUTOINCREMENT,
									name TEXT,
									telephone INTEGER,
                                    email TEXT,
                                    seals INTEGER,
                                    quantity INTEGER
									)";
			$this->_db->exec($sql) or $this->_db->lastErrorMsg();
			$sql = "INSERT INTO seals (title, number) VALUES ('promo', 1234)";
			$this->_db->exec($sql) or $this->_db->lastErrorMsg();
            $sql = "INSERT INTO seals (title, number) VALUES ('card', 4321)";
			$this->_db->exec($sql) or $this->_db->lastErrorMsg();
		}
	}
    public function GetSeal($num){    
        $result = $this->_db->query("SELECT * FROM seals WHERE number='$num'") or $this->_db->lastErrorMsg();
        if($result->fetchArray())
            return 1;
        else return 0;
	}	
    
    public function InsertNewOrder($name,$email,$tel,$seals=NULL,$quantity,$price){
        if($this->ValidTel($tel) && $this->ValidName($name) && $this->ValidEmail($email)){
            $sql = "INSERT INTO product(name, telephone, email, seals, quantity) VALUES ('$name', '$tel', '$email', '$seals', '$quantity')";
            $create = $this->_db->exec($sql) or $this->_db->lastErrorMsg();
            if($create == 1){
                if(self::MailSand($name,$email,$tel,$seals,$quantity,$price))
                    return 1;
            }
        }
            return 0;
    }
    
    public function ValidTel($tel){
        if(ctype_digit($tel))
            return true;
        else
            return false;
    }
    
    public function ValidName($name){
        return true;
    }
    
    public function ValidEmail($email){
        return true;
    }
    
    public static function MailSand($name,$email,$tel,$seals=0,$quantity,$price){
        $to  = "<beelineivanobl@gmail.com>" ;
        
        $subject = "Новый заказ"; 
        
        $message = " <p>Новый заказ</p> </br> <b>Имя: </b> $name </br><b>email: </b> $email </br><b>Телефон: </b> $tel </br><b>Скидка: </b> $seals </br><b>Количество: </b> $quantity </br><b>Конечная цена: </b> $price </br>";
        
        $headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
        $headers .= "From: <sait@sait.ru>\r\n"; 
        
        if(mail($to, $subject, $message, $headers))
            return true;
        return false;
    }
    
    function __destruct(){
		unset($this->_db);
	}
}



?>