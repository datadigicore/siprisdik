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
        $THANG       = trim($data[$i]["A"]," \t\n\r\0\x0B\xA0");
        $KDJENDOK    = trim($data[$i]["B"]," \t\n\r\0\x0B\xA0");
        $KDSATKER    = trim($data[$i]["C"]," \t\n\r\0\x0B\xA0");
        $KDDEPT      = trim($data[$i]["D"]," \t\n\r\0\x0B\xA0");
        $KDUNIT      = trim($data[$i]["E"]," \t\n\r\0\x0B\xA0");
        $KDPROGRAM   = trim($data[$i]["F"]," \t\n\r\0\x0B\xA0");
        $KDGIAT      = trim($data[$i]["G"]," \t\n\r\0\x0B\xA0");
        $NMGIAT      = trim($data[$i]["H"]," \t\n\r\0\x0B\xA0");
        $KDOUTPUT    = trim($data[$i]["I"]," \t\n\r\0\x0B\xA0");
        $NMOUTPUT    = trim($data[$i]["J"]," \t\n\r\0\x0B\xA0");
        $KDSOUTPUT   = trim($data[$i]["K"]," \t\n\r\0\x0B\xA0");
        $NMSOUTPUT   = trim($data[$i]["L"]," \t\n\r\0\x0B\xA0");
        $KDKMPNEN    = trim($data[$i]["M"]," \t\n\r\0\x0B\xA0");
        $NMKMPNEN    = trim($data[$i]["N"]," \t\n\r\0\x0B\xA0");
        $KDSKMPNEN   = trim($data[$i]["O"]," \t\n\r\0\x0B\xA0");
        $NMSKMPNEN   = trim($data[$i]["P"]," \t\n\r\0\x0B\xA0");
        $KDAKUN      = trim($data[$i]["Q"]," \t\n\r\0\x0B\xA0");
        $NMAKUN      = trim($data[$i]["R"]," \t\n\r\0\x0B\xA0");
        $KDKPPN      = trim($data[$i]["S"]," \t\n\r\0\x0B\xA0");
        $KDBEBAN     = trim($data[$i]["T"]," \t\n\r\0\x0B\xA0");
        $KDJNSBAN    = trim($data[$i]["U"]," \t\n\r\0\x0B\xA0");
        $KDCTARIK    = trim($data[$i]["V"]," \t\n\r\0\x0B\xA0");
        $REGISTER    = trim($data[$i]["W"]," \t\n\r\0\x0B\xA0");
        $CARAHITUNG  = trim($data[$i]["X"]," \t\n\r\0\x0B\xA0");
        $HEADER1     = trim($data[$i]["Y"]," \t\n\r\0\x0B\xA0");
        $HEADER2     = trim($data[$i]["Z"]," \t\n\r\0\x0B\xA0");
        $KDHEADER    = trim($data[$i]["AA"]," \t\n\r\0\x0B\xA0");
        $NOITEM      = trim($data[$i]["AB"]," \t\n\r\0\x0B\xA0");
        $NMITEM      = trim($data[$i]["AC"]," \t\n\r\0\x0B\xA0");
        $VOL1        = trim($data[$i]["AD"]," \t\n\r\0\x0B\xA0");
        $SAT1        = trim($data[$i]["AE"]," \t\n\r\0\x0B\xA0");
        $VOL2        = trim($data[$i]["AF"]," \t\n\r\0\x0B\xA0");
        $SAT2        = trim($data[$i]["AG"]," \t\n\r\0\x0B\xA0");
        $VOL3        = trim($data[$i]["AH"]," \t\n\r\0\x0B\xA0");
        $SAT3        = trim($data[$i]["AI"]," \t\n\r\0\x0B\xA0");
        $VOL4        = trim($data[$i]["AJ"]," \t\n\r\0\x0B\xA0");
        $SAT4        = trim($data[$i]["AK"]," \t\n\r\0\x0B\xA0");
        $VOLKEG      = trim($data[$i]["AL"]," \t\n\r\0\x0B\xA0");
        $SATKEG      = trim($data[$i]["AM"]," \t\n\r\0\x0B\xA0");
        $HARGASAT    = trim($data[$i]["AN"]," \t\n\r\0\x0B\xA0");
        $JUMLAH      = trim($data[$i]["AO"]," \t\n\r\0\x0B\xA0");
        $JUMLAH2     = trim($data[$i]["AP"]," \t\n\r\0\x0B\xA0");
        $PAGUPHLN    = trim($data[$i]["AQ"]," \t\n\r\0\x0B\xA0");
        $PAGURMP     = trim($data[$i]["AR"]," \t\n\r\0\x0B\xA0");
        $PAGURKP     = trim($data[$i]["AS"]," \t\n\r\0\x0B\xA0");
        $KDBLOKIR    = trim($data[$i]["AT"]," \t\n\r\0\x0B\xA0");
        $BLOKIRPHLN  = trim($data[$i]["AU"]," \t\n\r\0\x0B\xA0");
        $BLOKIRRMP   = trim($data[$i]["AV"]," \t\n\r\0\x0B\xA0");
        $BLOKIRRKP   = trim($data[$i]["AW"]," \t\n\r\0\x0B\xA0");
        $RPHBLOKIR   = trim($data[$i]["AX"]," \t\n\r\0\x0B\xA0");
        $KDCOPY      = trim($data[$i]["AY"]," \t\n\r\0\x0B\xA0");
        $KDABT       = trim($data[$i]["AZ"]," \t\n\r\0\x0B\xA0");
        $KDSBU       = trim($data[$i]["BA"]," \t\n\r\0\x0B\xA0");
        $VOLSBK      = trim($data[$i]["BB"]," \t\n\r\0\x0B\xA0");
        $VOLRKAKL    = trim($data[$i]["BC"]," \t\n\r\0\x0B\xA0");
        $BLNKONTRAK  = trim($data[$i]["BD"]," \t\n\r\0\x0B\xA0");
        $NOKONTRAK   = trim($data[$i]["BE"]," \t\n\r\0\x0B\xA0");
        $TGKONTRAK   = trim($data[$i]["BF"]," \t\n\r\0\x0B\xA0");
        $NILKONTRAK  = trim($data[$i]["BG"]," \t\n\r\0\x0B\xA0");
        $JANUARI     = trim($data[$i]["BH"]," \t\n\r\0\x0B\xA0");
        $PEBRUARI    = trim($data[$i]["BI"]," \t\n\r\0\x0B\xA0");
        $MARET       = trim($data[$i]["BJ"]," \t\n\r\0\x0B\xA0");
        $APRIL       = trim($data[$i]["BK"]," \t\n\r\0\x0B\xA0");
        $MEI         = trim($data[$i]["BL"]," \t\n\r\0\x0B\xA0");
        $JUNI        = trim($data[$i]["BM"]," \t\n\r\0\x0B\xA0");
        $JULI        = trim($data[$i]["BN"]," \t\n\r\0\x0B\xA0");
        $AGUSTUS     = trim($data[$i]["BO"]," \t\n\r\0\x0B\xA0");
        $SEPTEMBER   = trim($data[$i]["BP"]," \t\n\r\0\x0B\xA0");
        $OKTOBER     = trim($data[$i]["BQ"]," \t\n\r\0\x0B\xA0");
        $NOPEMBER    = trim($data[$i]["BR"]," \t\n\r\0\x0B\xA0");
        $DESEMBER    = trim($data[$i]["BS"]," \t\n\r\0\x0B\xA0");
        $JMLTUNDA    = trim($data[$i]["BT"]," \t\n\r\0\x0B\xA0");
        $KDLUNCURAN  = trim($data[$i]["BU"]," \t\n\r\0\x0B\xA0");
        $JMLABT      = trim($data[$i]["BV"]," \t\n\r\0\x0B\xA0");
        $NOREV       = trim($data[$i]["BW"]," \t\n\r\0\x0B\xA0");
        $KDUBAH      = trim($data[$i]["BX"]," \t\n\r\0\x0B\xA0");
        $KURS        = trim($data[$i]["BY"]," \t\n\r\0\x0B\xA0");
        $INDEXKPJM   = trim($data[$i]["BZ"]," \t\n\r\0\x0B\xA0");
        $KDIB        = trim($data[$i]["CA"]," \t\n\r\0\x0B\xA0");
        $string .= "('".$THANG."','".$KDJENDOK."','".$KDSATKER."','".$KDDEPT."','".$KDUNIT."','".$KDPROGRAM."','".$KDGIAT."','".$NMGIAT."','".$KDOUTPUT."','".$NMOUTPUT."','".$KDSOUTPUT."','".$NMSOUTPUT."','".$KDKMPNEN."','".$NMKMPNEN."','".$KDSKMPNEN."','".$NMSKMPNEN."','".$KDAKUN."','".$NMAKUN."','".$KDKPPN."','".$KDBEBAN."','".$KDJNSBAN."','".$KDCTARIK."','".$REGISTER."','".$CARAHITUNG."','".$HEADER1."','".$HEADER2."','".$KDHEADER."','".$NOITEM."','".$NMITEM."','".$VOL1."','".$SAT1."','".$VOL2."','".$SAT2."','".$VOL3."','".$SAT3."','".$VOL4."','".$SAT4."','".$VOLKEG."','".$SATKEG."','".$HARGASAT."','".$JUMLAH."','".$JUMLAH2."','".$PAGUPHLN."','".$PAGURMP."','".$PAGURKP."','".$KDBLOKIR."','".$BLOKIRPHLN."','".$BLOKIRRMP."','".$BLOKIRRKP."','".$RPHBLOKIR."','".$KDCOPY."','".$KDABT."','".$KDSBU."','".$VOLSBK."','".$VOLRKAKL."','".$BLNKONTRAK."','".$NOKONTRAK."','".$TGKONTRAK."','".$NILKONTRAK."','".$JANUARI."','".$PEBRUARI."','".$MARET."','".$APRIL."','".$MEI."','".$JUNI."','".$JULI."','".$AGUSTUS."','".$SEPTEMBER."','".$OKTOBER."','".$NOPEMBER."','".$DESEMBER."','".$JMLTUNDA."','".$KDLUNCURAN."','".$JMLABT."','".$NOREV."','".$KDUBAH."','".$KURS."','".$INDEXKPJM."','".$KDIB."'),";
      }
      $query = substr($string,0,-1);
      $result = $this->query($query);
      return $result;
    }
  }

?>
