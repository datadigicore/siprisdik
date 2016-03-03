<?php
  require_once __DIR__ . "/../utility/database/mysql_db.php";

  class modelLogin extends mysql_db {
    public function readUser($data) {
      $where  = $this->where($data);
      $query  = "SELECT * from pengguna $where";
      $result = $this->query($query);
      $fetch  = $this->fetch_object($result);
      return $fetch;
    }
  }

?>
