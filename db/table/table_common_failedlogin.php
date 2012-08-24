<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_common_failedlogin.php 30409 2012-05-28 02:53:10Z liulanbo $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_common_failedlogin extends discuz_table
{
	public function __construct() {

		$this->_table = 'common_failedlogin';
		$this->_pk    = '';

		parent::__construct();
	}

	public function fetch_username($ip, $username) {
		return Dxyz_DB::fetch_first("SELECT * FROM %t WHERE ip=%s AND username=%s", array($this->_table, $ip, $username));
	}
	public function fetch_ip($ip) {
		return Dxyz_DB::fetch_first("SELECT * FROM %t WHERE ip=%s", array($this->_table, $ip));
	}

	public function delete_old($time) {
		Dxyz_DB::query("DELETE FROM %t WHERE lastupdate<%d", array($this->_table, TIMESTAMP - intval($time)), 'UNBUFFERED');
	}

	public function update_failed($ip, $username) {
		Dxyz_DB::query("UPDATE %t SET count=count+1, lastupdate=%d WHERE ip=%s", array($this->_table, TIMESTAMP, $ip));
	}

}

?>