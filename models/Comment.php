<?php
namespace Model;

class Comment extends DbConn {


	public function __construct() {
		parent::__construct();

		$this->_table_name = 'comments';
		$this->_id = 'id';

		$this->_fields = array('id','content','author','parent_id','level','created_at');
	}


	/**
	 * get all comments by order based first on depth, and then by created date
	 * @return $data
	 */
	public function getAllByOrder() {
		$statement = $this->getDb()->query('SELECT * FROM '.$this->_table_name
			.' WHERE level=0 ORDER BY level ASC,created_at DESC');

		$comments = array();
		if($statement->execute()) {
			while($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
				$children = $this->getChildComments($row['id']);
				$comments[] = array_merge($row,array('children'=>$children));
			}
		}

		$res = array('comments'=>$comments);

		return $res;
	}

	/**
	 * get list of comments based on parent id
	 */
	public function getChildComments($parent_id) {
		$statement = $this->getDb()->prepare('SELECT * FROM '.$this->_table_name
			.' WHERE parent_id=:parent_id ORDER BY level ASC,created_at DESC');

		$statement->bindParam(':parent_id',$parent_id);

		$comments = array();

		if($statement->execute()) {
			while($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
				$children = $this->getChildComments($row['id']);
				$comments[] = array_merge($row,array('children'=>$children));
			}
		}

		return $comments;

	}


	/**
	 * migration function to create table for this model
	 */
	public function migrate() {
		try {
		$this->getDb()->query('CREATE TABLE `'.$this->_table_name.'`
		(
			`id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			`author` VARCHAR(100),
			`content` VARCHAR(500),
			`parent_id` INT,
			`level` INT,
			`created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
		);');
		} catch(Exception $e) {
			echo $e->getMessage();
		}
	}


}
