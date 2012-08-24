<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_common_block_style.php 28634 2012-03-06 10:24:30Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_common_block_style extends discuz_table
{
	public function __construct() {

		$this->_table = 'common_block_style';
		$this->_pk    = 'styleid';

		parent::__construct();
	}

	public function fetch_all_by_blockclass($blockclass) {
		return $blockclass ? Dxyz_DB::fetch_all('SELECT * FROM %t WHERE blockclass=%s', array($this->_table, $blockclass), $this->_pk) : array();
	}

	public function fetch_all_by_hash($hash) {
		return $hash ? Dxyz_DB::fetch_all('SELECT * FROM %t WHERE `hash` IN (%n)', array($this->_table, $hash), $this->_pk) : array();
	}

	public function count_by_where($wheresql) {
		$wheresql = $wheresql ? ' WHERE '.(string)$wheresql : '';
		return Dxyz_DB::result_first('SELECT COUNT(*) FROM '.Dxyz_DB::table($this->_table).$wheresql);
	}

	public function fetch_all_by_where($wheresql, $ordersql, $start, $limit) {
		$wheresql = $wheresql ? ' WHERE '.(string)$wheresql : '';
		return Dxyz_DB::fetch_all('SELECT * FROM '.Dxyz_DB::table($this->_table).$wheresql.' '.(string)$ordersql.Dxyz_DB::limit($start, $limit), null, $this->_pk ? $this->_pk : '');
	}

	public function insert_batch($styles) {
		$inserts = array();
		foreach($styles as $value) {
			if(!empty($value['blockclass'])) {
				$value = daddslashes($value);
				$inserts[] = "('$value[blockclass]', '$value[name]', '$value[template]', '$value[hash]', '$value[getpic]', '$value[getsummary]', '$value[settarget]', '$value[fields]', '$value[moreurl]')";
			}
		}
		if(!empty($inserts)) {
			Dxyz_DB::query('INSERT INTO '.Dxyz_DB::table($this->_table)."(`blockclass`, `name`, `template`, `hash`, `getpic`, `getsummary`, `settarget`, `fields`, `moreurl`) VALUES ".implode(',',$inserts));
		}
	}

	public function update($val, $data, $unbuffered = false, $low_priority = false) {
		if(($val = dintval($val, true)) && $data && is_array($data)) {
			$this->_pre_cache_key = 'blockstylecache_';
			$this->_cache_ttl = getglobal('setting/memory/diyblock/ttl');
			$this->_allowmem = getglobal('setting/memory/diyblock/enable') && memory('check');
			return parent::update($val, $data, $unbuffered, $low_priority);
		}
		return false;
	}

	public function delete($val, $unbuffered = false) {
		if(($val = dintval($val, true))) {
			$this->_pre_cache_key = 'blockstylecache_';
			$this->_cache_ttl = getglobal('setting/memory/diyblock/ttl');
			$this->_allowmem = getglobal('setting/memory/diyblock/enable') && memory('check');
			return parent::delete($val, $unbuffered);
		}
		return false;
	}
}

?>