{*
 *
 *  @author Mustapha Boulouh <<comforyou.fr>>
 *  @web  http://www.comforyou.fr
 *  @copyright  2017 CFY
 *
*}

<div id="formAddPaymentPanel" class="panel">
        <div class="panel-heading">
          <i class="icon-money"></i>
          Paiement  <span class="badge">0</span>
        </div>
                <form id="formAddPayment" method="post" action="index.php?controller=AdminOrders&amp;vieworder&amp;id_order=5&amp;token=8c23b4c261ca33c9981febbd42ac4e5f">
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th><span class="title_box ">Date</span></th>
                  <th><span class="title_box ">Moyen de paiement</span></th>
                  <th><span class="title_box ">ID de la transaction</span></th>
                  <th><span class="title_box ">Montant</span></th>
                  <th><span class="title_box ">Facture</span></th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                                <tr>
                  <td class="list-empty hidden-print" colspan="6">
                    <div class="list-empty-msg">
                      <i class="icon-warning-sign list-empty-icon"></i>
                      Aucun moyen de paiement disponible
                    </div>
                  </td>
                </tr>
                                <tr class="current-edit hidden-print">
                  <td>
                    <div class="input-group fixed-width-xl">
                      <input type="text" name="payment_date" class="datepicker hasDatepicker" value="2017-06-30" id="dp1498826697381">
                      <div class="input-group-addon">
                        <i class="icon-calendar-o"></i>
                      </div>
                    </div>
                  </td>
                  <td>
                    <input name="payment_method" list="payment_method" class="payment_method">
                    <datalist id="payment_method">
                                          <option value="Chèque">
                                          </option><option value="Transfert bancaire">
                                        </option></datalist>
                  </td>
                  <td>
                    <input type="text" name="payment_transaction_id" value="" class="form-control fixed-width-sm">
                  </td>
                  <td>
                    <input type="text" name="payment_amount" value="" class="form-control fixed-width-sm pull-left">
                    <select name="payment_currency" class="payment_currency form-control fixed-width-xs pull-left">
                                              <option value="1" selected="selected">€</option>
                                          </select>
                  </td>
                  <td>
                                      </td>
                  <td class="actions">
                    <button class="btn btn-primary" type="submit" name="submitAddPayment">
                      Ajouter
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </form>
              </div>