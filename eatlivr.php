<?php
/*
 *
 *  @author Mustapha Boulouh <<comforyou.fr>>
 *  @web	http://www.comforyou.fr
 *  @copyright  2017 CFY
 *
 *
*/
if (!defined('_PS_VERSION_'))
{
  exit;
}

class eatlivr extends Module
{
    private $module = 'eatdeliv';
    public $multishop_context = -1;
    public $multishop_context_group = true;

  public function __construct()
  {
      $this->name = 'eatlivr';
      $this->tab = 'front_office_features';
      $this->version = '1.0.3';
      $this->author = 'M.B By COMFORYOU';
      $this->need_instance = 0;
      $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
      $this->bootstrap = true;
      parent::__construct();
      $this->displayName = $this->l("EAT'LIVRE");
      $this->description = $this->l('Faites apparaître une popup dès que vos visiteurs s’apprêtent à ajouter un produit sur votre site, et incitez-les à choissir leur mode de transport ! Grâce au module EATLIVRE');
      parent::__construct();
      $this->confirmUninstall = $this->l('Etes vous sur de vouloir desinstaller ce module?');
      $this->warning = $this->l('module de livraison.');
      $this->context->smarty->assign('confirmation','ok');
  }

    public function install()
  {
    if (!parent::install()
      
       // Install admin tab
              || !$this->installModuleTab(
                'EatDeliv',
                array((int)Configuration::get('PS_LANG_DEFAULT')=>'EATLIVR'),
                'AdminParentShipping'
            )
) 
        {
            return false;
        }

        $sql_file = dirname(__FILE__).'/install/install.sql';
        if (!$this->loadSQLFile($sql_file))
        {
        return false;
        }

    if(!$this->registerHook('displayLeftColumn') 
    || !$this->registerHook('displayRightColumnProduct') 
    || !$this->registerHook('displayProductButtons')
    || !$this->registerHook('displayProductTab')
    || !$this->registerHook('actionCarrierUpdate')
    || !$this->registerHook('displayOrderDetail')
    || !$this->registerHook('displayPDFInvoice')
    || !$this->registerHook('actionValidateOrder')
    || !$this->registerHook('displayCarrierList')
    || !$this->registerHook('actionGetExtraMailTemplateVars')
    || !$this->registerHook('actionAdminOrdersListingFieldsModifier')
    || !$this->registerHook('displayBeforeCarrier')
    || !$this->registerHook('displayshoppingcart')
    || !$this->registerHook('displayAdminOrder')
    || !$this->registerHook('displayAdminOrderContentShip')
    || !$this->__createtable())
      {
          return false;
      }
    return true;
  }

  public function loadSQLFile($sql_file)
  {
      // Get install SQL file content
      $sql_content = file_get_contents($sql_file);

      // Replace prefix and store SQL command in array
      $sql_content = str_replace('PREFIX_',_DB_PREFIX_, $sql_content);
      $sql_requests = preg_split("/;\s*[\r\n]+/", $sql_content);

      // Execute each SQL statement
      $result = true;
      foreach ($sql_requests as $request) {
          if (!empty($request)) {
              $result &= Db::getInstance()->execute(trim($request));
          }
      }

      // Return result
      return $result;
  }
  private function installModuleTab($tabClass, $tabName, $idTabParent)
    {
        $idTab = Tab::getIdFromClassName($idTabParent);
        $pass = true;
        $tab = new Tab();
        $tab->name = $tabName;
        $tab->class_name = $tabClass;
        $tab->module = $this->name;
        $tab->id_parent = $idTab;
        $pass = $tab->save();

        return $pass;
    }
      private function uninstallModuleTab($tabClass)
    {
        $pass = true;
        @unlink(_PS_IMG_DIR_.'t/'.$tabClass.'.gif');
        $idTab = Tab::getIdFromClassName($tabClass);
        if ($idTab != 0) {
            $tab = new Tab($idTab);
            $pass = $tab->delete();
        }
        return $pass;
    }

   public function installTab($parent, $class_name, $name)
    {
        // Create new admin tab
        $tab = new Tab();
        $tab->id_parent = (int)Tab::getIdFromClassName($parent);
        $tab->name = array();
        foreach (Language::getLanguages(true) as $lang) {
            $tab->name[$lang['id_lang']] = $name;
        }
        $tab->class_name = $class_name;
        $tab->module = $this->name;
        $tab->active = 1;
        return $tab->add();
    }

    public function uninstallTab($class_name)
    {
        // Retrieve Tab ID
        $id_tab = (int)Tab::getIdFromClassName($class_name);

        // Load tab
        $tab = new Tab((int)$id_tab);

        // Delete it
        return $tab->delete();
    }

    /**
     * @return bool
     */
    public function uninstall()
  {   
    // Call uninstall parent method
      if (!parent::uninstall()
        || !$this->uninstallModuleTab('EatDeliv')) {
            return false;
        }
        return true;
      // Execute module unsinstall SQL statements
      $sql_file = dirname(__FILE__).'/install/uninstall.sql';
      if (!$this->loadSQLFile($sql_file)) 
      {
          return false;
      }
      return true;

     // Uninstall admin tab
        if (!$this->uninstallTab('Admineatlivr')) 
        {
            return false;
        }

      return true;

  }
  
  public function onClickOption($type, $href = false)
  {
      $confirm_reset = $this->l('
La réactivation de ce module supprime tous les données de votre base de données, est-ce que vous êtes sûr de vouloir le réinitialiser?');
      $reset_callback = "
Retourner eatlivr_reset('".addslashes($confirm_reset)."');";
      $matchType = array(
          'reset' => $reset_callback,
          'supprime' => "return confirm('".$this->l('Confirmation de la suppression?')."')",
      );
      if (isset($matchType[$type])) {
          return $matchType[$type];
      }
      return '';
  }

 public function hookDisplayHeader($params)
  {
      $this->context->controller->addCSS($this->_path.'views/css/bootstrap-tagsinput.css');
      $this->context->controller->addCSS($this->_path.'views/css/eatlivr.css', 'all');
      $this->context->controller->addCSS($this->_path.'views/css/font-awesome.css', 'all');
      $this->context->controller->addJS($this->_path.'views/js/autocomplete.js');
      $this->context->controller->addJS($this->_path.'views/js/bootstrap-tagsinput.min.js');
      $this->context->controller->addJquery();
      $this->context->controller->addJS($this->_path.'views/js/eatlivr.js');

      $this->loadCity($this->context->cart);
  }
  public function processConfiguration()
    {
      
      if (Tools::isSubmit('submit_eatlivr_form'))
      { 
        $current_selected_time = Tools::getValue('current_selected_time');
        $livraison = Tools::getValue('livraison');
        $emporter = Tools::getValue('emporter');
        $temps_prepa_emporter = Tools::getValue('temps_prepa_emporter');
        $temps_prepa_livraison = Tools::getValue('temps_prepa_livraison');
        $temps_commande_emporter = Tools::getValue('temps_commande_emporter');
        $temps_commande_livraison = Tools::getValue('temps_commande_livraison');
        $temps_estimation_client = Tools::getValue('temps_estimation_client');
        $horaire_ouverture_semaine_matin = Tools::getValue('horaire_ouverture_semaine_matin');
        $horaire_ouverture_semaine_soir = Tools::getValue('horaire_ouverture_semaine_soir');
        $horaire_ouverture_weekend_matin = Tools::getValue('horaire_ouverture_weekend_matin');
        $horaire_ouverture_weekend_soir = Tools::getValue('horaire_ouverture_weekend_soir');
        $horaire_fermeture_semaine_matin = Tools::getValue('horaire_fermeture_semaine_matin');
        $horaire_fermeture_semaine_soir = Tools::getValue('horaire_fermeture_semaine_soir');
        $horaire_fermeture_weekend_matin = Tools::getValue('horaire_fermeture_weekend_matin');
        $horaire_fermeture_weekend_soir = Tools::getValue('horaire_fermeture_weekend_soir');
        $horaire_ouverture_excp_matin = Tools::getValue('horaire_ouverture_excp_matin');
        $horaire_ouverture_excp_soir = Tools::getValue('horaire_ouverture_excp_soir');
        $horaire_fermeture_excp_matin = Tools::getValue('horaire_fermeture_excp_matin');
        $horaire_fermeture_excp_soir = Tools::getValue('horaire_fermeture_excp_soir');
        $heure_livraison = Tools::getValue('heure_livraison');
        $heure_emporter = Tools::getValue('heure_emporter');
        $frais_livraison = Tools::getValue('frais_livraison');
        $frais_kilometrique = Tools::getValue('frais_kilometrique');
        $address= Tools::getValue('address');
        $mode_transport = Tools::getValue('mode_transport');
        Configuration::updateValue('current_selected_time', $current_selected_time);
        Configuration::updateValue('ADDRESS', $address);
        Configuration::updateValue('MODE_TRANSPORT', $mode_transport);
        Configuration::updateValue('HEURE_LIVRAISON', $heure_livraison);
        Configuration::updateValue('HEURE_EMPORTER', $heure_emporter);
        Configuration::updateValue('FRAIS_LIVRAISON', $frais_livraison);
        Configuration::updateValue('FRAIS_KILOMETRIQUE', $frais_kilometrique);
        Configuration::updateValue('TEMPS_COMMANDE_LIVRAISON', $temps_commande_livraison);
        Configuration::updateValue('TEMPS_COMMANDE_EMPORTER', $temps_commande_emporter);
        Configuration::updateValue('TEMPS_PREPA_LIVRAISON', $temps_prepa_livraison);
        Configuration::updateValue('TEMPS_PREPA_EMPORTER', $temps_prepa_emporter);
        Configuration::updateValue('LIVRAISON', $livraison);
        Configuration::updateValue('EMPORTER', $emporter);
        Configuration::updateValue('HORAIRE_OUVERTURE_SEMAINE_MATIN', $horaire_ouverture_semaine_matin);
        Configuration::updateValue('HORAIRE_OUVERTURE_SEMAINE_SOIR', $horaire_ouverture_semaine_soir);
        Configuration::updateValue('HORAIRE_OUVERTURE_WEEKEND_MATIN', $horaire_ouverture_weekend_matin);
        Configuration::updateValue('HORAIRE_OUVERTURE_WEEKEND_SOIR', $horaire_ouverture_weekend_soir);
        Configuration::updateValue('HORAIRE_FERMETURE_SEMAINE_MATIN', $horaire_fermeture_semaine_matin);
        Configuration::updateValue('HORAIRE_FERMETURE_SEMAINE_SOIR', $horaire_fermeture_semaine_soir);
        Configuration::updateValue('HORAIRE_FERMETURE_WEEKEND_MATIN', $horaire_fermeture_weekend_matin);
        Configuration::updateValue('HORAIRE_FERMETURE_WEEKEND_SOIR', $horaire_fermeture_weekend_soir);
        Configuration::updateValue('HORAIRE_OUVERTURE_EXCP_MATIN', $horaire_ouverture_excp_matin);
        Configuration::updateValue('HORAIRE_OUVERTURE_EXCP_SOIR', $horaire_ouverture_excp_soir);
        Configuration::updateValue('HORAIRE_FERMETURE_EXCP_MATIN', $horaire_fermeture_excp_matin);
        Configuration::updateValue('HORAIRE_FERMETURE_EXCP_SOIR', $horaire_fermeture_excp_soir);
        $this->context->smarty->assign('confirmation', 'ok');
        $eatlivr = new eatlivr();
        $eatlivr->id_shop = (int)$this->context->shop->id;  
      }
   
      if (Tools::isSubmit('modal_livr'))
      {
        $livraison = Tools::getValue('livraison');
         Configuration::updateValue('LIVRAISON', $livraison);
        $this->context->smarty->assign('confirmation', 'ok');
      }

    }
  public function assignConfiguration()
  {
    $current_selected_time = Configuration::get('CURRENT_SELECTED_TIME');
      $id_commande = Configuration::get('ID_COMMANDE');
      $livraison = Configuration::get('LIVRAISON');
      $emporter = Configuration::get('EMPORTER');
      $temps_commande_emporter = Configuration::get('TEMPS_COMMANDE_EMPORTER');
      $temps_commande_livraison = Configuration::get('TEMPS_COMMANDE_LIVRAISON');
      $temps_prepa_emporter = Configuration::get('TEMPS_PREPA_EMPORTER');
      $temps_prepa_livraison = Configuration::get('TEMPS_PREPA_LIVRAISON');
      $heure_livraison = Configuration::get('HEURE_LIVRAISON');
      $frais_livraison = Configuration::get('FRAIS_LIVRAISON');
      $mode_transport = Configuration::get('MODE_TRANSPORT');
      $address = Configuration::get('ADDRESS');
      $horaire_ouverture_semaine_matin = Configuration::get('HORAIRE_OUVERTURE_SEMAINE_MATIN');
      $horaire_ouverture_semaine_soir = Configuration::get('HORAIRE_OUVERTURE_SEMAINE_SOIR');
      $horaire_ouverture_weekend_matin = Configuration::get('HORAIRE_OUVERTURE_WEEKEND_MATIN');
      $horaire_ouverture_weekend_soir = Configuration::get('HORAIRE_OUVERTURE_WEEKEND_SOIR');
      $horaire_fermeture_semaine_matin = Configuration::get('HORAIRE_FERMETURE_SEMAINE_MATIN');
      $horaire_fermeture_semaine_soir = Configuration::get('HORAIRE_FERMETURE_SEMAINE_SOIR');
      $horaire_fermeture_weekend_matin = Configuration::get('HORAIRE_FERMETURE_WEEKEND_MATIN');
      $horaire_fermeture_weekend_soir = Configuration::get('HORAIRE_FERMETURE_WEEKEND_SOIR');
      $horaire_ouverture_excp_matin = Configuration::get('HORAIRE_OUVERTURE_EXCP_MATIN');
      $horaire_ouverture_excp_soir = Configuration::get('HORAIRE_OUVERTURE_EXCP_SOIR');
      $horaire_fermeture_excp_matin = Configuration::get('HORAIRE_FERMETURE_EXCP_MATIN');
      $horaire_fermeture_excp_soir = Configuration::get('HORAIRE_FERMETURE_EXCP_SOIR');
      $frais_kilometrique = Configuration::get('FRAIS_KILOMETRIQUE');
      $heure_emporter = $horaire_fermeture_excp_soir = Configuration::get('HORAIRE_FERMETURE_EXCP_SOIR');
      $heure_livraison = Db::getInstance()->getValue('SELECT SEC_TO_TIME(`temps_prepa_livraison`+`temps_commande_livraison`) 
        FROM `'._DB_PREFIX_.'eatlivr`');
    $this->context->smarty->assign('emporter', $emporter);
    $this->context->smarty->assign('id_commande', $id_commande);
    $this->context->smarty->assign('current_selected_time', $current_selected_time);
    $this->context->smarty->assign('horaire_ouverture_semaine_matin', $horaire_ouverture_semaine_matin);
    $this->context->smarty->assign('horaire_ouverture_semaine_soir', $horaire_ouverture_semaine_soir);
    $this->context->smarty->assign('horaire_ouverture_weekend_matin', $horaire_ouverture_weekend_matin);
    $this->context->smarty->assign('horaire_ouverture_weekend_soir', $horaire_ouverture_weekend_soir);
    $this->context->smarty->assign('horaire_fermeture_semaine_matin', $horaire_fermeture_semaine_matin);
    $this->context->smarty->assign('horaire_fermeture_semaine_soir', $horaire_fermeture_semaine_soir);
    $this->context->smarty->assign('horaire_fermeture_weekend_matin', $horaire_fermeture_weekend_matin);
    $this->context->smarty->assign('horaire_fermeture_weekend_soir', $horaire_fermeture_weekend_soir);
    $this->context->smarty->assign('horaire_ouverture_excp_matin', $horaire_ouverture_excp_matin);
    $this->context->smarty->assign('horaire_ouverture_excp_soir', $horaire_ouverture_excp_soir);
    $this->context->smarty->assign('horaire_fermeture_excp_matin', $horaire_fermeture_excp_matin);
    $this->context->smarty->assign('horaire_fermeture_excp_soir', $horaire_fermeture_excp_soir);
    $this->context->smarty->assign('address', $address);
    $this->context->smarty->assign('mode_transport', $mode_transport);
    $this->context->smarty->assign('heure_livraison', $heure_livraison);
    $this->context->smarty->assign('heure_emporter', $heure_emporter);
    $this->context->smarty->assign('frais_livraison', $frais_livraison);
    $this->context->smarty->assign('frais_kilometrique', $frais_kilometrique);
    $this->context->smarty->assign('livraison', $livraison);
    $this->context->smarty->assign('temps_prepa_emporter', $temps_prepa_emporter);
    $this->context->smarty->assign('temps_prepa_livraison', $temps_prepa_livraison);
    $this->context->smarty->assign('temps_commande_emporter', $temps_commande_emporter);
    $this->context->smarty->assign('temps_commande_livraison', $temps_commande_livraison);
  }
  public function processLeftColumn()
  {
    if (Tools::isSubmit('submit_eatlivr_form'))
    {
      $livraison = Tools::getValue('livraison');
      $emporter = Tools::getValue('emporter');
      $id_commande = Tools::getValue('id_commande');
      $temps_prepa_emporter = Tools::getValue('temps_prepa_emporter');
      $temps_prepa_livraison = Tools::getValue('temps_prepa_livraison');
      $temps_commande_emporter = Tools::getValue('temps_commande_emporter');
      $temps_commande_livraison = Tools::getValue('temps_commande_livraison');
      $temps_estimation_client = Tools::getValue('temps_estimation_client');
      $heure_livraison = Tools::getValue('heure_livraison');
      $heure_emporter = Tools::getValue('heure_emporter');
      $horaire_ouverture_semaine_matin = Tools::getValue('horaire_ouverture_semaine_matin');
      $horaire_ouverture_semaine_soir = Tools::getValue('horaire_ouverture_semaine_soir');
      $horaire_ouverture_weekend_matin = Tools::getValue('horaire_ouverture_weekend_matin');
      $horaire_ouverture_weekend_soir = Tools::getValue('horaire_ouverture_weekend_soir');
      $horaire_fermeture_semaine_matin = Tools::getValue('horaire_fermeture_semaine_matin');
      $horaire_fermeture_semaine_soir = Tools::getValue('horaire_fermeture_semaine_soir');
      $horaire_fermeture_weekend_matin = Tools::getValue('horaire_fermeture_weekend_matin');
      $horaire_fermeture_weekend_soir = Tools::getValue('horaire_fermeture_weekend_soir');
      $horaire_ouverture_excp_matin = Tools::getValue('horaire_ouverture_excp_matin');
      $horaire_ouverture_excp_soir = Tools::getValue('horaire_ouverture_excp_soir');
      $horaire_fermeture_excp_matin = Tools::getValue('horaire_fermeture_excp_matin');
      $horaire_fermeture_excp_soir = Tools::getValue('horaire_fermeture_excp_soir');
      $mode_transport = Tools::getValue('mode_transport');
      $address= Tools::getValue('address');
      $old_id_carrier = (int)$params['id_carrier'];
      $new_id_carrier = (int)$params['carrier']->id;
       if (Configuration::get('EATLIVRE_EMP') == $old_id_carrier) {
            Configuration::updateValue('EATLIVRE_EMP', $new_id_carrier);
        }
                if (Configuration::get('EATLIVRE_LIV') == $old_id_carrier) {
            Configuration::updateValue('EATLIVRE_LIV', $new_id_carrier);
        }
      $insert = array(
        'id_eatlivr' => (int)$id_eatlivr,
        'livraison' => (int)$livrasion,
        'emporter' => (int)$emporter,
        'address' => pSQL($address),
        'temps_estimation_client' => (int)$temps_estimation_client,
        'departement_deservi' => pSQL($departement_deservi),
        'zone_livrable' => pSQL($zone_livrable),
        'code_postaux' => (int)$code_postaux,
        'temps_prepa_emporter' => (int)$temps_prepa_emporter,
        'temps_prepa_livraison' => (int)$temps_prepa_livraison,
        'temps_commande_emporter' => (int)$temps_commande_emporter,
        'temps_commande_livraison' => (int)$temps_commande_livraison,
        'horaire_ouverture_semaine_matin' => date_time_set($horaire_ouverture_semaine_matin),
        'horaire_ouverture_semaine_soir' => date_time_set($horaire_ouverture_semaine_soir),
        'horaire_ouverture_weekend_matin' => date_time_set($horaire_ouverture_weekend_matin),
        'horaire_ouverture_weekend_soir' => date_time_set($horaire_ouverture_weekend_soir),
        'horaire_fermeture_semaine_matin' => date_time_set($horaire_fermeture_semaine_matin),
        'horaire_fermeture_semaine_soir' => date_time_set($horaire_fermeture_semaine_soir),
        'horaire_fermeture_weekend_matin' => date_time_set($horaire_fermeture_weekend_matin),
        'horaire_fermeture_weekend_soir' => date_time_set($horaire_fermeture_weekend_soir),
        'maximun_commande' => (int)$maximun_commande,
        'minimun_commande' => (int)$minimun_commande,
        'frais_livraison' => (int)$frais_livraison,
        'frais_kilometrique' => (int)$frais_kilometrique,
        'date_add' => date('Y-m-d H:i:s'));
      Db::getInstance()->insert('eatlivr', $insert);
      Db::getInstance()->insert('id_commande', $id_commande);
      Db::getInstance()->temps_prepa_emporter('eatlivr', $temps_prepa_emporter);
      Db::getInstance()->temps_prepa_livraison('eatlivr', $temps_prepa_livraison);
      Db::getInstance()->temps_commande_emporter('eatlivr', $temps_commande_emporter);
      Db::getInstance()->horaire_ouverture_semaine_matin('eatlivr', $horaire_ouverture_semaine_matin);
      Db::getInstance()->horaire_ouverture_semaine_matin('eatlivr', $horaire_ouverture_semaine_matin);
      Db::getInstance()->horaire_ouverture_semaine_soir('eatlivr', $horaire_ouverture_semaine_soir);
      Db::getInstance()->horaire_ouverture_weekend_matin('eatlivr', $horaire_ouverture_weekend_matin);
      Db::getInstance()->horaire_ouverture_weekend_soir('eatlivr', $horaire_ouverture_weekend_soir);
      Db::getInstance()->horaire_fermeture_semaine_matin('eatlivr', $horaire_fermeture_semaine_matin);
      Db::getInstance()->horaire_fermeture_semaine_soir('eatlivr', $horaire_fermeture_semaine_soir);
      Db::getInstance()->horaire_fermeture_weekend_matin('eatlivr', $horaire_fermeture_weekend_matin);
      Db::getInstance()->horaire_fermeture_weekend_soir('eatlivr', $horaire_fermeture_weekend_soir);
      Db::getInstance()->horaire_ouverture_excp_matin('eatlivr', $horaire_ouverture_excp_matin);
      Db::getInstance()->horaire_ouverture_excp_soir('eatlivr', $horaire_ouverture_excp_soir);
      Db::getInstance()->horaire_fermeture_excp_matin('eatlivr', $horaire_fermeture_excp_matin);
      Db::getInstance()->heure_livraison('eatlivr', $heure_livraison);
      Db::getInstance()->heure_livraison('eatlivr', $heure_livraison);
      Db::getInstance()->frais_livraison('eatlivr', $frais_livraison);
      Db::getInstance()->frais_kilometrique('eatlivr', $frais_kilometrique);
      Db::getInstance()->address('eatlivr', $address);
      Db::getInstance()->mode_transport('eatlivr', $mode_transport);
      Db::getInstance()->current_selected_time('eatlivr', $current_selected_time);
      Db::getInstance()->livraison('eatlivr', $livraison);
      Db::getInstance()->emporter('eatlivr', $emporter);
      Configuration::updateValue('ID_COMMANDE', $id_commande);
      Configuration::updateValue('ADDRESS', $address);
      Configuration::updateValue('MODE_TRANSPORT', $mode_transport);
      Configuration::updateValue('FRAIS_LIVRAISON', $frais_kilometrique);
      Configuration::updateValue('FRAIS_KILOMETRIQUE', $frais_kilometrique);
      Configuration::updateValue('LIVRAISON', $livraison);
      Configuration::updateValue('EMPORTER', $emporter);
      Configuration::updateValue('TEMPS_COMMANDE_LIVRAISON', $temps_commande_livraison);
      Configuration::updateValue('TEMPS_COMMANDE_EMPORTER', $temps_commande_emporter);
      Configuration::updateValue('TEMPS_PREPA_LIVRAISON', $temps_prepa_livraison);
      Configuration::updateValue('TEMPS_PREPA_EMPORTER', $temps_prepa_emporter);
      Configuration::updateValue('HORAIRE_OUVERTURE_SEMAINE_MATIN', $horaire_ouverture_semaine_matin);
      Configuration::updateValue('HORAIRE_OUVERTURE_SEMAINE_SOIR', $horaire_ouverture_semaine_soir);
      Configuration::updateValue('HORAIRE_OUVERTURE_WEEKEND_MATIN', $horaire_ouverture_weekend_matin);
      Configuration::updateValue('HORAIRE_OUVERTURE_WEEKEND_SOIR', $horaire_ouverture_weekend_soir);
      Configuration::updateValue('HORAIRE_FERMETURE_SEMAINE_MATIN', $horaire_fermeture_semaine_matin);
      Configuration::updateValue('HORAIRE_FERMETURE_SEMAINE_SOIR', $horaire_fermeture_semaine_soir);
      Configuration::updateValue('HORAIRE_FERMETURE_WEEKEND_MATIN', $horaire_fermeture_weekend_matin);
      Configuration::updateValue('HORAIRE_FERMETURE_WEEKEND_SOIR', $horaire_fermeture_weekend_soir);
      Configuration::updateValue('HORAIRE_OUVERTURE_EXCP_MATIN', $horaire_ouverture_excp_matin);
      Configuration::updateValue('HORAIRE_OUVERTURE_EXCP_SOIR', $horaire_ouverture_excp_soir);
      Configuration::updateValue('HORAIRE_FERMETURE_EXCP_MATIN', $horaire_fermeture_excp_matin);
      Configuration::updateValue('HORAIRE_FERMETURE_EXCP_SOIR', $horaire_fermeture_excp_soir);
      $this->context->smarty->assign('temps_estimation_client', 'true');
      $this->context->smarty->assign('confirmation', 'ok');
      } 
  }
  public function assignLeftColumn()
  {
      $livraison = Configuration::get('LIVRAISON');
      $emporter = Configuration::get('EMPORTER');
      $temps_commande_emporter = Configuration::get('TEMPS_COMMANDE_EMPORTER');
      $temps_commande_livraison = Configuration::get('TEMPS_COMMANDE_LIVRAISON');
      $temps_prepa_emporter = Configuration::get('TEMPS_PREPA_EMPORTER');
      $temps_prepa_livraison = Configuration::get('TEMPS_PREPA_LIVRAISON');
      $heure_livraison = Configuration::get('HEURE_LIVRAISON');
      $frais_livraison = Configuration::get('FRAIS_LIVRAISON');
      $mode_transport = Configuration::get('MODE_TRANSPORT');
      $address = Configuration::get('ADDRESS');
      $horaire_ouverture_semaine_matin = Configuration::get('HORAIRE_OUVERTURE_SEMAINE_MATIN');
      $horaire_ouverture_semaine_soir = Configuration::get('HORAIRE_OUVERTURE_SEMAINE_SOIR');
      $horaire_ouverture_weekend_matin = Configuration::get('HORAIRE_OUVERTURE_WEEKEND_MATIN');
      $horaire_ouverture_weekend_soir = Configuration::get('HORAIRE_OUVERTURE_WEEKEND_SOIR');
      $horaire_fermeture_semaine_matin = Configuration::get('HORAIRE_FERMETURE_SEMAINE_MATIN');
      $horaire_fermeture_semaine_soir = Configuration::get('HORAIRE_FERMETURE_SEMAINE_SOIR');
      $horaire_fermeture_weekend_matin = Configuration::get('HORAIRE_FERMETURE_WEEKEND_MATIN');
      $horaire_fermeture_weekend_soir = Configuration::get('HORAIRE_FERMETURE_WEEKEND_SOIR');
      $horaire_ouverture_excp_matin = Configuration::get('HORAIRE_OUVERTURE_EXCP_MATIN');
      $horaire_ouverture_excp_soir = Configuration::get('HORAIRE_OUVERTURE_EXCP_SOIR');
      $horaire_fermeture_excp_matin = Configuration::get('HORAIRE_FERMETURE_EXCP_MATIN');
      $horaire_fermeture_excp_soir = Configuration::get('HORAIRE_FERMETURE_EXCP_SOIR');
      $heure_livraison = Db::getInstance()->getValue('
      SELECT SEC_TO_TIME(`temps_prepa_livraison`+ `temps_commande_livraison`) 
      FROM `'._DB_PREFIX_.'eatlivr`');
      $heure_emporter = Db::getInstance()->getValue('
      SELECT SEC_TO_TIME(`temps_prepa_emporter`+ `temps_commande_emporter`) 
      FROM `'._DB_PREFIX_.'eatlivr`');
      $this->context->smarty->assign('horaire_ouverture_semaine_matin', $horaire_ouverture_semaine_matin);
      $this->context->smarty->assign('horaire_ouverture_semaine_soir', $horaire_ouverture_semaine_soir);
      $this->context->smarty->assign('horaire_ouverture_weekend_matin', $horaire_ouverture_weekend_matin);
      $this->context->smarty->assign('horaire_ouverture_weekend_soir', $horaire_ouverture_weekend_soir);
      $this->context->smarty->assign('horaire_fermeture_semaine_matin', $horaire_fermeture_semaine_matin);
      $this->context->smarty->assign('horaire_fermeture_semaine_soir', $horaire_fermeture_semaine_soir);
      $this->context->smarty->assign('horaire_fermeture_weekend_matin', $horaire_fermeture_weekend_matin);
      $this->context->smarty->assign('horaire_fermeture_weekend_soir', $horaire_fermeture_weekend_soir);
      $this->context->smarty->assign('adhoraire_ouverture_excp_matindress', $horaire_ouverture_excp_matin);
      $this->context->smarty->assign('horaire_ouverture_excp_soir', $horaire_ouverture_excp_soir);
      $this->context->smarty->assign('horaire_fermeture_excp_matin', $horaire_fermeture_excp_matin);
      $this->context->smarty->assign('horaire_fermeture_excp_soir', $horaire_fermeture_excp_soir);
      $this->context->smarty->assign('address', $address);
      $this->context->smarty->assign('mode_transport', $mode_transport);
      $this->context->smarty->assign('frais_livraison', $frais_livraison);
      $this->context->smarty->assign('livraison', $livraison);
      $this->context->smarty->assign('livraison', $livraison);
      $this->context->smarty->assign('temps_prepa_emporter', $temps_prepa_emporter);
      $this->context->smarty->assign('temps_prepa_livraison', $temps_prepa_livraison);
      $this->context->smarty->assign('temps_commande_emporter', $temps_commande_emporter);
      $this->context->smarty->assign('temps_commande_livraison', $temps_commande_livraison);
      $this->context->smarty->assign('heure_livraison', $heure_livraison);
      $this->context->smarty->assign('heure_emporter', $heure_emporter);
  }
  public function installCarriers()
    {
        $id_lang_default = Language::getIsoById(Configuration::get('PS_LANG_DEFAULT'));

        $carriers_list = array(
            'EATLIVRE_LIV' => 'LIVRAISON',
            'EATLIVRE_EMP' => 'EMPORTER',
        );

        foreach ($carriers_list as $carrier_key => $carrier_name) {

            if (Configuration::get($carrier_key) < 1) {

                // Create carrier
                $carrier = new Carrier();
                $carrier->name = $carrier_name;
                $carrier->id_tax_rules_group = 0;
                $carrier->active = 1;
                $carrier->deleted = 0;
                foreach (Language::getLanguages(true) as $language) {
                    $carrier->delay[(int)$language['id_lang']] = 'Delay '.$carrier_name;}
                $carrier->shipping_handling = false;
                $carrier->range_behavior = 0;
                $carrier->is_module = true;
                $carrier->shipping_external = true;
                $carrier->external_module_name = $this->name;
                $carrier->need_range = true;
                if (!$carrier->add()) {
                    return false;
                }

                // Associate carrier to all groups
                $groups = Group::getGroups(true);
                foreach ($groups as $group) {
                    Db::getInstance()->insert('carrier_group', array('id_carrier' => (int)$carrier->id, 'id_group' => (int)$group['id_group']));
                }

                // Create price range
                $rangePrice = new RangePrice();
                $rangePrice->id_carrier = $carrier->id;
                $rangePrice->delimiter1 = '0';
                $rangePrice->delimiter2 = '10000';
                $rangePrice->add();

                // Create weight range
                $rangeWeight = new RangeWeight();
                $rangeWeight->id_carrier = $carrier->id;
                $rangeWeight->delimiter1 = '0';
                $rangeWeight->delimiter2 = '10000';
                $rangeWeight->add();

                // Associate carrier to all zones
                $zones = Zone::getZones(true);
                foreach ($zones as $zone) {
                    Db::getInstance()->insert('carrier_zone', array('id_carrier' => (int)$carrier->id, 'id_zone' => (int)$zone['id_zone']));
                    Db::getInstance()->insert('delivery', array('id_carrier' => (int)$carrier->id, 'id_range_price' => (int)$rangePrice->id, 'id_range_weight' => null, 'id_zone' => (int)$zone['id_zone'], 'price' => '0'));
                    Db::getInstance()->insert('delivery', array('id_carrier' => (int)$carrier->id, 'id_range_price' => null, 'id_range_weight' => (int)$rangeWeight->id, 'id_zone' => (int)$zone['id_zone'], 'price' => '0'));
                }

                // Copy the carrier logo
                copy(dirname(__FILE__).'/views/images/'.$carrier_key.'.png', _PS_SHIP_IMG_DIR_.'/'.(int)$carrier->id.'.png');

                // Save the Carrier ID in the Configuration table
                Configuration::updateValue($carrier_key, $carrier->id);
            }
        }

        return true;
    }
  public function hookDisplayLeftColumn($params)
  {
      $this->processConfiguration();
      $this->assignConfiguration();
      $this->processLeftColumn();
      $this->assignLeftColumn();
      return $this->display(__FILE__, 'displayLeftColumn.tpl');
  }
  public function hookDisplayAdminOrder($params)
  {
      $this->processConfiguration();
      $this->assignConfiguration();
      $this->processLeftColumn();
      $this->assignLeftColumn();
      return $this->display(__FILE__, 'displayAdminOrder.tpl');
  }
   public function hookDisplayCarrierList($params)
  {
      $this->processConfiguration();
      $this->assignConfiguration();
      $this->processLeftColumn();
      $this->assignLeftColumn();
      return $this->display(__FILE__, 'displayCarrierList.tpl');
  }
  public function hookDisplayPDFInvoice($params)
  {
      $this->processConfiguration();
      $this->assignConfiguration();
      $this->processLeftColumn();
      $this->assignLeftColumn();
      return $this->display(__FILE__, 'displayPDFInvoice.tpl');
  }
  public function hookActionValidateOrder($params)
  {
      $this->processConfiguration();
      $this->assignConfiguration();
      $this->processLeftColumn();
      $this->assignLeftColumn();
      return $this->display(__FILE__, 'actionValidateOrder.tpl');
  } 
  public function hookActionGetExtraMailTemplateVars($params)
  {
      $this->processConfiguration();
      $this->assignConfiguration();
      $this->processLeftColumn();
      $this->assignLeftColumn();
      return $this->display(__FILE__, 'actionGetExtraMailTemplateVars.tpl');
  }
    public function hookActionAdminOrdersListingFieldsModifier($params)
  {
      $this->processConfiguration();
      $this->assignConfiguration();
      $this->processLeftColumn();
      $this->assignLeftColumn();
      return $this->display(__FILE__, 'actionAdminOrdersListingFieldsModifier.tpl');
  }
  public function hookDisplayOrderDetail($params)
  {
      $this->processConfiguration();
      $this->assignConfiguration();
      $this->processLeftColumn();
      $this->assignLeftColumn();
      return $this->display(__FILE__, 'displayOrderDetail.tpl');
  }
  public function hookDisplayRightColumnProduct($params)
  {
      $this->processConfiguration();
      $this->assignConfiguration();
      $this->processLeftColumn();
      $this->assignLeftColumn();
      return $this->display(__FILE__, 'displayAdminOrder.tpl');
  } 
  public function hookDisplayProductButtons($params)
  {
      $this->processConfiguration();
      $this->assignConfiguration();
      $this->processLeftColumn();
      $this->assignLeftColumn();
      return $this->display(__FILE__, 'displayProductButtons.tpl');
  }
   public function hookDisplayBeforeCarrier($params)
  {
      $this->processConfiguration();
      $this->assignConfiguration();
      $this->processLeftColumn();
      $this->assignLeftColumn();
      return $this->display(__FILE__, 'displayBeforeCarrier.tpl');
  }
   public function hookDisplayShoppingCart($params)
  {
      $this->processConfiguration();
      $this->assignConfiguration();
      $this->processLeftColumn();
      $this->assignLeftColumn();
      return $this->display(__FILE__, 'displayShoppingCart.tpl');
  }
   public function hookDisplayAdminOrderContentShip($params)
  {
      $this->processConfiguration();
      $this->assignConfiguration();
      $this->processLeftColumn();
      $this->assignLeftColumn();
      return $this->display(__FILE__, 'displayAdminOrderContentShip.tpl');
  }
  public static function getCustomerHeureLivr()
    {
    $heure_livraison = Db::getInstance()->getValue('
    SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(`temps_commande_livraison`+ `temps_prepa_livraison`) 
    FROM `'._DB_PREFIX_.'eatlivr`');
        return $heure_livraison;
        }

 public function hookActionCarrierUpdate($params)
    {
        $result = Db::getInstance()->getValue('
            SELECT MAX(id_carrier)
            FROM `'._DB_PREFIX_.'carrier`');

        Db::getInstance()->Execute('
            UPDATE `'._DB_PREFIX_.'eatlivr`
            SET `id_carrier`='.(int)$result.'
            WHERE `id_carrier`='.(int)$params['id_carrier']);

        Db::getInstance()->Execute('
            UPDATE `'._DB_PREFIX_.'eatlivr_range`
            SET `id_carrier`='.(int)$result.'
            WHERE `id_carrier`='.(int)$params['id_carrier']);
    }

    public function hookDisplayProductTabContent($params)
    {
        $this->processConfiguration();
        $this->assignConfiguration();
        return $this->display(__FILE__, 'displayProductTabContent.tpl');
    }

    public function getContent()
    {
      $ajax_hook = Tools::getValue('ajax_hook');
        if ($ajax_hook != '') {
            $ajax_method = 'hook'.Tools::ucfirst($ajax_hook);
            if (method_exists($this, $ajax_method)) {
                die($this->{$ajax_method}(array()));
            }
        }
      $this->processConfiguration();
        $this->assignConfiguration();
        return $this->display(__FILE__, 'getContent.tpl');
    }    
        public function loadCity($cart)
    {
        $address = new Address($cart->id_address_delivery);
        $this->city = $address->city;
    }
       public function getShippingCost($params,$id_carrier, $delivery_service)
    {
        $shipping_cost = false;
        if ($id_carrier == Configuration::get('EATLIVRE_EMP') &&
            isset($delivery_service['LIVRAISON'])) {
            $shipping_cost = (int)$delivery_service['LIVRAISON'];
        }
        if ($id_carrier == Configuration::get('EATLIVRE_LIV') &&
            isset($delivery_service['EMPORTER'])) {
            $shipping_cost = (int)$delivery_service['EMPORTER'];
        }
        return $shipping_cost;
    }
    public static function getDeliveryTimeFromCart($cartId)
    {
        $sql = 'SELECT delivery_time FROM `'._DB_PREFIX_.'cart_delivery_time` WHERE id_cart='.$cartId;

        return Db::getInstance()->getValue($sql, false);
    }

    public static function saveDeliveryTime($orderId, $deliveryTime)
    {
        if ($deliveryTime instanceof DateTime) {
            $deliveryTime = $deliveryTime->format('Y-m-d H:i:s');
        }

        $sql = 'SELECT count(*) FROM `'._DB_PREFIX_.'order_delivery_time` WHERE id_order='.$orderId;
        if (!Db::getInstance()->getValue($sql, false)) { // false for not using db caching
            $sql = 'INSERT INTO `'._DB_PREFIX_."order_delivery_time`(id_order, delivery_time)
                VALUES($orderId,'".$deliveryTime."')";
            $result = Db::getInstance()->execute($sql);
        } else {
            $sql = 'UPDATE `'._DB_PREFIX_."order_delivery_time` 
                SET delivery_time = '".$deliveryTime."' WHERE id_order = ".$orderId;
            $result = Db::getInstance()->execute($sql);
        }

        return $result;
    }

    public static function getDeliveryTimeForOrder($orderId)
    {
        $sql = 'SELECT delivery_time FROM `'._DB_PREFIX_.'order_delivery_time`
            WHERE id_order = '.$orderId;

        return Db::getInstance()->getValue($sql);
    }

    public static function getCurrentOrderCountPerSlot()
    {
        $currentTime = (new DateTime('now', new DateTimeZone(Configuration::get('PS_TIMEZONE'))))->format('Y-m-d H:i:s');
        $query = "SELECT count(id_order) as order_count, date_format(delivery_time, '%H:%i')  as delivery_time
                FROM "._DB_PREFIX_."order_delivery_time
                where datediff(delivery_time.'$currentTime') = 0
                group by delivery_time;";

        return Db::getInstance()->executeS($query);
    }

}

