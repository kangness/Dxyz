<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_common_plugin.php 27738 2012-02-13 10:02:53Z monkey $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_common_plugin extends discuz_table
{
	public function __construct() {

		$this->_table = 'common_plugin';
		$this->_pk    = 'pluginid';

		parent::__construct();
	}

	public function fetch_by_identifier($identifier) {
		return Dxyz_DB::fetch_first('SELECT * FROM %t WHERE identifier=%s', array($this->_table, $identifier));
	}

	public function fetch_all_data($available = false) {
		$available = $available !== false ? 'WHERE available='.intval($available) : '';
		return Dxyz_DB::fetch_all('SELECT * FROM %t %i ORDER BY available DESC, pluginid DESC', array($this->_table, $available));
	}

	public function fetch_all_by_identifier($identifier) {
		if(!$identifier) {
			return;
		}
		return Dxyz_DB::fetch_all('SELECT * FROM %t WHERE %i', array($this->_table, Dxyz_DB::field('identifier', $identifier)));
	}

	public function fetch_by_pluginvarid($pluginid, $pluginvarid) {
		return Dxyz_DB::fetch_first("SELECT * FROM %t p, %t pv WHERE p.pluginid=%d AND pv.pluginid=p.pluginid AND pv.pluginvarid=%d",
			array($this->_table, 'common_pluginvar', $pluginid, $pluginvarid));
	}

	public function delete_by_identifier($identifier) {
		if(!$identifier) {
			return;
		}
		Dxyz_DB::delete('common_plugin', Dxyz_DB::field('identifier', $identifier));
	}

}

?>