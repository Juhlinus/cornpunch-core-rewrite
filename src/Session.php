<?php
namespace Cornpunch;

use Cornpunch\Database;
use Cornpunch\Libraries\Facepunch as FacepunchWrapper;

class Session {
    
    protected $database;
    protected $facepunch;

    public function __construct() {

        $this->database     = new Database;
        $this->facepunch    = new FacepunchWrapper;
    }

    public function createSession( $userid ) {

        $this->facepunch->setUserID( $userid );

        if ( !$this->facepunch->isUserValid() )
            return false;

        $this->destroyBrokenSessions( $userid );

        $this->startFreshSession();

        if ( session_id() ) {

            $data = array(
                'userid'        => $userid,
                'sessionkey'    => session_id(),
                'ip'            => $_SERVER["REMOTE_ADDR"],
                'userlevel'     => '0',
                'time'          => time()
            );

            return $this->database->insertActiveUsers( $data );
        }
        else
            return false;
    }

    public function sessionToUserID( $sessionid ) {
        
        return $this->database->getActiveUsersBySessionId( $sessionid );
    }

    public function destroyBrokenSessions( $userid ) {
        
        $this->database->destroyBrokenSessions( $userid );
    }

    public function startSession() {

        session_name('fpcpsession');
        ini_set("session.cookie_lifetime","30758400000");
        session_start();        
    }

    public function startFreshSession() {
        
        session_name('fpcpsession');
        ini_set("session.cookie_lifetime","30758400000");
        session_start();
        session_regenerate_id();   
    }

    public function checkSession() {

        $this->startSession();

        if ( $this->activeSession( session_id() ) ) {

            $this->setCookies();
            return true;
        }
        else
            return false;
    }

    public function setCookies() {

        $this->facepunch->setUserID( $this->sessionToUserID( session_id() ) );

        setcookie('fpusername', $this->facepunch->getUsername() );
        setcookie('fpid', $this->facepunch->currentUserID() );
    }

    public function checkAvailability( $available ) {
        
        if ($available)
            return true;
        else
            return false;
    }

}