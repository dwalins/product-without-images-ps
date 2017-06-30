<?php
/**
* 2007-2017 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2017 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

class Productwithoutimages extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'productwithoutimages';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'Roberto';
        $this->need_instance = 0;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Products without images');
        $this->description = $this->l('This module shows the product withoutimages');

        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        Configuration::updateValue('PRODUCTWITHOUTIMAGES_LIVE_MODE', false);

        return parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('backOfficeHeader') &&
            $this->registerHook('displayAdminOrderTabOrder');
    }

    public function uninstall()
    {
        Configuration::deleteByName('PRODUCTWITHOUTIMAGES_LIVE_MODE');

        return parent::uninstall();
    }

    /**
     * Load the configuration form
     */
    public function getContent()
    {
        /**
         * If values have been submitted in the form, process.
         */
        if (((bool)Tools::isSubmit('submitProductwithoutimagesModule')) == true) {
            $this->postProcess();
        }

        $this->context->smarty->assign('module_dir', $this->_path);

        return $this->renderProducts();
		
		
    }
	
	public function renderProducts()
	{
		$sql = "SELECT DISTINCT(`"._DB_PREFIX_."product_shop`.`id_product`) , `"._DB_PREFIX_."product_shop`.`active`,`"._DB_PREFIX_."product_lang`.`name`
		FROM `"._DB_PREFIX_."product_shop`
		INNER JOIN `"._DB_PREFIX_."product_lang` ON `"._DB_PREFIX_."product_shop`.`id_product`=`"._DB_PREFIX_."product_lang`.`id_product`
		LEFT JOIN `"._DB_PREFIX_."image` ON `"._DB_PREFIX_."product_shop`.`id_product` = `"._DB_PREFIX_."image`.`id_product`
		WHERE `"._DB_PREFIX_."image`.`id_product` IS NULL
		AND `"._DB_PREFIX_."product_shop`.`active` =1
		GROUP BY `"._DB_PREFIX_."product_shop`.`id_product`";
		
		$results = Db::getInstance()->executeS($sql);
		
		foreach($results as $key => $result){
			$results[$key]['url'] = $this->context->link->getAdminLink('AdminProducts', true)."id_product=". $result['id_product'] ."&updateproduct";
		}
		
		$this->context->smarty->assign(array(
			'no_image_products' => $results,
		));

		return $this->display(__FILE__, 'stats.tpl');
	}
    

    /**
    * Add the CSS & JavaScript files you want to be loaded in the BO.
    */
    public function hookBackOfficeHeader()
    {
        if (Tools::getValue('module_name') == $this->name) {
            $this->context->controller->addJS($this->_path.'views/js/back.js');
            $this->context->controller->addCSS($this->_path.'views/css/back.css');
        }
    }

    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookHeader()
    {
        $this->context->controller->addJS($this->_path.'/views/js/front.js');
        $this->context->controller->addCSS($this->_path.'/views/css/front.css');
    }

    public function hookDisplayAdminOrderTabOrder()
    {
        /* Place your code here. */
    }
}
