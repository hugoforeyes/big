  <?php
/**
* @version		$Id: gallery.php 3 2012-11-15 13:39 phu $
* @package		vFramework.cp.gallery
* @copyright	(C) 2012 Vipcom. All rights reserved.
* @license		Commercial
*/
defined('V_LIFE')or die('v');
class Gallery extends vCPController{public function __construct(){parent::__construct();if($o=$this->cfg['prop']){if(!isset($o['ctn'])||!$o['ctn']){unset($this->cfg['structure']['content']);unset($this->trans[1]);}if(isset($o['mti'])&&$o['mti'])$this->cfg['structure']['pic_full'].='s';else unset($this->cfg['structure']['pic_full_tit']);if(!isset($o['tit'])||!$o['tit'])unset($this->cfg['structure']['pic_full_tit']);if(!isset($o['pre'])||!$o['pre'])unset($this->cfg['structure']['preview']);if(!isset($o['ctn'])||!$o['ctn'])unset($this->cfg['structure']['content']);}}}$ctrl=new Gallery();$ctrl->exec();unset($ctrl);?>