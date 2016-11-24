<?
// Klassendefinition
class GIIZInstaller extends IPSModule {

    public function __construct($InstanceID) {
        parent::__construct($InstanceID);
    }
 
    public function Create() {
        parent::Create();
    }
 
    public function ApplyChanges() {
        parent::ApplyChanges();
    }
        
    /**
     * INST_GetConfigurationForm($id);
     */
    public function GetConfigurationForm() {
        
        $isInstalled = false;
        $lblText = $isInstalled ? "Aktualisieren" : "Installieren";
        return '
        { 
        
        "actions": 
            [
                { "type": "Label", "label": "Letzte Aktualisierung '.date("d.m.y H:i").'" },
                { "type": "Button", "label": "'.$lblText.'", "onClick": "INST_Install($id, "'.$lblText.'");" }
            ] }
        
        ';
    }
    
    /**
     *
     * INST_GetVersion($id);
     *
     */
    public function GetVersion() {
        echo "0";
    }
    
    /**
     *
     * INST_Install($id, $mode);
     *
     */
    public function Install($mode) {
        echo "Installer wird ausgeführt, '".$mode."'-Modus.";
    }
}

?>
