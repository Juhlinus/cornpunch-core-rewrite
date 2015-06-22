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
     * Returns Active Users by ID
     * @return array
     */
    public function activeUsers() {
        $userids = Capsule::table('activeusers')->select('userid');

        return $userids;
    }
}