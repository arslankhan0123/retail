<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Updates_model extends CI_Model {

	public $app_version = null;
	public $db_version = null;
	public $version_check = array();

	public function __construct()
	{
		parent::__construct();
		//Do your magic here

		//$this->app_version = (float)app_version();

		//$this->version_check =array(2.8);

		$this->db_version = $this->get_current_version_of_db();

	}

	public function get_current_version_of_db(){

      return $this->db->select('version')->from('db_sitesettings')->get()->row()->version;

    }

	public function index()
	{
		$result = $this->db->query("SHOW COLUMNS FROM `db_store` LIKE 'allow_negative_stock'");
		if(!$result->num_rows()){
			$q1 = $this->db->query("ALTER TABLE `db_store` ADD COLUMN `allow_negative_stock` TINYINT(1) NOT NULL DEFAULT 0 AFTER `round_off`");
			if(!$q1){ echo "failed"; exit(); }
		}

		$result = $this->db->query("SHOW COLUMNS FROM `db_store` LIKE 'branch_first_name'");
		if(!$result->num_rows()){
			$q1 = $this->db->query("ALTER TABLE `db_store` ADD COLUMN `branch_first_name` VARCHAR(150) NULL AFTER `store_name`, ADD COLUMN `branch_last_name` VARCHAR(250) NULL AFTER `branch_first_name`");
			if(!$q1){ echo "failed"; exit(); }
		}
		$this->db->query("UPDATE `db_store` SET `branch_first_name`=SUBSTRING_INDEX(TRIM(`store_name`),' ',2), `branch_last_name`=TRIM(SUBSTRING(TRIM(`store_name`),LENGTH(SUBSTRING_INDEX(TRIM(`store_name`),' ',2))+1)) WHERE (`branch_first_name` IS NULL OR TRIM(`branch_first_name`)='') AND `store_name` IS NOT NULL AND TRIM(`store_name`)<>''");

		if($this->db_version <=2.8){
			
			$result = $this->db->query("SHOW COLUMNS FROM `db_store` LIKE 'qty_decimals'");

            if(!$result->num_rows()){
            	//Update for 2.8 version only
				$q1 = $this->db->query("ALTER TABLE `db_store` ADD COLUMN `qty_decimals` INT(5) DEFAULT 2 NULL");if(!$q1){ echo "failed"; exit();}
            }
			

		}

	}

}
