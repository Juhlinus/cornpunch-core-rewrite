<?php

namespace Cornpunch;

use Cornpunch\Database;
use Cornpunch\Libraries\Facepunch;

class AjaxController{
    protected $database;
    protected $facepunch;
    /**
     * Lets use that database class.
     */
    public function __construct(){
        $this->database = new Database;
        $this->facepunch = new Facepunch;
    }
    /**
     * Parse the action which has been sent to us, and check out all the data.
     *
     * @param $action
     * @param $array
     */
    public function parseAction( $action, $array ){
        if( !$this->safeCheck( $array ))
            //They failed the safe check so throw them out instantly.
            return false;
        //Lets do a switch
        switch( $action ){
            case "auth":
                return ( $this->beginAuthentication( $array ) ) ? $this->beginAuthentication( $array ) : "invalid request";
                break;
            case "confirm":
                return ( $this->finishAuthentication( $array ) ) ? true : "failed to finish request";
                break;
            default:
                return false;
                break;
        }
    }

    public function beginAuthentication($array){
        if( !$array["userurl"] )
            return false;
        //Parse this userid
        if( !$this->facepunch->parseURL( $array["userurl"] ))
            return false;
        //Lets throw this out
        $userid = $this->facepunch->parseURL( $array["userurl"] );
        //Are we even a valid user?
        if( !$this->facepunch->validUserID( $userid ))
            return false;
        //Lets check to see if this user already has a key
        if( $this->database->userAlreadyHasKey( $userid )) {
            //Save the key
            $key = $this->database->userAlreadyHasKey( $userid );
            //If this dead?
            if( $this->database->keyExpired($key ))
                return false;
            //Its not dead! Then lets just return this key since its alreayd valid!
            return $key;
        }
        //Assuming the user does not have a key, we will now give him a new one, and prepare an array to be sent back
        $information = array(
            "authkey" => $this->database->addAuthenticationKey( $userid ),
            "username" => $this->facepunch->getUsername(),
            "userid" => $this->facepunch->userid,
        );
        //Return this
        return $information;
    }

    public function finishAuthentication( $array ){
        if( !$array["userid"] || !$array["authkey"])
            //No keys
            return false;
        //Are we a valid user?
        if( !$this->facepunch->validUserID( $array["userid"]))
            return false;
        //Okay, lets check, do we have this key?
        if(!$this->database->hasKey( $array["authkey"]))
            return false;
        //Is it owned by the player?
        if($this->database->getUserIDFromKey( $array["authkey"]) != $array["userid"])
            return false;
        //Okay, now lets check for the key on the users page.
        if(!$this->facepunch->compareComments("CP[".$array["authkey"]."]"))
            return false;
        //If it is, return true!
        return true;
    }

    public function safeCheck( $array ){
        foreach($array as $element){
            if( preg_match("\\{}[]*()\'\";:@$", $element) ){
                return false;
            }
        }
        return true;
    }
}

