<?php
  require_once __DIR__ . "/../utility/database/mysql_db.php";

  class modelPengguna extends mysql_db {
    public function insertPengguna($data) {
      $nama       = $data['name'];
      $username   = $data['username'];
      $password   = $data['password'];
      $email      = $data['email'];
      $level      = $data['level'];
      $status     = $data['status'];

      $query      = "INSERT INTO pengguna SET
        nama      = '$nama',
        username  = '$username',
        password  = '$password',
        email     = '$email',
        level     = '$level',
        status    = '$status'
      ";

      $result = $this->query($query);
      return $result;
    }

    public function updatePengguna($data) {
      $id         = $data['id'];
      $nama       = $data['nama'];
      $username   = $data['username'];
      $password   = $data['password'];
      $email      = $data['email'];
      $keterangan = $data['keterangan'];

      $query       = "UPDATE pengguna SET
        nama       = '$nama',
        username   = '$username',
        password   = '$password',
        email      = '$email',
        keterangan = '$keterangan'
        WHERE id   = '$id'
      ";
      
      $result = $this->query($query);
      return $result;
    }

    public function deletePengguna($id) {
      $query = "delete from pengguna where id='$id'";
      $result = $this->query($query);
      return $result;
    }
    public function activatePengguna($id) {
      $query = "update pengguna set status = 1 where id='$id'";
      $result = $this->query($query);
      return $result;
    }
    public function deactivatePengguna($id) {
      $query = "update pengguna set status = 0 where id='$id'";
      $result = $this->query($query);
      return $result;
    }
    public function readPengguna($data) {
      $where  = $this->where($data);
      $query  = "SELECT * from pengguna $where";
      $result = $this->query($query);
      $fetch  = $this->fetch_object($result);
      return $fetch;
    }
  }

?>
