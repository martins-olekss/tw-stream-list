<?php

class Core_Database{
    private $conn;

    public function __construct() {

        $config = new Core_Config();
        $configValues = $config->getConfig();

        $host = $configValues['db_host'];
        $user = $configValues['db_user'];
        $db = $configValues['db_name'];
        $pass = $configValues['db_password'];

        $this->conn = new PDO("mysql:host=".$host.";dbname=".$db,$user,$pass,
            array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
        //debug
        $this->conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
    }

    public function updateStatus($twitch_name,$status,$game,$title,$logo,$viewers){

        $sql = "UPDATE streams
        SET status=:status, game=:game, title=:title, logo=:logo, viewers=:viewers
        WHERE twitch_name=:twitch_name";
        $q = $this->conn->prepare($sql);
        $q->execute(array(
            ':twitch_name'=>$twitch_name,
            ':status'=>$status,
            ':game'=>$game,
            ':title'=>$title,
            ':logo'=>$logo,
            ':viewers'=>$viewers
        ));
        return true;
    }

    public function getStreamerData(){
        $data = array();
        $sql="SELECT * FROM streams ORDER BY status DESC, twitch_name ASC";
        $q = $this->conn->query($sql) or die("failed!");
        while($r = $q->fetch(PDO::FETCH_ASSOC)){
            $data[]=$r;
        }
        return $data;
    }

    public function getNames(){
        $data = array();
        $sql="SELECT twitch_name FROM streams";
        $q = $this->conn->query($sql) or die("failed!");
        while($r = $q->fetch(PDO::FETCH_ASSOC)){
            $data[]=$r['twitch_name'];
        }
        return $data;
    }

    public function dataByName($name){
        $data = array();
        $sql="SELECT title, status, game, logo, viewers FROM streams WHERE twitch_name='{$name}' LIMIT 1";
        $q = $this->conn->query($sql) or die("failed!");
        while($r = $q->fetch(PDO::FETCH_ASSOC)){
            $data=$r;
        }
        return $data;
    }

    public function addStreamer($username) {
        $sql = "INSERT INTO streams
                (twitch_name, status)
                VALUES (?, ?);";
        $q = $this->conn->prepare($sql);
        $q->execute(array($username,'0'));
        return true;
    }

    /**
     * Create main table for streamer data
     *
     * @return bool
     */
    public function install() {
        $sql = "CREATE TABLE IF NOT EXISTS streams (
        id int(11) NOT NULL AUTO_INCREMENT,
        twitch_name varchar(80) DEFAULT NULL,
        status int(11) DEFAULT NULL,
        game varchar(256) DEFAULT NULL,
        title varchar(512) DEFAULT NULL,
        viewers int(11) DEFAULT NULL,
        logo varchar(512) DEFAULT NULL,
        PRIMARY KEY (id),
        UNIQUE KEY twitch_name_UNIQUE (twitch_name)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;";

        $this->conn->exec($sql);
        return true;
    }
}