<?
    class GIIZAutoconfig extends IPSModule {
 
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
         *
         * GIIZ_Autoconfig($id);
         *
         */
        public function Autoconfig() {
            echo "OK";
        }
    }
?>