<?php
/**
 * @author Hillario Haji, CodOrps.com
 * @version 1.0
 */
include 'Config.php';
class MySql {

    protected $host     = DB_HOST;
    protected $user     = DB_USER;
    protected $pass     = DB_PASSWORD;
    protected $dbName   = DB_NAME;
    
    protected $error; 
    protected $inforResult;
    protected $numRows;
    protected $numCols;
    protected $id;
    protected $dataJson;
    protected $transacao;
    protected $sql;
    protected $converterUtf8=true;
    protected $uppercase=false;

    protected $connection;

    function __construct(){

    }
   
    public function setDbName($dbName){
        if (strlen(trim($dbName)) > 0 ){
            $this->dbName = $dbName;
            return true;
        }
        else{
            return false;
        }

    }

    public function getDbName(){
        return $this->dbName;
    }

    public function setHost($host){
        if (strlen(trim($host)) > 0 ){
            $this->host = $host;
        }
    }

    public function getHost(){
        return $this->host;
    }

    public function setUser($user){
        if (strlen(trim($user)) > 0 ){
            $this->user = $user;
        }
    }

    public function getUser(){
        return $this->user;
    }


    public function setPass($senha){
        if (strlen(trim($senha)) > 0 ){
            $this->pass = $senha;
        }
    }

    function getErros(){
        $erros = print_r($this->error, true);
        return $erros;
    }

    public function setUppercase($bool){
        if(is_bool($bool)){
            $this->uppercase = $bool;
        }
    }

    public function getId(){
        return $this->id;
    }

    public function getSql(){
        return $this->sql;
    }

    public function getNumRows(){
        return $this->numRows;
    }

    public function getNumCols(){
        return $this->numCols;
    }

    private function connect(){
        try{
            $this->connection = new PDO("mysql:host=".$this->host.";dbname=".$this->dbName, $this->user, $this->pass);
            return true;
        }
        catch (PDOException $e) {
            print "Error: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    private function logout(){
        $this->connection = null;
        $this->sql = null;
    }

    public function setUtf8($bool){
        if(is_bool($bool)){
            $this->converterUtf8 = $bool;
        }
    }

    public function setSqlScript($sql, $complementation=false){

        $arrayExp[] = "/''/";
        $arrayExp[] = "/' '/";
        $arrayExp[] = "/\" \"/";
        $arrayExp[] = "/\"\"/";
        $arrayExp[] = "/\"null\"/";
        $arrayExp[] = "/\"NULL\"/";
        $arrayExp[] = "/'null'/";
        $arrayExp[] = "/'NULL'/";
        $sql = preg_replace($arrayExp, "null", $sql);
        $sql = preg_replace($arrayExp, "null", $sql);

        $arrayExp = null;
        $arrayExp[] = "/,[ \t\n\r\f\v]*,/";
        $arrayExp[] = "/,,/";
        $arrayExp[] = "/, ,/";
        $sql = preg_replace($arrayExp, ",\n null,", $sql);
        $sql = preg_replace($arrayExp, ",\n null,", $sql);

        $arrayExp = null;
        $arrayExp = "/=[ \t\n\r\f\v]*,/";
        $sql = preg_replace($arrayExp, "= null,", $sql);
        $sql = preg_replace($arrayExp, "= null,", $sql);
       
        
        if($complementation == false){
            $this->sql = null;
            $this->sql = $sql;
        }
        else{
            $this->sql .= $sql."; \n";
        }
    }

     public function select($sql){

        $this->connect();
        if($this->connection === false){
            die("Error.");
        }
        else{

            $this->setSqlScript($sql);
            $pdo = $this->connection;

            $db = $pdo->prepare($this->sql);

            $result = $db->execute();

            if($result === true){
                $data = $db->fetchAll(PDO::FETCH_ASSOC);

                $this->id = $pdo->lastInsertId();
                $this->numRows = $db->rowCount();
                $this->numCols = $db->columnCount();
                $pdo = null;

                if($this->uppercase == false){
                    if(is_array($data)){
                        foreach($data as $key=> $reg){
                            foreach($reg as $campo=>$val){
                                $val = ($this->converterUtf8==true)?utf8_encode($val):$val;
                                $return[$key][$campo] = $val;
                            }
                        }
                    }
                    if(isset($return))
                    {
                        return $return;
                    }
                }else{
                    
                    if(is_array($data)){
                        foreach($data as $key=> $reg){
                            foreach($reg as $campo=>$val){
                                $val = ($this->converterUtf8==true)?utf8_encode(strtoupper($val)):strtoupper($val);
                                $returnUppercase[$key][$campo] = $val;
                            }
                        }
                    }

                    return $returnUppercase;
                }
            }else{

                $this->error = $db->errorInfo();
                $this->error['sql'] = $this->sql;
                return die($this->getErros());
            }
            $this->logout();
        }
    }


    public function insert($sql)
    {
        $this->connect();
        if($this->connection === false){
            die("Error.");
        }else{
            $sql = ($this->converterUtf8==true)?utf8_decode($sql):$sql;
            $this->setSqlScript($sql);
            $pdo = $this->connection;

            try {
                $transacao = $pdo->beginTransaction();
                if($transacao === true){
                    $db = $pdo->prepare($this->sql);

                    $result = $db->execute();
                    if($result===true){
                        $this->id = $pdo->lastInsertId();
                        $this->numRows = $db->rowCount();
                        $this->numCols = $db->columnCount();
                        
                        $commit = $pdo->commit();

                        if($commit === true){
                            $this->sql = null;
                            return $result;
                        }else{
                            $this->error = $db->errorInfo();
                            $this->error['sql'] = $this->sql;
                            return die("Error commit: " .$this->getErros());
                        }
                    }else{
                        $this->error = $db->errorInfo();
                        $this->error['sql'] = $this->sql;
                        return die("Error query: " .$this->getErros());
                        $this->sql = null;
                    }

                    $pdo = null;
                    $this->sql = null;
                }
                else{
                    $pdo = null;
                    $this->error['sql'] = $this->sql;
                    return die("Error: " .$this->getErros());
                    $this->sql = null;
                }
                $this->sql = null;

            }
            catch (PDOException $e) {
                $pdo->rollBack();
                $this->error = $db->errorInfo();
                $this->error['sql'] = $this->sql;
                $this->sql = null;
                
                return die("Failed: " . $e->getMessage().$this->getErros());
            }

            $this->logout();
        }

    }

    public function multInsert($sqlArray){

        $this->connect();
        if($this->connection === false){
            die("Error.");
        }

        if(is_array($sqlArray)==false){
            die('Error Script.');
        }

        else{
            $this->sql = null;
            $pdo = $this->connection;
            
            $Transaction = $pdo->beginTransaction();
            $Transaction = true;
            
            try {
               
                if($Transaction === true){
                    foreach ($sqlArray as $sql) {
                        $this->setSqlScript($sql);
                        
                        $db         = $pdo->prepare($this->sql);
                        $result  = $db->execute();

                        if($result===true){
                            $this->id = $pdo->lastInsertId();
                            $this->numRows = $db->rowCount();
                            $this->numCols = $db->columnCount();
                        }else{
                            $this->error = $db->errorInfo();
                            $this->error['sql'] = $this->sql;
                            return die("Error query: " .$this->getErros());
                        }
                    }

                    $commit = $pdo->commit();
                    if($commit === true){
                        $pdo = null;
                        return true;
                    }else{
                        $pdo->rollBack();
                        $this->error = $db->errorInfo();
                        $this->error['sql'] = $this->sql;
                        return die("Error commit: " .$this->getErros());
                    }
                    
                }
                else{
                    $pdo = null;
                    $this->error['sql'] = $this->sql;
                    return die("Error: " .$this->getErros());
                }

            }
            catch (PDOException $e) {
                $pdo->rollBack();
                $this->error = $db->errorInfo();
                $this->error['sql'] = $this->sql;
                return die("Failed: " . $e->getMessage().$this->getErros());
                $pdo = null;
            }

            $this->logout();
        }

    }
}
?>