<?php

require (__DIR__.'/src/DB.php');  
require (__DIR__.'/src/Table.php');
	
use DB\DB;
use DB\Table;



		$table = new Table('videos');

		$table->string('name')->nullable(false); 
		$table->LongBinary('video');

		$table->execute();	

	