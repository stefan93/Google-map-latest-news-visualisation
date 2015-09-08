<?php
    class DB {
        
        public $num,$res;
        private $con;
        
        public function __construct(){
            $this->connect();
        }
        
        
        private function connect() {
            $c=mysqli_connect(Config::get("db/host"),Config::get("db/username"),Config::get("db/password"),Config::get("db/database"));
            $this->con=$c;
        }
        
        
        public function get($sql) {
            $this->res=array();
            $h=mysqli_query($this->con,$sql);
            $this->num=mysqli_num_rows($h);
            while ($r=mysqli_fetch_assoc($h)) {
                $this->res[]=$r;
            }
        }
        
        public function set($sql) {
            $h=mysqli_query($this->con,$sql) or die(mysqli_error($this->con));
            $this->num=mysqli_affected_rows($this->con);
        }
        public function last_id() {
            return mysqli_insert_id($this->con);
        }
        
    }

?>