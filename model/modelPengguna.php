<?php
  require_once __DIR__ . "/../utility/database/mysql_db.php";

  class modelPengguna extends mysql_db {
    public function insertPengguna($data) {
      $nama       = $data['name'];
      $username   = $data['username'];
      $password   = $data['password'];
      $email      = $data['email'];
      $level      = $data['level'];
      $kode      = $data['kode'];
      // $kdprogram  = $data['kdprogram'];
      // $direktorat = $data['direktorat'];
      // $kdoutput   = $data['kdoutput'];
      $status     = $data['status'];

      $query      = "INSERT INTO pengguna SET
        nama      = '$nama',
        username  = '$username',
        password  = '$password',
        email     = '$email',
        level     = '$level',
        kdgrup    = '$kode',
        status    = '$status'
      ";

      $result = $this->query($query);
      return $result;
    }
    public function insertGroup($data) {
      $kode       = $data['kode'];
      $nama       = $data['name'];
      $kdprogram  = $data['kdprogram'];
      $direktorat = $data['direktorat'];
      $kdoutput   = $data['kdoutput'];

      $query      = "INSERT INTO grup SET
        kode      = '$kode',
        nama      = '$nama',
        kdprogram = '$kdprogram',
        direktorat= '$direktorat',
        kdoutput  = '$kdoutput'
      ";

      $result = $this->query($query);
      return $result;
    }

    public function updatePengguna($data) {
      $id         = $data['id'];
      $nama       = $data['name'];
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

    public function updatePengguna2($data) {
      $id         = $data['id'];
      $nama       = $data['name'];
      $username   = $data['username'];
      $email      = $data['email'];

      $query       = "UPDATE pengguna SET
        nama       = '$nama',
        username   = '$username',
        email      = '$email',
        WHERE id   = '$id'
      ";
      
      $result = $this->query($query);
      $_SESSION['nama'] = $nama;
      $_SESSION['username'] = $username;
      $_SESSION['email'] = $email;
      return $result;
    }
    public function updatePass($data) {
      $id         = $data['id'];
      $newpassword       = $utility->sha512($data['newpassword']);
      $query       = "UPDATE pengguna SET
        password       = '$newpassword'
        WHERE id   = '$id'
      ";
      
      $result = $this->query($query);
      return $result;
    }

    public function getPass($data){
      $id         = $data['id'];
      $query  = "SELECT password from pengguna where id = '$id'";
      $result = $this->query($query);
      $fetch  = $this->fetch_object($result);
      return $fetch->password;
    }

    public function getGroup() {
      $query  = "SELECT kode, nama FROM  grup as r";
      $result = $this->query($query);
      $i=0;
      while($fetch  = $this->fetch_object($result)) {
        $data[$fetch->kode] = $fetch->nama;
        $i++;
      }
      return $data;
    }
    public function editPengguna($data) {
      foreach ($data as $key => $value) {
        $setdata .= "$key = '$value', ";
      }
      $setdata = rtrim($setdata,', ');
      $query = "update pengguna set $setdata where id='$data[id]'";
      $result = $this->query($query);
      return $result;
    }
    public function editGrup($data) {
      $id         = $data['id_data'];
      $kode       = $data['kode'];
      $nama       = $data['name'];
      $kdprogram  = $data['kdprogram'];
      $direktorat = $data['direktorat'];
      $kdoutput   = $data['kdoutput'];
      // foreach ($data as $key => $value) {
        // if($key == "kdprogram" || $key == "direktorat" || $key == "kdoutput"){
        //   $strKode='';
        //   foreach ($value as $nilai) {
        //     if($strKode==""){
        //       $strKode = $nilai;
        //     } else {
        //       $strKode = $strKode.",".$nilai;
        //     }
        //   }
        //   $value = $strKode;
        // }

      //   $setdata .= "$key = '$value', ";
      // }
      $setdata = rtrim($setdata,', ');
      $query = "update grup set kode = '$kode', nama = '$nama', kdprogram = '$kdprogram', direktorat = '$direktorat', kdoutput = '$kdoutput' where id='$id'";
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
