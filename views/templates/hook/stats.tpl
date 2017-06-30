{*
* 2007-2016 PrestaShop
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
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2016 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<div class="panel" id="fieldset_4">
    <h3><i class="icon-bar-chart"></i> {l s='Product without images' mod='productwithuoutimages'}</h3>
	<table class="table">
		<tr>
			<th>{l s='ID product' mod='productwithuoutimages'}</th>
			<th>{l s='Product name' mod='productwithuoutimages'}</th>
			<th>{l s='Active?' mod='productwithuoutimages'}</th>
			<th></th>
		</tr>
		{foreach from=$no_image_products key='key' item='val'}
				<tr>
					<td>{$val.id_product|escape:'htmlall':'UTF-8'}</td>
					<td><a href="{$val.url}" target="_blank">{$val.name|escape:'htmlall':'UTF-8'}</a></td>
					<td>{$val.active|escape:'htmlall':'UTF-8'}</td>
					<td><a href="{$val.url}" target="_blank" class="edit btn btn-default">{l s='Edit'}</a></td>
				</tr>
			
		{foreachelse}
			<tr>
				<td colspan="13" style="font-weight: bold; text-align: center;">{l s='Well done, all your products have an image.' mod='productwithuoutimages'}</td>
			</tr>
		{/foreach}
	</table>
</div>
