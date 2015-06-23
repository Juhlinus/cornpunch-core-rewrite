<?php
namespace Cornpunch;

use Cornpunch\Libraries\Facepunch as FacepunchWrapper;
use Cornpunch\Database as DatabaseController;

class Account {
    protected $facepunch;
    protected $database;
    protected $account;

<<<<<<< HEAD
    public function __construct() {
    
=======
    public function __construct()
    {
>>>>>>> upstream/master
        $this->facepunch = new FacepunchWrapper;
        $this->database = new DatabaseController;
    }
<<<<<<< HEAD
    
=======

>>>>>>> upstream/master
    public function bootstrapAccount( $userid ){
        //We first check to see if this account is a valid facepunch account
        if(!$this->facepunch->isUserValid())
            return false;
        //Set the ID
        $this->account = $userid;
    }
<<<<<<< HEAD
    
=======

>>>>>>> upstream/master
    public function cacheFacepunchData()
    {
        //Set the userid
        $this->facepunch->setUserID($this->account);
         if( $this->facepunch->isUserValid() )
             $this->$database->updateUserData( $this->facepunch->getUserInformation( true ), $this->account );
    }

    public function getUsername(){
        if( !$this->database->getUserData( $this->account ))
            //No data? Probably should ask them to refresh their data.
            return false;

        return ( $this->database->getUserData( $this->account) ) ? json_decode( $this->database->getUserData($this->account), true )['username'] : false;
    }

    public function getAvatar(){
        if( !$this->database->getUserData( $this->account ))
            //No data? Probably should ask them to refresh their data.
            return false;

        return ( $this->database->getUserData( $this->account) ) ? json_decode( $this->database->getUserData($this->account, true ) )['avatar'] : false;
    }

    public function getUploadedMovies(){
        return ( $this->database->getUploadedMovies($this->account) ) ? $this->database->getUploadedMovies($this->account) : false;
    }

}