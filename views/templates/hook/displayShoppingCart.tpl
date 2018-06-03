{*
 *
 *  @author Mustapha Boulouh <<comforyou.fr>>
 *  @web  http://www.comforyou.fr
 *  @copyright  2017 CFY
 *
*}

{if isset ($confirmation) }
{if $mode_transport eq '0'}
<div class="alert alert-success" >
<h4> vous informe!</h4>
 <h5 class="alert-heading">Vous avez selectionner le mode :</h5><strong>Retrait En boutique </strong>.</p>  
</div>
{/if}
{if $mode_transport eq '1'}
<div class="alert alert-success">
<h4>vous informe!</h4>
 <h5 class="alert-heading">Vous avez selectionner le mode :</h5>
<strong>En Livraison. </strong>   
</div>
<div class=" container-fluid alert alert-info">
  <div class="col-xs-12 pr-0 pl-0 flex-container flex-wrap">
    <div class="col-xs-6 col-sm-8 flex-self-center">
      <span><strong>Frais de livraison :</strong>
      <br>{if empty($address)}Vous n'avez pas saisie votre adresse {else}   {$address} {/if}</span>
    </div>
    <div>
      <span class="text-uppercase"><strong>{if empty($frais_livraison )} OFFERT {else} {$frais_livraison} € {/if}</strong></span>
    </div>
  </div>
</div>
{/if}
{/if}