{*
 *
 *  @author Mustapha Boulouh <<comforyou.fr>>
 *  @web  http://www.comforyou.fr
 *  @copyright  2017 CFY
 *
*}

<button type="button" class="btn btn-primary fa fa-shopping-cart" data-toggle="modal" data-target="#Modal" aria-hidden="true"> Ajouter
</button>

<!-- Modal -->
<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" id="content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalLabel">Faite votre choix !</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <div class="modal-body">
      {if $livraison eq '1' }
        <a data-toggle="tab"  href="#infoliv" name="mode_transport" class="btn btn-block btn-primary text-uppercase" value="1" checked="checked" {if $mode_transport eq '1' }checked{/if} /> En livraison </a>
      {/if}
        <a data-toggle="tab" href="#infoemp" name="mode_transport" value="0" class="btn btn-block btn-primary text-uppercase"  checked="checked" {if $mode_transport eq '0' }checked{/if} /> À emporter </a>
    </div>
    <div class="tab-content">
  <div id="infoemp" class="tab-pane fade">
      <hr>
  <h3 style="text-align:center" name="emporter"> Emporter </h3>
      <div class="col-sm-12 alert alert-info">
       Vous avez choisi le mode  <strong>Emporter</strong>. Veuillez renseignier l'heure de votre passage
      </div>
        <h6 style="text-align:center;">Choissisez l'heure de récupération</h6>
          <form class="col-md-12" action="" method="POST" id="emporter-form">
            <select class="form-control" id="emporter" id="current_selected_time" name="current_selected_time" class="chosen select-delivery-time">
                <option value="{$temps_commande_emporter}">{$temps_commande_emporter} </option>
            </select>
          </form><br>
    <div class="modal-footer">
    <button type="submit" value="1" class="btn btn-primary" data-dismiss="modal"  onclick="myFunction()" class="btn btn-primary add-to-cart" data-button-action="add-to-cart" type="submit" {if !$product.add_to_cart_url} disabled{/if}>
            <i class="material-icons shopping-cart">&#xE547;</i>
            {l s='Add to cart' d='Shop.Theme.Actions'}</button>
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
    </div><!-- modal-footer -->
  </div>  <!-- infoemp -->
    <div id="infoliv" class="tab-pane fade">
      <hr>
        <h3 style="text-align:center"> Livraison </h3>
          <div class="alert alert-info">
            Vous avez choisi la <strong>Livraison</strong>. Il vous sera donner a la fin de ceux formulaire l'heure de livraison souhaiter.<br>
            <strong>Si votre adresse n'est pas reconnu</strong>, indiquez un adresse et utilisez le complément d'adresse pour apporter des précisions.
          </div>
          <form role="form" class="form-horizontal">
            <fieldset>
               <div class="form-group">
                <div class="col-sm-12">
                Address
                  <input id="address" name="address"
                         class="form-control" placeholder="Commencez à taper votre adresse ..." value="{$address}">
                </div>
              </div>
            </fieldset>
            <fieldset class="disabled">
              <div class="form-group">
                <div class="col-sm-6">
                Numeros
                  <input id="street_number" name="street_number" disabled="true" class="form-control">
                </div>
                 <div class="col-sm-6">
                 Rue
                  <input id="route" name="route" disabled="true" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-6">
                Ville
                  <input id="locality" name="locality" disabled="true" class="form-control">
                </div>
                <div class="col-sm-6">
                Région
                  <input id="administrative_area_level_1" name="administrative_area_level_1" disabled="true" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-6">
                Code Postal
                  <input id="postal_code" name="postal_code" disabled="true" class="form-control">
                </div>
                <div class="col-sm-6">
                Pays
                  <input id="country" name="country" disabled="true" class="form-control">
                  </div>
              </div>
            </fieldset>
          </form>
            <h6 style="text-align:center;">Choissisez l'heure de récupération</h6>
              <form class="col-md-12" action="" method="POST" id="emporter-form">
                  <select class="form-control" id="emporter">
                  {if isset($horaire_ouverture_semaine_matin)}
                    <option>Dès que possible dans {$temps_prepa_livraison + $temps_commande_livraison} min</option>
                    {else}
                    { l s='Commander Pour demain ! ci-dessous . '}
                    {/if}
                      {foreach from=$heure_livraison item='foo' }
                    <option>Aujourd'hui à {$foo}</option>
                      {/foreach}
                  </select>
              </form>
      <div class="modal-footer">
        <button type="submit" value="1" class="btn btn-primary" data-dismiss="modal"  onclick="myFunction()" class="btn btn-primary add-to-cart"
            data-button-action="add-to-cart"
            type="submit"
            {if !$product.add_to_cart_url}
              disabled
            {/if}
          >
            <i class="material-icons shopping-cart">&#xE547;</i>
            {l s='Add to cart' d='Shop.Theme.Actions'}</button>
        <button type="submit" value="0" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
        </div>

              <script type="text/javascript"
           src="https://maps.googleapis.com/maps/api/js?libraries=places&amp;key=AIzaSyDt_7XawyN_Ql6ptLI6eyX6hKRC8eHzp2s"></script>
              
   </div> <!-- infoliv -->
  </div><!-- tab-content -->
</div><!-- modal-content -->
</div><!-- modal-dialog -->
</div><!-- modal fade-->
 {block name='product_availability'}
  <span id="product-availability">
    {if $product.show_availability && $product.availability_message}
      {if $product.availability == 'available'}
        <i class="material-icons product-available">&#xE5CA;</i>
      {elseif $product.availability == 'last_remaining_items'}
        <i class="material-icons product-last-items">&#xE002;</i>
      {else}
        <i class="material-icons product-unavailable">&#xE14B;</i>
      {/if}
      {$product.availability_message}
    {/if}
  </span>
{/block}
<style type="text/css">
  .pac-container {
    z-index: 100000;
}
</style>
