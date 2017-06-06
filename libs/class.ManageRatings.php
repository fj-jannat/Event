<?php

	class ManageRatings{

		protected $link;
		protected $db_host = 'localhost';
		protected $db_name = 'property';
		protected $db_user = 'root';
		protected $db_pass = '';

		function __construct(){
			try{
				$this->link = new PDO("mysql:host=$this->db_host;dbname=$this->db_name",$this->db_user,$this->db_pass);
				return $this->link;
			}
			catch(Exception $e)
			{
				return $e->getMessage;
			}
		}
		
		function getItems($id = null){
			if(isset($id)){
				$query = $this->link->query("SELECT * FROM property WHERE id = '$id'");
			}
			else
			{
				$query = $this->link->query("SELECT * FROM property");
			}
			$rowCount = $query->rowCount();
			if($rowCount >= 1)
			{
				$result = $query->fetchAll();
			}
			else
			{
				$result = 0;
			}
			return $result;
		}
		
		function getHotItems($id = null){
			if(isset($id)){
				$query = $this->link->query("SELECT * FROM property WHERE id = '$id'");
			}
			else
			{
				$query = $this->link->query("SELECT * FROM property WHERE hot='yes' and status=''");
			}
			$rowCount = $query->rowCount();
			if($rowCount >= 1)
			{
				$result = $query->fetchAll();
			}
			else
			{
				$result = 0;
			}
			return $result;
		}

		function getSearchedItems($location,$cat,$property_type,$max_price){
			
			$query = $this->link->query("SELECT * FROM property where (region = '$location' or city = '$location')
											and category = '$cat' and type = '$property_type' and price <= $max_price");
			$rowCount = $query->rowCount();
			
			if($rowCount >= 1){
				$result = $query->fetchAll();
			}else{
				$result = 0;
			}

			return $result;
		}
		
		function insertRatings($id,$rating,$total_rating,$total_rates,$ip_address){
			$query = $this->link->query("UPDATE property
			SET rating = '$rating',
			total_rating = '$total_rating',
			total_rates = '$total_rates',
			ip_address = CONCAT(ip_address,',$ip_address') WHERE id = '$id'");

			$rowCount = $query->rowCount();
			return $rowCount;
		}
	}
?>