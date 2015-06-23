<?php
namespace Cornpunch;

use Cornpunch\Libraries\Facepunch as FacepunchWrapper;

class Account {
    protected $facepunch;
    protected $account;

    public function __construct() {
    
        $this->facepunch = new FacepunchWrapper;
    }
    
    public function bootstrapAccount( $userid ){
        //We first check to see if this account is a valid facepunch account
        if(!$this->facepunch->isUserValid())
            return false;
        //Set the ID
        $this->account = $userid;
    }
    
    public function cacheFacepunchData()
    {
        //Set the userid
        $this->facepunch->setUserID($this->account);
        //If the user valid?
        /**
         * if( $this->facepunch->isUserValid() )
         *      $database->updateUserData( $this->facepunch->getUserInformation( true ) );
         */
    }
}