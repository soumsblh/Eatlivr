{*
 *
 *  @author Mustapha Boulouh <<comforyou.fr>>
 *  @web	http://www.comforyou.fr
 *  @copyright  2017 CFY
 *
*}
<div id="formAddPaymentPanel" class="panel">
	<div class="panel-heading">
		<i class="icon-truck"></i>
		EAT'LIVRE 
	</div>
		<form id="formAddPayment" method="post" action="index.php?controller=AdminOrders&amp;vieworder&amp;id_order=5&amp;token=8c23b4c261ca33c9981febbd42ac4e5f">
			<div class="table-responsive">
				<table class="table">
					<thead>
						<tr>
						<th><span class="title_box " >Date</span></th>
						<th><span class="title_box ">Type de transport</span></th>
						<th><span class="title_box ">ID de la commande</span></th>
						<th><span class="title_box ">Adresse</span></th>
						<th></th>
						</tr>
					</thead>
					{if isset ($livraison)}
					<tbody>
						<tr>
							<td>{date('d/m/Y')}</td>
							{if $livraison eq '1' }
							<td>Livraison</td>
							{else}
							<td>emporter</td>
							{/if}
							<td >{$id_commande}</td>
							<td class="price_carrier_2"><span>{$adress}</span></td>
							<td><span class="shipping_number_show"></span></td>
						</tr>
					</tbody>
					{else}
					<tbody>
						<tr>
						<td class="list-empty hidden-print" colspan="6">
						<div class="list-empty-msg">
						<i class="icon-warning-sign list-empty-icon"></i>
						Aucun livraison pour cette commande 
						</div>
						</td>
						</tr>
					</tbody>
					{/if}
				</table>
			</div>
		</form>
	</div>