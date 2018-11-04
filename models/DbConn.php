<?php
namespace Model;
/**
 * default class for connecting to a database.
 * only supports mysql and sqlite
 */
abstract class DbConn {
	private $_db;

	protected $_table_name;
	protected $_data;
	protected $_fields;

	public function __construct() {

		try {
			if(\Config\Db::DRIVER=='mysql') {
				$this->_db = new \PDO('mysql:host='.\Config\Db::HOST.';dbname='.\Config\Db::DBNAME.';charset=utf8mb4',\Config\Db::USERNAME,\Config\Db::PASSWORD);
			} else if(\Config\Db::DRIVER=='sqlite3') {
				$this->_db = new \PDO(\Config\Db::DRIVER.':'.APP_ROOT.'/db/'.\Config\Db::DBNAME.'.sqlite');
			} else {
				die('Invalid driver');
			}
		} catch(Exception $e) {
			die($e->getMessage());
		}
	}

	public function getDb() {
		return $this->_db;
	}

	/**
	 * set data for field if it exists
	 */
	public function setData($field,$value) {
		if(in_array($field,$this->_fields)) {
			$this->_data[$field] = $value;
		}

		return $this;
	}

	/**
	 * get record data
	 */
	public function getData($key=null) {
		if($key==null) {
			return $this->_data;
		}

		if(isset($this->_data[$key])) {
			return $this->_data[$key];
		}

		return null;
	}

	/**
	 * load a single record by primary id
	 * @param $id: unique id of a record
	 */
	public function load($id) {
		$id = filter_var($id,FILTER_VALIDATE_INT);
		if($id===false) {
			return $this;
		}
		$statement = $this->getDb()->prepare('SELECT * FROM '.$this->_table_name
		.' WHERE '.$this->_id.'=:id');

		$statement->bindParam(':id',$id);

		if($statement->execute() && $row = $statement->fetch()) {
			foreach($this->_fields as $field) {
				if(isset($row[$field])) {
					$this->_data[$field] = $row[$field];
				}
			}

		}

		return $this;
	}

	/**
	 * save new record to database
	 * TODO: allow to update record if primary id is present
	 */
	public function save() {
		$columns = array();
		foreach($this->_fields as $field) {
			if(isset($this->_data[$field])) {
				$columns[] = $field;
			}
		}

		$bind_params = array_map(function($v){return ':'.$v;},$columns);

		$query = 	$query = 'INSERT INTO ' . $this->_table_name
			.' ('.implode(',',$columns).')'
			.' VALUES ('.implode(',',$bind_params).')';

				$statement = $this->getDb()->prepare($query);
				foreach($columns as $field) {
					$statement->bindParam(':'.$field,$this->_data[$field]);
				}

				if($statement->execute()) {
					$this->load($this->getDb()->lastInsertId());
					return true;
				} else {
					return false;
				}
	}

}
