<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_common_setting.php 28617 2012-03-06 08:30:36Z songlixin $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_common_setting extends discuz_table
{
	public function __construct() {

		$this->_table = 'common_setting';
		$this->_pk    = 'skey';

		parent::__construct();
	}

	public function fetch($skey, $auto_unserialize = false) {
		$data = Dxyz_DB::result_first('SELECT svalue FROM '.Dxyz_DB::table($this->_table).' WHERE '.Dxyz_DB::field($this->_pk, $skey));
		return $auto_unserialize ? (array)unserialize($data) : $data;
	}

	public function fetch_all($skeys = array(), $auto_unserialize = false){
		$data = array();
		$where = !empty($skeys) ? ' WHERE '.Dxyz_DB::field($this->_pk, $skeys) : '';
		$query = Dxyz_DB::query('SELECT * FROM '.Dxyz_DB::table($this->_table).$where);
		while($value = Dxyz_DB::fetch($query)) {
			$data[$value['skey']] = $auto_unserialize ? (array)unserialize($value['svalue']) : $value['svalue'];
		}
		return $data;
	}

	public function update($skey, $svalue){
		return Dxyz_DB::insert($this->_table, array($this->_pk => $skey, 'svalue' => is_array($svalue) ? serialize($svalue) : $svalue), false, true);
	}

	public function update_batch($array) {
		$settings = array();
		foreach($array as $key => $value) {
			$key = addslashes($key);
			$value = addslashes(is_array($value) ? serialize($value) : $value);
			$settings[] = "('$key', '$value')";
		}
		if($settings) {
			return Dxyz_DB::query("REPLACE INTO ".Dxyz_DB::table('common_setting')." (`skey`, `svalue`) VALUES ".implode(',', $settings));
		}
		return false;
	}

	public function skey_exists($skey) {
		return Dxyz_DB::result_first('SELECT skey FROM %t WHERE skey=%s LIMIT 1', array($this->_table, $skey)) ? true : false;
	}

	public function fetch_all_not_key($skey) {
		return Dxyz_DB::fetch_all('SELECT * FROM '.Dxyz_DB::table($this->_table).' WHERE skey NOT IN('.dimplode($skey).')');
	}

	public function fetch_all_table_status() {
		return Dxyz_DB::fetch_all('SHOW TABLE STATUS');
	}

	public function get_tablepre() {
		return Dxyz_DB::object()->tablepre;
	}

	public function update_count($skey, $num) {
		return Dxyz_DB::query("UPDATE %t SET svalue = svalue + %d WHERE skey = %s", array($this->_table, $num, $skey), false, true);
	}

}

?>