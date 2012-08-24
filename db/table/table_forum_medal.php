<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_forum_medal.php 27745 2012-02-14 01:43:38Z monkey $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_forum_medal extends discuz_table
{
	public function __construct() {

		$this->_table = 'forum_medal';
		$this->_pk    = 'medalid';

		parent::__construct();
	}

	public function fetch_all_data($available = false) {
		$available = $available !== false ? ' WHERE available='.intval($available) : '';
		return Dxyz_DB::fetch_all('SELECT * FROM %t %i ORDER BY displayorder', array($this->_table, $available));
	}
	public function fetch_all_name_by_available($available = 1) {
		$data = array();
		foreach($this->fetch_all_data($available) as $value) {
			$data[$value['medalid']] = array('medalid' => $value['medalid'], 'name' => $value['name']);
		}
		return $data;
	}

	public function count_by_available() {
		return Dxyz_DB::result_first('SELECT COUNT(*) FROM %t WHERE available=1', array($this->_table));
	}


	public function fetch_all_by_id($id) {
		if(!$id) {
			return;
		}
		return Dxyz_DB::fetch_all("SELECT * FROM %t WHERE %i ORDER BY displayorder", array($this->_table, Dxyz_DB::field('medalid', $id)));
	}



}

?>