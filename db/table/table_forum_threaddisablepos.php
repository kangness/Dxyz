<?php
/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_forum_threaddisablepos.php 27449 2012-03-01 05:32:35Z liulanbo $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class table_forum_threaddisablepos extends discuz_table {

	public function __construct() {
		$this->_table = 'forum_threaddisablepos';
		$this->_pk    = 'tid';
		parent::__construct();
	}
	public function truncate() {
		Dxyz_DB::query("TRUNCATE ".Dxyz_DB::table('forum_threaddisablepos'));
	}
}

?>