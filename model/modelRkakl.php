<?php
  require_once __DIR__ . "/../utility/database/mysql_db.php";

  class modelRkakl extends mysql_db {
    public function insertRkakl($data) {
      $tanggal    = $data['tanggal'];
      $filename   = $data['filename'];
      $filesave   = $data['filesave'];
      $keterangan = $data['keterangan'];
      $tahun      = $data['tahun'];
      $status     = $data['status'];
      $no_dipa    = $data['no_dipa'];

      $query      = "UPDATE rkakl_view SET
        status    = '0' WHERE
        tahun     = '$tahun'
      ";
      $result = $this->query($query);
      $cek_versi = "SELECT MAX(versi) AS max_versi FROM rkakl_view WHERE tahun = '$tahun'";
      $result = $this->query($cek_versi);
      while ($fetch = $this->fetch_object($result)) {
        $versi = $fetch->max_versi;
      }
      if (isset($data['pesan'])) {
        $pesan = $data['pesan'];
        $query      = "UPDATE rkakl_view SET
          pesan    = '$pesan' 
          WHERE tahun     = '$tahun'
          AND versi       = '$versi'
        ";
        $result = $this->query($query);
      }else{
        $pesan = "";
      }

      if (empty($versi) && $versi !== '0') {
        $query      = "INSERT INTO rkakl_view SET
          tanggal   = '$tanggal',
          no_dipa   = '$no_dipa',
          filename  = '$filename',
          filesave  = '$filesave',
          keterangan= '$keterangan',
          tahun     = '$tahun',
          status    = '$status'
        ";
        $result = $this->query($query);
      }
      else{
        $newversi   = $versi+1;
        $query      = "INSERT INTO rkakl_view SET
          tanggal   = '$tanggal',
          no_dipa   = '$no_dipa',
          filename  = '$filename',
          filesave  = '$filesave',
          keterangan= '$keterangan',
          tahun     = '$tahun',
          status    = '$status',
          pesan     = '$pesan',
          versi     = '$newversi'
        ";
        $result = $this->query($query);
        return $result;
      }
    }

    public function checkThang($data) {
      $query  = "SELECT tahun FROM rkakl_view WHERE
        tahun = '$data'";
      $result = $this->query($query);
      return $result;
    }

    public function cekVersi($tahun){
      $cek_versi = "SELECT MAX(versi) AS max_versi FROM rkakl_view WHERE tahun = '$tahun'";
      $result = $this->query($cek_versi);
      while ($fetch = $this->fetch_object($result)) {
        $versi = $fetch->max_versi;
      }
      return $versi;
    }

    public function hapusLastInsRkaklView($tahun){
      $query  = "DELETE FROM rkakl_view WHERE versi = (SELECT max_versi FROM (SELECT MAX(versi) AS max_versi FROM rkakl_view) AS tmp) AND tahun = '$tahun'";
      $result = $this->query($query);
      $query  = "UPDATE rkakl_view SET status = '1' WHERE versi = (SELECT max_versi FROM (SELECT MAX(versi) AS max_versi FROM rkakl_view) AS tmp) AND tahun = '$tahun'";
      $result = $this->query($query);
    }

    public function updDelRowHadRealisasi($tahun){
      $query = "SELECT IDRKAKL, REALISASI FROM rkakl_full WHERE versi = (SELECT pre_versi FROM (SELECT MAX(versi)-1 AS pre_versi FROM rkakl_view) AS tmp) AND THANG = '$tahun'";
      $result = $this->query($query);
      while ($field = $this->fetch_object($result)) {
        $break            = explode('.', $field->IDRKAKL);
        $row['idrkakl']   = $break[0];
        $row['realisasi'] = floatval($field->REALISASI);
        $query2 = "SELECT IDRKAKL, JUMLAH, REALISASI FROM rkakl_full WHERE IDRKAKL LIKE '$row[idrkakl]%' AND JUMLAH != REALISASI AND versi = (SELECT pre_versi FROM (SELECT MAX(versi) AS pre_versi FROM rkakl_view) AS tmp2) AND THANG = '$tahun' ORDER BY IDRKAKL";
        $result2 = $this->query($query2);
        while ($field2 = $this->fetch_object($result2)) {
          $row2['idrkakl']   = $field2->IDRKAKL;
          $row2['jumlah']    = floatval($field2->JUMLAH);
          $row2['realisasi'] = floatval($field2->REALISASI);
          $totalRealisasi    = $row['realisasi']+$row2['realisasi'];
          $jumlahAnggaran    = $row2['jumlah']-$totalRealisasi;
          if ($jumlahAnggaran < 0) {
            while ($jumlahAnggaran < 0) {
              $newRealisasi = $totalRealisasi+$jumlahAnggaran;
              $query3 = "UPDATE rkakl_full SET REALISASI = '$newRealisasi' WHERE IDRKAKL = '$row2[idrkakl]' AND versi = (SELECT pre_versi FROM (SELECT MAX(versi) AS pre_versi FROM rkakl_view) AS tmp) AND THANG = '$tahun'";
              $result3 = $this->query($query3);
              $query2 = "SELECT IDRKAKL, JUMLAH, REALISASI FROM rkakl_full WHERE IDRKAKL LIKE '$row[idrkakl]%' AND JUMLAH != REALISASI AND versi = (SELECT pre_versi FROM (SELECT MAX(versi) AS pre_versi FROM rkakl_view) AS tmp2) AND THANG = '$tahun' ORDER BY IDRKAKL";
              $result2 = $this->query($query2);
              while ($field2 = $this->fetch_object($result2)) {
                $row2['idrkakl']   = $field2->IDRKAKL;
                $row2['jumlah']    = floatval($field2->JUMLAH);
                $row2['realisasi'] = floatval($field2->REALISASI);
                $totalRealisasi    = $row['realisasi']+$row2['realisasi'];
                $jumlahAnggaran    = $row2['jumlah']-$totalRealisasi;
              }
            }
            $newRealisasi = $totalRealisasi+$jumlahAnggaran;
            $query3 = "UPDATE rkakl_full SET REALISASI = '$newRealisasi' WHERE IDRKAKL = '$row2[idrkakl]' AND versi = (SELECT pre_versi FROM (SELECT MAX(versi) AS pre_versi FROM rkakl_view) AS tmp) AND THANG = '$tahun'";
            $result3 = $this->query($query3);
            return true;
          }
          else {
            $query3 = "UPDATE rkakl_full SET REALISASI = '$totalRealisasi' WHERE IDRKAKL = '$row2[idrkakl]' AND versi = (SELECT pre_versi FROM (SELECT MAX(versi) AS pre_versi FROM rkakl_view) AS tmp) AND THANG = '$tahun'";
            $result3 = $this->query($query3);
            return true;
          }
        }
      }
    }

    public function cekRealisasi($data){
      $query = "SELECT * FROM rkakl_full WHERE IDRKAKL = '$data' AND REALISASI IS NOT NULL";
      $result = $this->query($query);
      $data = array();
      if ($result->num_rows != 0) {
        while ($row = $this->fetch_object($result)) {
          $data['idrkakl']   = $row->IDRKAKL;
          $data['realisasi'] = $row->REALISASI;
        }
        return $data;
      }
      else {
        return $result->num_rows;
      }
    }

    public function importRkakl($data) {
      $arrayCount = count($data);
      $string = "REPLACE INTO rkakl_full (IDRKAKL,THANG,KDJENDOK,KDSATKER,KDDEPT,KDUNIT,KDPROGRAM,KDGIAT,NMGIAT,KDOUTPUT,NMOUTPUT,KDSOUTPUT,NMSOUTPUT,KDKMPNEN,NMKMPNEN,KDSKMPNEN,NMSKMPNEN,KDAKUN,NMAKUN,KDKPPN,KDBEBAN,KDJNSBAN,KDCTARIK,REGISTER,CARAHITUNG,HEADER1,HEADER2,KDHEADER,NOITEM,NMITEM,VOL1,SAT1,VOL2,SAT2,VOL3,SAT3,VOL4,SAT4,VOLKEG,SATKEG,HARGASAT,JUMLAH,REALISASI,JUMLAH2,PAGUPHLN,PAGURMP,PAGURKP,KDBLOKIR,BLOKIRPHLN,BLOKIRRMP,BLOKIRRKP,RPHBLOKIR,KDCOPY,KDABT,KDSBU,VOLSBK,VOLRKAKL,BLNKONTRAK,NOKONTRAK,TGKONTRAK,NILKONTRAK,JANUARI,PEBRUARI,MARET,APRIL,MEI,JUNI,JULI,AGUSTUS,SEPTEMBER,OKTOBER,NOPEMBER,DESEMBER,JMLTUNDA,KDLUNCURAN,JMLABT,NOREV,KDUBAH,KURS,INDEXKPJM,KDIB,VERSI) VALUES ";
      $VERSION   = $this->cekVersi($data[2]["A"]);
      for ($i=2; $i < $arrayCount; $i++) {
        if (!empty($data[$i]["A"]) && !empty($data[$i]["Q"])) {
          $THANG       = trim($data[$i]["A"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $KDJENDOK    = trim($data[$i]["B"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $KDSATKER    = trim($data[$i]["C"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $KDDEPT      = trim($data[$i]["D"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $KDUNIT      = trim($data[$i]["E"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $KDPROGRAM   = trim($data[$i]["F"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $KDGIAT      = trim($data[$i]["G"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $NMGIAT      = trim($data[$i]["H"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $KDOUTPUT    = trim($data[$i]["I"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $NMOUTPUT    = trim($data[$i]["J"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $KDSOUTPUT   = trim($data[$i]["K"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $NMSOUTPUT   = trim($data[$i]["L"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $KDKMPNEN    = trim($data[$i]["M"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $NMKMPNEN    = trim($data[$i]["N"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $KDSKMPNEN   = trim($data[$i]["O"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $NMSKMPNEN   = trim($data[$i]["P"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $KDAKUN      = trim($data[$i]["Q"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $NMAKUN      = trim($data[$i]["R"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $KDKPPN      = trim($data[$i]["S"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $KDBEBAN     = trim($data[$i]["T"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $KDJNSBAN    = trim($data[$i]["U"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $KDCTARIK    = trim($data[$i]["V"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $REGISTER    = trim($data[$i]["W"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $CARAHITUNG  = trim($data[$i]["X"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $HEADER1     = trim($data[$i]["Y"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $HEADER2     = trim($data[$i]["Z"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $KDHEADER    = trim($data[$i]["AA"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $NOITEM      = trim($data[$i]["AB"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $NMITEM      = trim($data[$i]["AC"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $VOL1        = trim($data[$i]["AD"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $SAT1        = trim($data[$i]["AE"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $VOL2        = trim($data[$i]["AF"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $SAT2        = trim($data[$i]["AG"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $VOL3        = trim($data[$i]["AH"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $SAT3        = trim($data[$i]["AI"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $VOL4        = trim($data[$i]["AJ"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $SAT4        = trim($data[$i]["AK"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $VOLKEG      = trim($data[$i]["AL"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $SATKEG      = trim($data[$i]["AM"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $HARGASAT    = trim($data[$i]["AN"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $JUMLAH      = trim($data[$i]["AO"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $JUMLAH2     = trim($data[$i]["AP"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $PAGUPHLN    = trim($data[$i]["AQ"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $PAGURMP     = trim($data[$i]["AR"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $PAGURKP     = trim($data[$i]["AS"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $KDBLOKIR    = trim($data[$i]["AT"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $BLOKIRPHLN  = trim($data[$i]["AU"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $BLOKIRRMP   = trim($data[$i]["AV"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $BLOKIRRKP   = trim($data[$i]["AW"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $RPHBLOKIR   = trim($data[$i]["AX"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $KDCOPY      = trim($data[$i]["AY"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $KDABT       = trim($data[$i]["AZ"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $KDSBU       = trim($data[$i]["BA"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $VOLSBK      = trim($data[$i]["BB"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $VOLRKAKL    = trim($data[$i]["BC"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $BLNKONTRAK  = trim($data[$i]["BD"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $NOKONTRAK   = trim($data[$i]["BE"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $TGKONTRAK   = trim($data[$i]["BF"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $NILKONTRAK  = trim($data[$i]["BG"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $JANUARI     = trim($data[$i]["BH"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $PEBRUARI    = trim($data[$i]["BI"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $MARET       = trim($data[$i]["BJ"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $APRIL       = trim($data[$i]["BK"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $MEI         = trim($data[$i]["BL"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $JUNI        = trim($data[$i]["BM"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $JULI        = trim($data[$i]["BN"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $AGUSTUS     = trim($data[$i]["BO"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $SEPTEMBER   = trim($data[$i]["BP"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $OKTOBER     = trim($data[$i]["BQ"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $NOPEMBER    = trim($data[$i]["BR"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $DESEMBER    = trim($data[$i]["BS"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $JMLTUNDA    = trim($data[$i]["BT"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $KDLUNCURAN  = trim($data[$i]["BU"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $JMLABT      = trim($data[$i]["BV"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $NOREV       = trim($data[$i]["BW"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $KDUBAH      = trim($data[$i]["BX"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $KURS        = trim($data[$i]["BY"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $INDEXKPJM   = trim($data[$i]["BZ"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");
          $KDIB        = trim($data[$i]["CA"]," \t\n\r\0\x0B\xA0\x0D\x0A\x20");   
          $IDRKAKL     = $KDJENDOK.$KDSATKER.$KDDEPT.$KDUNIT.$KDPROGRAM.$KDGIAT.$KDOUTPUT.$KDSOUTPUT.$KDKMPNEN.$KDSKMPNEN.$KDAKUN.'.'.$NOITEM;
          $CEKREALISASI= $this->cekRealisasi($IDRKAKL);
          if ($CEKREALISASI != 0) {
            if ($CEKREALISASI['realisasi'] > $JUMLAH) {
              $this->hapusLastInsRkaklView($THANG);
              return false;
            }
            else {
              $string .= "('".$IDRKAKL."','".$THANG."','".$KDJENDOK."','".$KDSATKER."','".$KDDEPT."','".$KDUNIT."','".$KDPROGRAM."','".$KDGIAT."','".$NMGIAT."','".$KDOUTPUT."','".$NMOUTPUT."','".$KDSOUTPUT."','".$NMSOUTPUT."','".$KDKMPNEN."','".$NMKMPNEN."','".$KDSKMPNEN."','".$NMSKMPNEN."','".$KDAKUN."','".$NMAKUN."','".$KDKPPN."','".$KDBEBAN."','".$KDJNSBAN."','".$KDCTARIK."','".$REGISTER."','".$CARAHITUNG."','".$HEADER1."','".$HEADER2."','".$KDHEADER."','".$NOITEM."','".$NMITEM."','".$VOL1."','".$SAT1."','".$VOL2."','".$SAT2."','".$VOL3."','".$SAT3."','".$VOL4."','".$SAT4."','".$VOLKEG."','".$SATKEG."','".$HARGASAT."','".$JUMLAH."','".$CEKREALISASI['realisasi']."','".$JUMLAH2."','".$PAGUPHLN."','".$PAGURMP."','".$PAGURKP."','".$KDBLOKIR."','".$BLOKIRPHLN."','".$BLOKIRRMP."','".$BLOKIRRKP."','".$RPHBLOKIR."','".$KDCOPY."','".$KDABT."','".$KDSBU."','".$VOLSBK."','".$VOLRKAKL."','".$BLNKONTRAK."','".$NOKONTRAK."','".$TGKONTRAK."','".$NILKONTRAK."','".$JANUARI."','".$PEBRUARI."','".$MARET."','".$APRIL."','".$MEI."','".$JUNI."','".$JULI."','".$AGUSTUS."','".$SEPTEMBER."','".$OKTOBER."','".$NOPEMBER."','".$DESEMBER."','".$JMLTUNDA."','".$KDLUNCURAN."','".$JMLABT."','".$NOREV."','".$KDUBAH."','".$KURS."','".$INDEXKPJM."','".$KDIB."','".$VERSION."'),";
            }
          }
          else {
            $string .= "('".$IDRKAKL."','".$THANG."','".$KDJENDOK."','".$KDSATKER."','".$KDDEPT."','".$KDUNIT."','".$KDPROGRAM."','".$KDGIAT."','".$NMGIAT."','".$KDOUTPUT."','".$NMOUTPUT."','".$KDSOUTPUT."','".$NMSOUTPUT."','".$KDKMPNEN."','".$NMKMPNEN."','".$KDSKMPNEN."','".$NMSKMPNEN."','".$KDAKUN."','".$NMAKUN."','".$KDKPPN."','".$KDBEBAN."','".$KDJNSBAN."','".$KDCTARIK."','".$REGISTER."','".$CARAHITUNG."','".$HEADER1."','".$HEADER2."','".$KDHEADER."','".$NOITEM."','".$NMITEM."','".$VOL1."','".$SAT1."','".$VOL2."','".$SAT2."','".$VOL3."','".$SAT3."','".$VOL4."','".$SAT4."','".$VOLKEG."','".$SATKEG."','".$HARGASAT."','".$JUMLAH."',0,'".$JUMLAH2."','".$PAGUPHLN."','".$PAGURMP."','".$PAGURKP."','".$KDBLOKIR."','".$BLOKIRPHLN."','".$BLOKIRRMP."','".$BLOKIRRKP."','".$RPHBLOKIR."','".$KDCOPY."','".$KDABT."','".$KDSBU."','".$VOLSBK."','".$VOLRKAKL."','".$BLNKONTRAK."','".$NOKONTRAK."','".$TGKONTRAK."','".$NILKONTRAK."','".$JANUARI."','".$PEBRUARI."','".$MARET."','".$APRIL."','".$MEI."','".$JUNI."','".$JULI."','".$AGUSTUS."','".$SEPTEMBER."','".$OKTOBER."','".$NOPEMBER."','".$DESEMBER."','".$JMLTUNDA."','".$KDLUNCURAN."','".$JMLABT."','".$NOREV."','".$KDUBAH."','".$KURS."','".$INDEXKPJM."','".$KDIB."','".$VERSION."'),";
          }
        }
      }
      $query = substr($string,0,-1);
      $result= $this->query($query);
      $tahun = $data[2]["A"];
      $versi = $this->cekVersi($tahun);
      if ($versi != 0) {
        $this->updDelRowHadRealisasi($tahun);
      }
      $query = "CREATE TABLE rkakl_full_".$tahun."_".$versi."
        AS (SELECT * FROM rkakl_full)
      ";
      $result= $this->query($query);
      return $result;
    }
  }

?>
