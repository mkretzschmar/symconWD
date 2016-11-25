<?php

define("BASE_CATEGORY_NAME", "Heizkostenverteiler");

/**
 * Splitter-Modul eines Metrona Datensammlers. Nachrichten werden geparst und
 * an die HKV-Instanzen weitergeleitet.
 * 
 */
class MetronaDatensammler extends IPSModule {

  /**
   *
   */
  public function __construct($InstanceID) {
    parent::__construct($InstanceID);
  }

  /**
   *
   */
  public function Create() {
    parent::Create();

    $this->RegisterPropertyString("Name", "DS");
    $this->RegisterPropertyBoolean("Active", false);
    print_r($this);
  }

  /**
   *
   */
  public function ApplyChanges() {
    parent::ApplyChanges();
    //Connect to available splitter or create a new one
    $this->ConnectParent("{46C969BF-3465-4E3E-B2A5-E404FB969735}");
  }

  /**
   *
   * MDS_RequestState($id);
   *
   */
  public function RequestState() {
    echo "Requesting MDS State...";
  }

  /**
   * MDS_AutoConfig($id); 
   */
  public function AutoConfig() {
    $parentId = 0; // $this->InstanceID
    // 1. Category 'Heizkostenverteiler',
    //  each HKV will be represented by an Object of type "device"
    //$CatIdHKV = @IPS_GetCategoryIDByName("Heizkostenverteiler", $this->InstanceID);
    $CatIdHKV = @IPS_GetCategoryIDByName(BASE_CATEGORY_NAME, $parentId);
    if ($CatIdHKV === false) {
      echo "Kategorie '" . BASE_CATEGORY_NAME . "' nicht gefunden, wird angelegt...";
      $CatIdHKV = IPS_CreateCategory();
      IPS_SetName($CatIdHKV, BASE_CATEGORY_NAME);
      IPS_SetParent($CatIdHKV, $parentId);
    } else {
      echo "Kategorie '" . BASE_CATEGORY_NAME . "' bereits vorhanden: " . $CatIdHKV;
    }
  }

  /**
   * MDS_AddHKV($id); 
   */
  public function AddHKV() {
    $Name = "HKV " . $this->ReadPropertyString("HKVID");
    $CatIdHKV = @IPS_GetCategoryIDByName(BASE_CATEGORY_NAME, $parentId);
    $InstanzID = @IPS_GetInstanceIDByName($Name, $CatIdHKV);
    if ($InstanzID === false) {
      echo "HKV wird angelegt...";
      $InsID = IPS_CreateInstance("{9469359F-EEA6-4DB0-930F-F08C3440DDB3}");
      IPS_SetName($InsID, $Name);
      IPS_SetParent($InsID, $CatIdHKV);
    } else {
      echo "HKV bereits vorhanden!";
    }
  }

  /**
   * This function will be available automatically after the module is imported with the module control.
   * Using the custom prefix this function will be callable from PHP and JSON-RPC through:
   *
   * MDS_Send($id, $text);
   *
   */
  public function Send($Text) {
    $this->SendDataToParent(json_encode(Array("DataID" => "{B87AC955-F258-468B-92FE-F4E0866A9E18}", "Buffer" => $Text)));
  }

  /**
   * 
   */
  public function ReceiveData($JSONString) {
    $data = json_decode($JSONString);
    IPS_LogMessage("Datensammler", utf8_decode($data->Buffer));
    //Parse and write values to our variables
    $this->parseMessage(utf8_decode($data->Buffer));
    
    // CUTTER anlegen
    
    $idCutter= IPS_CreateInstance("{AC6C6E74-C797-40B3-BA82-F135D941D1A2}");
    IPS_SetName($idCutter, "Cutter DS"); // Instanz benennen
    IPS_SetParent($idCutter, $this->InstanceID);
  }

  /**
   * 
   */
  private function parseMessage($hkvmessage) {
    IPS_LogMessage("Datensammler", "parseMessage()");
    // Validierung
    // Ermitteln der HKVID
    // Anlegen einer neuen HKV-Instanz, wenn noch nicht vorhanden
    // Zuweisen der Werte (Variablen) der HKV-Instanz
    // Wenn aktiviert: Forward der Nachricht an konfigurierbare 
  }

}

?>
