<?php
namespace Cornpunch;

use Illuminate\Database\Capsule\Manager as Capsule;

class DatabaseSchema{

    protected $capsule;

    public function __construct(){
        $this->capsule = new Capsule;
    }

    public function initializeSchema(){

        $this->capsule->schema()->create('activeusers', function( $table ){
            $table->integer('userid')->unique();
            $table->string('sessionid');
            $table->integer('userlevel');
            $table->string('ip');
            $table->string('logtime');
        });

        $this->capsule->schema()->create('activations', function( $table ){
            $table->integer('userid')->unique();
            $table->string('activationkey');
            $table->string('ip');
            $table->integer('time');
        });

        $this->capsule->schema()->create('moviedata', function( $table){
            $table->increment('movieid')->primary();
            $table->integer('uploaderid');
            $table->json('moviedata');
        });

        $this->capsule->schema()->create('userdata', function( $table ){
            $table->integer('userid');
            $table->json('userdata');
        });

    }

}