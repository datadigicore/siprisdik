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
      $query      = "UPDATE rkakl_view SET
        status    = '0' WHERE
        tahun     = '$tahun'
      ";
      $result = $this->query($query);
      $query      = "INSERT INTO rkakl_view SET
        tanggal   = '$tanggal',
        filename  = '$filename',
        filesave  = '$filesave',
        keterangan= '$keterangan',
        tahun     = '$tahun',
        status    = '$status'
      ";
      $result = $this->query($query);
      return $result;
    }

    public function checkThang($data) {
      $query  = "SELECT tahun FROM rkakl_view WHERE
        tahun = '$data'";
      $result = $this->query($query);
      return $result;
    }

    public function clearRkakl($data) {
      $query  = "DELETE FROM rkakl_full WHERE
        thang = '$data' or
        thang = ''";
      $result = $this->query($query);
      return $result;
    }

    public function importRkakl($data) {
      $arrayCount = count($data);
      $string = "INSERT INTO rkakl_full (THANG,KDJENDOK,KDSATKER,KDDEPT,KDUNIT,KDPROGRAM,KDGIAT,NMGIAT,KDOUTPUT,NMOUTPUT,KDSOUTPUT,NMSOUTPUT,KDKMPNEN,NMKMPNEN,KDSKMPNEN,NMSKMPNEN,KDAKUN,NMAKUN,KDKPPN,KDBEBAN,KDJNSBAN,KDCTARIK,REGISTER,CARAHITUNG,HEADER1,HEADER2,KDHEADER,NOITEM,NMITEM,VOL1,SAT1,VOL2,SAT2,VOL3,SAT3,VOL4,SAT4,VOLKEG,SATKEG,HARGASAT,JUMLAH,JUMLAH2,PAGUPHLN,PAGURMP,PAGURKP,KDBLOKIR,BLOKIRPHLN,BLOKIRRMP,BLOKIRRKP,RPHBLOKIR,KDCOPY,KDABT,KDSBU,VOLSBK,VOLRKAKL,BLNKONTRAK,NOKONTRAK,TGKONTRAK,NILKONTRAK,JANUARI,PEBRUARI,MARET,APRIL,MEI,JUNI,JULI,AGUSTUS,SEPTEMBER,OKTOBER,NOPEMBER,DESEMBER,JMLTUNDA,KDLUNCURAN,JMLABT,NOREV,KDUBAH,KURS,INDEXKPJM,KDIB) VALUES ";
      for ($i=2; $i < $arrayCount; $i++) { 
        $THANG       = trim($data[$i]["A"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $KDJENDOK    = trim($data[$i]["B"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $KDSATKER    = trim($data[$i]["C"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $KDDEPT      = trim($data[$i]["D"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $KDUNIT      = trim($data[$i]["E"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $KDPROGRAM   = trim($data[$i]["F"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $KDGIAT      = trim($data[$i]["G"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $NMGIAT      = trim($data[$i]["H"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $KDOUTPUT    = trim($data[$i]["I"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $NMOUTPUT    = trim($data[$i]["J"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $KDSOUTPUT   = trim($data[$i]["K"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $NMSOUTPUT   = trim($data[$i]["L"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $KDKMPNEN    = trim($data[$i]["M"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $NMKMPNEN    = trim($data[$i]["N"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $KDSKMPNEN   = trim($data[$i]["O"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $NMSKMPNEN   = trim($data[$i]["P"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $KDAKUN      = trim($data[$i]["Q"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $NMAKUN      = trim($data[$i]["R"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $KDKPPN      = trim($data[$i]["S"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $KDBEBAN     = trim($data[$i]["T"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $KDJNSBAN    = trim($data[$i]["U"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $KDCTARIK    = trim($data[$i]["V"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $REGISTER    = trim($data[$i]["W"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $CARAHITUNG  = trim($data[$i]["X"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $HEADER1     = trim($data[$i]["Y"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $HEADER2     = trim($data[$i]["Z"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $KDHEADER    = trim($data[$i]["AA"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $NOITEM      = trim($data[$i]["AB"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $NMITEM      = trim($data[$i]["AC"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $VOL1        = trim($data[$i]["AD"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $SAT1        = trim($data[$i]["AE"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $VOL2        = trim($data[$i]["AF"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $SAT2        = trim($data[$i]["AG"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $VOL3        = trim($data[$i]["AH"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $SAT3        = trim($data[$i]["AI"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $VOL4        = trim($data[$i]["AJ"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $SAT4        = trim($data[$i]["AK"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $VOLKEG      = trim($data[$i]["AL"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $SATKEG      = trim($data[$i]["AM"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $HARGASAT    = trim($data[$i]["AN"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $JUMLAH      = trim($data[$i]["AO"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $JUMLAH2     = trim($data[$i]["AP"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $PAGUPHLN    = trim($data[$i]["AQ"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $PAGURMP     = trim($data[$i]["AR"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $PAGURKP     = trim($data[$i]["AS"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $KDBLOKIR    = trim($data[$i]["AT"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $BLOKIRPHLN  = trim($data[$i]["AU"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $BLOKIRRMP   = trim($data[$i]["AV"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $BLOKIRRKP   = trim($data[$i]["AW"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $RPHBLOKIR   = trim($data[$i]["AX"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $KDCOPY      = trim($data[$i]["AY"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $KDABT       = trim($data[$i]["AZ"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $KDSBU       = trim($data[$i]["BA"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $VOLSBK      = trim($data[$i]["BB"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $VOLRKAKL    = trim($data[$i]["BC"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $BLNKONTRAK  = trim($data[$i]["BD"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $NOKONTRAK   = trim($data[$i]["BE"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $TGKONTRAK   = trim($data[$i]["BF"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $NILKONTRAK  = trim($data[$i]["BG"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $JANUARI     = trim($data[$i]["BH"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $PEBRUARI    = trim($data[$i]["BI"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $MARET       = trim($data[$i]["BJ"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $APRIL       = trim($data[$i]["BK"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $MEI         = trim($data[$i]["BL"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $JUNI        = trim($data[$i]["BM"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $JULI        = trim($data[$i]["BN"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $AGUSTUS     = trim($data[$i]["BO"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $SEPTEMBER   = trim($data[$i]["BP"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $OKTOBER     = trim($data[$i]["BQ"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $NOPEMBER    = trim($data[$i]["BR"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $DESEMBER    = trim($data[$i]["BS"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $JMLTUNDA    = trim($data[$i]["BT"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $KDLUNCURAN  = trim($data[$i]["BU"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $JMLABT      = trim($data[$i]["BV"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $NOREV       = trim($data[$i]["BW"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $KDUBAH      = trim($data[$i]["BX"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $KURS        = trim($data[$i]["BY"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $INDEXKPJM   = trim($data[$i]["BZ"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $KDIB        = trim($data[$i]["CA"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $string .= "('".$THANG."','".$KDJENDOK."','".$KDSATKER."','".$KDDEPT."','".$KDUNIT."','".$KDPROGRAM."','".$KDGIAT."','".$NMGIAT."','".$KDOUTPUT."','".$NMOUTPUT."','".$KDSOUTPUT."','".$NMSOUTPUT."','".$KDKMPNEN."','".$NMKMPNEN."','".$KDSKMPNEN."','".$NMSKMPNEN."','".$KDAKUN."','".$NMAKUN."','".$KDKPPN."','".$KDBEBAN."','".$KDJNSBAN."','".$KDCTARIK."','".$REGISTER."','".$CARAHITUNG."','".$HEADER1."','".$HEADER2."','".$KDHEADER."','".$NOITEM."','".$NMITEM."','".$VOL1."','".$SAT1."','".$VOL2."','".$SAT2."','".$VOL3."','".$SAT3."','".$VOL4."','".$SAT4."','".$VOLKEG."','".$SATKEG."','".$HARGASAT."','".$JUMLAH."','".$JUMLAH2."','".$PAGUPHLN."','".$PAGURMP."','".$PAGURKP."','".$KDBLOKIR."','".$BLOKIRPHLN."','".$BLOKIRRMP."','".$BLOKIRRKP."','".$RPHBLOKIR."','".$KDCOPY."','".$KDABT."','".$KDSBU."','".$VOLSBK."','".$VOLRKAKL."','".$BLNKONTRAK."','".$NOKONTRAK."','".$TGKONTRAK."','".$NILKONTRAK."','".$JANUARI."','".$PEBRUARI."','".$MARET."','".$APRIL."','".$MEI."','".$JUNI."','".$JULI."','".$AGUSTUS."','".$SEPTEMBER."','".$OKTOBER."','".$NOPEMBER."','".$DESEMBER."','".$JMLTUNDA."','".$KDLUNCURAN."','".$JMLABT."','".$NOREV."','".$KDUBAH."','".$KURS."','".$INDEXKPJM."','".$KDIB."'),";
      }
      $query = substr($string,0,-1);
      $result = $this->query($query);
      return $result;
    }
  }

?>
