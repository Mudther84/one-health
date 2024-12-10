<?php
namespace DB;

use PDO;
use PDOException;

$db = require_once(__DIR__ . "/../database/config.php");

$dbname = $db['mysql']['database'];
$dbhost = $db['mysql']['host'];
$user = $db['mysql']['user'];
$pass = $db['mysql']['password'];
$port = $db['mysql']['port'];

	$db = new PDO("mysql:host=$dbhost;dbname=$dbname;port=$port" , $user , $pass); 

	define('DB', new DB($db));


class DB {
	
	protected $db;
	protected $table;
	protected $where = '';
	protected $statement;

	function __construct($db){
				
			try{
				
					$this->db = $db;
			}catch(PDOException $e){
						die($e->getMessage());
			}
		return $this;
	}
	
		public  function table($table){
					if ($this->tableExists($table)){
					$this->table = $table;
				}else{
					die('Table '.$table.' Not Found');
				}
					return $this;
				}
			   public function tableExists($table) {
			        $query = $this->db->prepare("SHOW TABLES LIKE :table");
			        $query->execute(['table' => $table]);
			        return $query->rowCount() > 0;
			    }
				public function where($column  , $value , $operator = '='){
						$q =  "WHERE `$column` $operator " . (gettype($value) === 'string' ? "'$value'" : "$value");

							$this->where =  $q;
						return $this;
				}


				public function andWhere($column  , $value , $operator = '='){
						$d = (gettype($value) === 'string' ? "'$value'" : "$value");
						$q =  " AND  `$column` $operator " . $d;
							$this->where .=  $q;
						return $this;
				}


						public function orWhere($column  , $value , $operator = '='){
							
						$d = (gettype($value) === 'string' ? "'$value'" : "$value");

						$q =  " OR  `$column` $operator " . $d;

							$this->where .=  $q;

						return $this;
				}



				public function get($col = ['*']){
					
							try{


									$col = is_array($col) ? implode(',' ,$col) : $col ;


						$q = "SELECT ". $col." FROM `" . $this->table . '` ' . $this->where;




						$data = $this->db->prepare($q);

						$data->execute();


						$data = $data->fetchALL(PDO::FETCH_ASSOC);



								return $data;

							}catch(PDOException $e){
								die($e->getMessage());
							}


				}


				
					public  function create($data){
						
						try{

						$totalColumns = count($data);
    					$currentIndex = 0;

						$query = '';
						$columns = '(';
						$rows = '(';

						foreach ($data as $col => $row) {
								$columns .= " $col ";
								$rows .= gettype($row) === 'integer' ? "$row" : "'$row'"  ;


								 if (++$currentIndex < $totalColumns) {
            						$columns .= ', ';
            						$rows .= ', ';
        							}
						

						}

							$columns .= ')';
							$rows .= ')';


								$query = "INSERT INTO ".$this->table." $columns VALUES $rows";

									$data = $this->db->prepare($query);

									$data->execute();

									$data = $data->fetchALL(PDO::FETCH_ASSOC);



	
							return null;

					}catch(PDOException $e){
						die($e->getMessage());
					}

				}



				public function update($data){
					try{

					$query = "UPDATE  `" . $this->table . "` SET ";
				

						$cols = [];

							foreach ($data as $row => $newValue) {
							$cols[] = "`$row` = '$newValue'";

							}

							$cols = implode(' , ',$cols);


							$query .= $cols;
							


									$data = $this->db->prepare($query);

									$data->execute();


										return null;

				
									}catch(PDOException $e){
										die($e);
									}
				}


					public function first($col = '*')
					{
					


							try{

						$q = "SELECT $col FROM `" . $this->table . '` ' . $this->where . " LIMIT 1";

						$data = $this->db->prepare($q);

						$data->execute();


						$data = $data->fetchALL(PDO::FETCH_ASSOC);


								return $data;

							}catch(PDOException $e){
								die($e->getMessage());
							}

					}


						public  function all($limit = null){

							$cond =  $limit ? "LIMIT $limit" : '';

							$getALl = $this->db->prepare("SELECT * FROM " . $this->table . "  $cond"  );

							$getALl->execute();

							$getALl = $getALl->fetchALL(PDO::FETCH_ASSOC);

							return $getALl;

						}



						public function destroy(){
							try{


							$query = "DELETE FROM " . $this->table . " " . $this->where;


								$query = $this->db->prepare($query);

								$query->execute();


								if ($query){
									return 'Done';
								}

									
							}catch(PDOException $e){
								die($e);
							}

						}




						public function close()
						{
							$this->db = null;
						}




						public function statement($query)
						{
							$query = $this->db->prepare($query);

							$query->execute();


							return $query->fetchALL(PDO::FETCH_ASSOC);
						}



						public function orderBy($col ,  $o = 'ASC'){
							
									try{
										$o = strtoupper($o);


								$this->where .= " ORDER BY $col $o";

									return $this;


								}catch(PDOException $e){
									die($e);
								}
						}


									public function truncate(){
						
									$this->statement('TRUNCATE TABLE ' . $this->table);
					}





}





	trait Main{

 				public function tableExists($table) {
						$query = DB->statement("SHOW TABLES LIKE '$table'");

			        return count($query) > 0;
			    }

} 



