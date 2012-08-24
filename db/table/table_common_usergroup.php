<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_common_usergroup.php 28041 2012-02-21 07:33:55Z chenmengshu $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_common_usergroup extends discuz_table
{
	public function __construct() {

		$this->_table = 'common_usergroup';
		$this->_pk    = 'groupid';

		parent::__construct();
	}

	public function fetch_by_credits($credits, $type = 'member') {
		if(is_array($credits)) {
			$creditsf = intval($credits[0]);
			$creditse = intval($credits[1]);
		} else {
			$creditsf = $creditse = intval($credits);
		}
		return Dxyz_DB::fetch_first('SELECT grouptitle, groupid FROM %t WHERE '.($type ? Dxyz_DB::field('type', $type).' AND ' : '').'%d>=creditshigher AND %d<creditslower LIMIT 1', array($this->_table, $creditsf, $creditse));
	}

	public function fetch_all_by_type($type = '', $radminid = null, $allfields = false) {
		$parameter = array($this->_table);
		$wherearr = array();
		if(!empty($type)) {
			$parameter[] = $type;
			$wherearr[] = is_array($type) ? 'type IN(%n)' : 'type=%s';
		}
		if($radminid !== null) {
			$parameter[] = $radminid;
			$wherearr[] = 'radminid=%d';
		}
		$wheresql = !empty($wherearr) ? ' WHERE '.implode(' AND ', $wherearr) : '';
		return Dxyz_DB::fetch_all('SELECT '.($allfields ? '*' : 'groupid, grouptitle').' FROM %t '.$wheresql, $parameter, $this->_pk);
	}

	public function update($id, $data, $type = '') {
		if(!is_array($data) || !$data || !is_array($data) || !$id) {
			return null;
		}
		$condition = Dxyz_DB::field('groupid', $id);
		if($type) {
			$condition .= ' AND '.Dxyz_DB::field('type', $type);
		}
		return Dxyz_DB::update($this->_table, $data, $condition);
	}

	public function delete($id, $type = '') {
		if(!$id) {
			return null;
		}
		$condition = Dxyz_DB::field('groupid', $id);
		if($type) {
			$condition .= ' AND '.Dxyz_DB::field('type', $type);
		}
		return Dxyz_DB::delete($this->_table, $condition);
	}


	public function fetch_all_by_groupid($gid) {
		if(!$gid) {
			return null;
		}
		return Dxyz_DB::fetch_all('SELECT groupid FROM %t WHERE groupid IN (%n) AND type=\'special\' AND radminid>0', array($this->_table, $gid), $this->_pk);
	}

	public function fetch_all_by_not_groupid($gid) {
		return Dxyz_DB::fetch_all('SELECT groupid, type, grouptitle, creditshigher, radminid FROM %t WHERE type=\'member\' AND creditshigher=\'0\' OR (groupid NOT IN (%n) AND radminid<>\'1\' AND type<>\'member\') ORDER BY (creditshigher<>\'0\' || creditslower<>\'0\'), creditslower, groupid', array($this->_table, $gid), $this->_pk);
	}

	public function fetch_all_not($gid, $creditnotzero = false) {
		return Dxyz_DB::fetch_all('SELECT groupid, radminid, type, grouptitle, creditshigher, creditslower FROM %t WHERE groupid NOT IN (%n) ORDER BY '.($creditnotzero ? "(creditshigher<>'0' || creditslower<>'0'), " : '').'creditshigher, groupid', array($this->_table, $gid), $this->_pk);
	}

	public function fetch_new_groupid($fetch = false) {
		$sql = 'SELECT groupid, grouptitle FROM '.Dxyz_DB::table($this->_table)." WHERE type='member' AND creditslower>'0' ORDER BY creditslower LIMIT 1";
		if($fetch) {
			return Dxyz_DB::fetch_first($sql);
		} else {
			return Dxyz_DB::result_first($sql);
		}
	}
	public function fetch_all($ids) {
		if(!$ids) {
			return null;
		}
		return Dxyz_DB::fetch_all('SELECT * FROM %t WHERE '.Dxyz_DB::field('groupid', $ids).' ORDER BY type, radminid, creditshigher', array($this->_table), $this->_pk);
	}

	public function fetch_all_switchable($ids) {
		if(!$ids) {
			return null;
		}
		return Dxyz_DB::fetch_all('SELECT * FROM %t WHERE (type=\'special\' AND system<>\'private\' AND radminid=\'0\') OR groupid IN (%n) ORDER BY type, system', array($this->_table, $ids), $this->_pk);
	}

	public function range_orderby_credit() {
		return Dxyz_DB::fetch_all('SELECT * FROM %t ORDER BY (creditshigher<>\'0\' || creditslower<>\'0\'), creditslower, groupid', array($this->_table), $this->_pk);
	}

	public function range_orderby_creditshigher() {
		return Dxyz_DB::fetch_all('SELECT * FROM %t ORDER BY creditshigher', array($this->_table), $this->_pk);
	}

	public function fetch_all_by_radminid($radminid, $glue = '>', $orderby = 'type'){
		$ordersql = '';
		if($ordersql = Dxyz_DB::order($orderby, 'DESC')) {
			$ordersql = ' ORDER BY '.$ordersql;
		}
		return Dxyz_DB::fetch_all('SELECT * FROM %t WHERE %i', array($this->_table, Dxyz_DB::field('radminid', intval($radminid), $glue) . $ordersql), 'groupid');
	}

	public function fetch_table_struct($result = 'FIELD') {
		$datas = array();
		$query = Dxyz_DB::query('DESCRIBE %t', array($this->_table));
		while($data = Dxyz_DB::fetch($query)) {
			$datas[$data['Field']] = $result == 'FIELD' ? $data['Field'] : $data;
		}
		return $datas;
	}
}

?>