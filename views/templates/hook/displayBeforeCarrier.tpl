{*
 *
 *  @author Mustapha Boulouh <<comforyou.fr>>
 *  @web	http://www.comforyou.fr
 *  @copyright  2017 CFY
 *
*}
<table class="hookdisplybackcar">
{if isset ($mode_transport) }
	<p scope="row">
	{if $frais_livraison eq '0' } Livraison {l s='OFFERT'} {else} {l s='Les frais de livraison sont de '} {$frais_livraison} € {/if} 
		<strong>{if $mode_transport eq '1' } {l s='En livraison' } {/if}{if $mode_transport ne '0' } {l s= 'à Emporter '} {/if}</strong>
	</p>
	<p scope="row" >
	{if  $mode_transport = 'infoliv' } Date de livraison prévue le {else} Récupération possible le {/if} <strong> {date('d/m/Y')} {if  $mode_transport = 'imfoemp' } à 		
		{$heure_livraison} min {/if}</strong>
	</p>
{/if}
</table>

