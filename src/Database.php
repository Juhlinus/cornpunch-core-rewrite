<?php
namespace Cornpunch;

use Illuminate\Database\Capsule\Manager as Capsule;

class Database {
    
    protected $capsule;

    public function __construct() {
        $this->capsule = new Capsule;
        $this->config();
    }

    public function config() {
        $this->capsule->addConnection([
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => 'cornpunch',
            'username'  => 'root',
            'password'  => 'password',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]);
    }

    public function activeUsers() {
        $userids = Capsule::table('activeusers')->select('userid');

        return $userids;
    }
}