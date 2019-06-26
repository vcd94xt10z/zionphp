<?php
namespace zion\mod\waf\controller;

use zion\mod\waf\standard\controller\IpLocationController AS StandardIpLocationController;

/**
 * Classe gerada pelo Zion Framework em 26/06/2019
 */
class IpLocationController extends StandardIpLocationController {
	public function __construct(){
		parent::__construct(get_class($this),array(
			"table" => "zion_waf_ip_location"
		));
	}
}
?>