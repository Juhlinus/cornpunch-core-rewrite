<?php
namespace Cornpunch;

use Illuminate\Database\Capsule\Manager as Capsule;

class Database {
    
    protected $capsule;

    /**
     * Creates new instance for Capsule object
     * and calls config function
     */
    public function __construct() {
        $this->capsule = new Capsule;
        echo ($this->config()) ? "Config done" : "Config error";
    }

    /**
     * Config for the Connection
     * 
     * @return bool
     */
    public function config() {
        if ($this->capsule->addConnection([
                'driver'    => 'mysql',
                'host'      => 'localhost',
                'database'  => 'cornpunch',
                'username'  => 'root',
                'password'  => 'password',
                'charset'   => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix'    => '',
        ]))
            return true;
        else
            return false;
    }

    /**
     * Inserting Authentication Key to table
     * 
     * @param integer $userid User ID
     * 
     * @return string $fpKey
     */
    public function addAuthenticationKey( $userid ) {

        if ($hashkey = $this->userAlreadyHasKey( $userid ))
            $this->deleteKey( $hashkey );

        $fpID   = $userid;
        $fpKey  = md5(sha1(rand()));
        $fpIP   = $_SERVER['REMOTE_ADDR'];
        $fpTime = time();

        Capsule::table('activations')->insert([
            'userid'        => $fpID,
            'activationkey' => $fpKey,
            'ip'            => $fpIP,
            'time'          => $fpTime
        ]);

        return $fpKey;
    }

    public function hasKey( $key ) {
        /**
         * Equal to the following:
         * 
         * SELECT * FROM activations WHERE activationkey = $key LIMIT 1
         *
         * The ->get(); function assures us that an array will be 
         * returned as a result.
         * 
         */
        $result = Capsule::table('activations')
                ->where('activationkey', $key)
                ->take(1)
                ->get();

        /**
         * Equal to the following:
         *
         * if ($result) {
         *     return true;
         * } else {
         *     return false;
         * }
         * 
         */
        return ($result) ? true : false;
    }

    /**
     * Deletes row with matching activationkey
     * @param  string $key activationkey
     * @return void
     */
    public function deleteKey( $key ) {
        Capsule::table('activations')->where('activationkey', $key)->delete();
    }

    /**
     * Checks if user already has a Key
     * @param  integer $userid User ID
     * @return mixed   Either string (activationkey) or boolean (false)
     */
    public function userAlreadyHasKey( $userid ) {

        $result = Capsule::table('activations')
                ->where('userid', $userid)
                ->take(1)
                ->get();

        return ($result) ? $result['activationkey'] : false;
    }

    /**
     * Supply Key, get ID
     * @param  string $key Key
     * @return mixed   
     */
    public function getUserIDFromKey( $key ) {

        $result = Capsule::table('activations')
                ->where('activationkey', $key)
                ->take(1)
                ->get();

        return ($result) ? $result['userid'] : false;
    }

    /**
     * Check if key is expired
     * @param  string $key 
     * @return bolean      
     */
    public function keyExpired( $key ) {

        $result = Capsule::table('activations')
                ->where('activationkey', $key)
                ->take(1)
                ->get();

        if ( $result )
            if ( $result['time'] - time() > 1000 )
                return true;
            else
                return false;
        else
            return false;
    }

    /**
     * Check IP matches
     * @param  string $key        
     * @param  string $current_ip 
     * @return boolean             
     */
    public function ipMatch( $key, $current_ip ) {
        
        $result = Capsule::table('activations')
                ->where('activationkey', $key)
                ->take(1)
                ->get();

        if ( $result ) {

            if ( $current_ip == "127.0.0.1" )
                return true;

            if ( $result['ip'] == $current_ip )
                return true;
            else
                return false;
        }
        else
            return false;

    }

    /**
     * Returns Active Users by ID
     * @return array
     */
    public function activeUsers() {

        $userids = Capsule::table('activeusers')->select('userid');

        return $userids;
    }

    public function insertActiveUsers(array $data) {

        $result = Capsule::table('activeusers')->insert([
            'userid'        => $data['userid'],
            'sessionid'     => $data['sessionkey'],
            'userlevel'     => $data['userlevel'],
            'ip'            => $data['ip'],
            'logintime'     => $data['time']
        ]);

        return ($result) ? true : false;
    }

    public function getActiveUsersBySessionId( $sessionid ) {

        $result = Capsule::table('activeusers')
                ->where('sessionid', $sessionid)
                ->take(1)
                ->get();

        return ($result) ? $result['userid'] : false;
    }

    public function destroyBrokenSessions( $userid ) {

        Capsule::table('activeusers')->where('userid', $userid)->delete();
    }
}