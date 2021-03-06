<?php
/*
* Copyright (C) 2014
*BUNIFU TECHNOLOGIES

* This program is NOT A free software: you can MAY NOT redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program. If not, see <http://www.bunifu.co.ke>.
*/

// MySQL Class v0.8.1
class PDOclass{
	
	
	   //-------confiqure---------


       var $hostname='localhost';        // MySQL Hostname
        var $username='root';        // MySQL Username
        var $password='megasxlr';        // MySQL Password
	    var $database='e-afya'; // MySQL Database
		var $driver='mysql:host';

	
	
	        
	   
	//db objects
         var $pdo;
		 var $query;
	   
        /* *******************
         * Class Constructor *
         * *******************/

        function PDOclass(){
                error_reporting(E_ALL ^ E_DEPRECATED);
                $this->Connect();
        }

        /* *******************
         * Private Functions *
         * *******************/ 
		 
		  // Connects class to database
		
	
      function connect(){
             
				$this->pdo=new PDO($this->driver.'='.$this->hostname.';dbname='.$this->database,$this->username,$this->password);
					 
        }
    
	   function useDb($db){
             
				$this->pdo=new PDO('mysql:host='.$this->hostname.';dbname='.$db,$this->username,$this->password);
					 
        }

        /* *******************
         * Public Functions *
         * *******************/
      	
		
		
		//return pdo object
		 function ExecuteSQL($sql){
			if(strpos(strtolower(trim($sql)),"select")==0)
			{
				$this->query=$this->pdo->query($sql);
			    return($this->query->fetchAll(PDO::FETCH_ASSOC));
			}
			else
			{	
			  
				return($this->pdo->exec($sql));
			}
	   
	     }
		 
		 function Prepare($sql){
			  
				return($this->pdo->prepare($sql));
	     } 
        // Performs a 'mysql_real_escape_string' on the entire array/string
        public function SecureData($data){
               
			   
			   //more code
			   
			   
			   
				$data=str_replace("'","",$data);
                return $data;
        }
		
		
			//execute multiple querries 
			 function ExecuteMultiple($sqlq)
			 {
				// Split
				$arr =explode(";",$sqlq);
				 foreach($arr as $sql)
				 {
				   $this->ExecuteSQL($sql.";") ;
				 }
			  
			 }

}
?>