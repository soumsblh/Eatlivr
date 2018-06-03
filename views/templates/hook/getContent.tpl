{*
 *
 *  @author Mustapha Boulouh <<comforyou.fr>>
 *  @web	http://www.comforyou.fr
 *  @copyright  2017 CFY
 *
 *
*}
{if isset ($confirmation) }
<div class="alert alert-success">
<strong>EAT'LIVRE</strong> à bien pris en compte vos modifications, veuillez actualiser votre page web pour voir vos modifications .
</div>
{/if}
<form method="POST" action="" class="defaultForm form-horizontal" id="set-liv-form">
<div class="panel">
<div class="panel-heading">
<i class="fa fa-clock-o"></i>
  LA CONFIGURATION DE EAT'LIVRE / TIME
</div>
<h2>Type / lieux de livraison</h2>
<div class="form-group row">
  <label for="example-text-input" class="col-lg-1 col-form-label">Type de Livraison Possible</label>
<label class="control-label col-lg-2">
 Emporter & Livraison
</label>
<div class="col-lg-8">
<span class="switch prestashop-switch fixed-width-lg">
<input type="radio" name="livraison" id="custom_livraison_on" value="1" checked="checked" {if $livraison eq '1' }checked{/if}/>
<label for="custom_livraison_on">Active</label>
<input type="radio" name="livraison" id="custom_livraison_on_off" value="0" {if $livraison eq '0' }checked{/if}/>
<label  for="custom_livraison_on_off">Désactivé</label>
<a class="slide-button btn"></a>
</span>
<p class="help-block">
Pour prendre en charge la livraison + à Emporter passez à "Activé", pour emporter seulement passez à "Désactivé".
</p>
</div>
</div>
<hr style="border-top: 1px dashed #8c8b8b;"></hr>

<h2>Temps de livraison</h2>
<label for="basic-url">Interval entre chaque livraison</label>
<div class="input-group">
  <input type="number" min="0" max="60" class="form-control" placeholder="
Insérer l'Intervalle de temps entre chaque livraison" aria-describedby="basic-addon2" name="temps_commande_livraison" id="temps_commande_livraison" value="{$temps_commande_livraison}">
  <span class="input-group-addon" id="basic-addon2">Minutes</span>
</div>
<label for="basic-url">Temps necéssaire a la préparation</label>
<div class="input-group">
  <input type="number" min="0" max="60" class="form-control" placeholder="Insérer le temps necéssaire a la préparation" aria-describedby="basic-addon2" name="temps_prepa_livraison" id="temps_prepa_livraison" value="{$temps_prepa_livraison}" >
  <span class="input-group-addon" id="basic-addon2">Minutes</span>
</div>
<label for="basic-url">Tarif Livraison</label>
<div class="input-group">
  <input type="number"  min="0" max="100" class="form-control" placeholder="Prix en Euro (arrondie) " aria-describedby="basic-addon2" name="frais_livraison" id="frais_livraison" value="{$frais_livraison}" >
  <span class="input-group-addon" id="basic-addon2">€</span>
</div>
<label for="basic-url">Distance à partir duquel les frais de livraison sont inputable</label>
<div class="input-group">
  <input type="number"  step="0.1" min="0" max="20"  class="form-control" placeholder="Distance en km" aria-describedby="basic-addon2" name="frais_kilometrique" id="frais_kilometrique" value="{$frais_kilometrique}">
  <span class="input-group-addon" id="basic-addon2">Km</span>
</div>

<hr style="border-top: 1px dashed #8c8b8b;"></hr>

<h2>Temps Emporter</h2>
<label for="basic-url">Interval entre chaque commande Emporter</label>
<div class="input-group">
  <input type="number"  min="0" max="30" class="form-control" placeholder="
Insérer l'Intervalle de temps entre chaque commande Emporter" aria-describedby="basic-addon2"  name="temps_commande_emporter" id="temps_commande_emporter" value="{$temps_commande_emporter}">
  <span class="input-group-addon" id="basic-addon2">Minutes</span>
</div>
<label for="basic-url">Temps necéssaire a la préparation</label>
<div class="input-group">
  <input type="number" min="0" max="60" class="form-control" placeholder="Insérer le temps necéssaire a la préparation" aria-describedby="basic-addon2" name="temps_prepa_emporter" id="temps_prepa_emporter" value="{$temps_prepa_emporter}" />
  <span class="input-group-addon" id="basic-addon2">Minutes</span>
</div>
  <hr style="border-top: 1px dashed #8c8b8b;"></hr>

  <h2>Horaires des livraisons</h2>
<div class="form-group">
</br>
    <h3>Semaine (Lundi au Vendredi)</h3>
  <div class="col-md-5">
    <label for="date-input" class="col-2 col-form-label">Matin</label>
    <input class="form-control" type="time" name="horaire_ouverture_semaine_matin" value="{$horaire_ouverture_semaine_matin}" id="date-input">
    <input class="form-control" type="time" name="horaire_fermeture_semaine_matin" value="{$horaire_fermeture_semaine_matin}" id="date-input1">
  </div>
  <div class="col-md-5">
    <label for="date-input2" class="col-2 col-form-label">Soir</label>
    <input class="form-control" type="time" name="horaire_ouverture_semaine_soir" value="{$horaire_ouverture_semaine_soir}" id="date-input3">
    <input class="form-control" type="time" name="horaire_fermeture_semaine_soir" value="{$horaire_fermeture_semaine_soir}" id="date-input4">
  </div>
</div>
</br>
<div class="form-group">
  </br>
  <h3>Week-End (Samedi au Dimanche)</h3>
  <div class="col-md-5">
    <label for="date-input3" class="col-2 col-form-label">Matin</label>
    <input class="form-control" type="time" name="horaire_ouverture_weekend_matin" value="{$horaire_ouverture_weekend_matin}" id="date-input5">
    <input class="form-control" type="time" name="horaire_fermeture_weekend_matin" value="{$horaire_fermeture_weekend_matin}" id="date-input6">
  </div>
  <div class="col-md-5">
    <label for="date-input4" class="col-2 col-form-label">Soir</label>
    <input class="form-control" type="time" name="horaire_ouverture_weekend_soir" value="{$horaire_ouverture_weekend_soir}" id="date-input7">
    <input class="form-control" type="time" name="horaire_fermeture_weekend_soir" value="{$horaire_fermeture_weekend_soir}" id="date-input8">
  </div>
</div>
</br>
<div class="form-group">
</br>
  <h3>Jours exceptionnels (fériés ou autres)</h3>
  <form>
  <div class="col-md-5">
    <label for="date-input5" class="col-2 col-form-label">Matin</label>
    <input class="form-control" type="time" name="horaire_ouverture_excp_matin" value="{$horaire_ouverture_excp_matin}" id="date-input9">
    <input class="form-control" type="time" name="horaire_fermeture_excp_matin" value="{$horaire_fermeture_excp_matin}" id="date-input10">
  </div>
  <div class="col-md-5">
    <label for="date-input6" class="col-2 col-form-label">Soir</label>
    <input class="form-control" type="time" name="horaire_ouverture_excp_soir" value="{$horaire_ouverture_excp_soir}" id="date-input11">
    <input class="form-control" type="time" name="horaire_fermeture_excp_soir" value="{$horaire_fermeture_excp_soir}" id="date-input12">
  </div><!-- col-md-5 -->
  </div> <!-- form-group -->
  <input type="checkbox" name="fermer"> Fermer 
  </form>
    <hr style="border-top: 1px dashed #8c8b8b;"></hr>
<div class="panel">
  <div class="panel-heading">
    <i class="icon-AdminParentShipping "></i> LA CONFIGURATION DE EAT'LIVRE / ADRESSE
    <input id="delete_confirm" type="hidden"
    value="l s='Are you sure you want to delete this range ?' }" />
    <input id="and_text" type="hidden" value="{l s='and'}" />
  </div>
  {$value[$field['identifier']]|var_dump}
  <div class="form-wrapper">
      <input type="hidden" name="count" value="$count" />
      {if $i = 0 || $i <= $count || $i++ }
      <div class="form-group">
      <label for="id_carrier_{$i}" class="control-label col-lg-3">
      {l s='Carrier'}</label>
    <div class="col-lg-9">
      <select class="id_carrier" name="id_carrier_{$i}">
      {foreach from=$delivery_option_list item=$value}
      <option value="" >{$value['name']}</option>
      {/foreach}
      </select>
    </div>
  </div>
  {/if}
  <div class="form-group">
      <label for="availability_{$i}" class="control-label col-lg-3">{l s=('Disponibilité')}</label>
    <div class="col-lg-9">
      <select class="id_carrier fixed-width-lg" name="availability_{$i}">
      <option {if isset($available[$i])} value="0">{l s='unavailable'}{/if}</option>
      <option {if isset($available[$i])} value="1">{l s='available'}{/if}</option>
      </select>
    </div>
  </div>
  <div class="form-group">
      <label for="postcode_{$i}" class="control-label col-lg-3">
      <span data-html="true" data-original-title=" {l s='Séparez vos codes postaux avec des virgules comme ceci:75001,75002'} "
      class="label-tooltip" data-toggle="tooltip" title="" > {l s='Pour les codes postaux suivants'}
      </span>
      </label>
    <div class="col-lg-9">
      <input name="postcode_{$i}" type="text" data-role="tagsinput"
      value="{if isset($id_postalcodes[$i])}{/if}" />
    </div>
  </div>
  <div class="form-group">
        <label for="postcode_range_from_{$i}" class="control-label col-lg-3">
        <span data-html="true" data-original-title="
        {l s='Cette fonction ne fonctionne que pour les codes postaux numériques'} " class="label-tooltip"
        data-toggle="tooltip" title="">{l s='Ou codes postaux entre'}
        </span>
        </label>
      <div class="col-lg-9">
        {if isset ($id_postalrange[$i]) }
      <div class="postal_range">
        <input class="inline fixed-width-lg" name="postcode_range_from_'.$i.'_'.$j.'" type="text"
        value="'.(isset($range['from']) ? $range['from'] : '').'" />
        {l s=('et')}
        <input class="inline fixed-width-lg" name="postcode_range_to_'.$i.'_'.$j.'" type="text"
        value="'.(isset($range['to']) ? $range['to'] : '').'" />
        <i class="icon-minus-sign" data-carrier="'.$i.'" data-range="'.$j.'"></i>
      </div>
        {/if}
      <div class="postal_range">
        <input class="inline fixed-width-lg" name="postcode_range_from_'{$i}'_'{$j}'" type="text" />
        {l s=('et')}
        <input class="inline fixed-width-lg" name="postcode_range_to_'{$i}'_'{$j}'" type="text" />
        <i class="icon-plus-sign" data-carrier="{$i}" data-range="{$j}"></i>
      </div>
    </div>
  </div>
    <div class="form-group">
      <label for="county_{$i}" class="control-label col-lg-3">
      <span data-html="true" data-original-title="{l s='Séparez vos codes avec des virgules comme cela 75,76'}" class="label-tooltip"
      data-toggle="tooltip" title="">{l s='Ou les codes postaux commençant par'}
      </span>
      </label>
    <div class="col-lg-9">
      <input class="inline fixed-width-lg" name="county_{$i}" data-role="tagsinput"
      value="{$id_counties[$i]}" />
    </div>
  </div>
  <br/>
  <br/>
  <hr/>
</div>    
  </div>
    <div class="form-group">
  <button class="btn btn-default pull-right" name="submit_eatlivr_form" value="1" type="submit">
  <i class="process-icon-save"></i>Enregistrer
  </button>
  </div>  
</form>
