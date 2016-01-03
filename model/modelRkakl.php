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
        $THANG       = trim($data[$i]["A"]);
        $KDJENDOK    = trim($data[$i]["B"]);
        $KDSATKER    = trim($data[$i]["C"]);
        $KDDEPT      = trim($data[$i]["D"]);
        $KDUNIT      = trim($data[$i]["E"]);
        $KDPROGRAM   = trim($data[$i]["F"]);
        $KDGIAT      = trim($data[$i]["G"]);
        $NMGIAT      = trim($data[$i]["H"]);
        $KDOUTPUT    = trim($data[$i]["I"]);
        $NMOUTPUT    = trim($data[$i]["J"]);
        $KDSOUTPUT   = trim($data[$i]["K"]);
        $NMSOUTPUT   = trim($data[$i]["L"]);
        $KDKMPNEN    = trim($data[$i]["M"]);
        $NMKMPNEN    = trim($data[$i]["N"]);
        $KDSKMPNEN   = trim($data[$i]["O"]);
        $NMSKMPNEN   = trim($data[$i]["P"]);
        $KDAKUN      = trim($data[$i]["Q"]);
        $NMAKUN      = trim($data[$i]["R"]);
        $KDKPPN      = trim($data[$i]["S"]);
        $KDBEBAN     = trim($data[$i]["T"]);
        $KDJNSBAN    = trim($data[$i]["U"]);
        $KDCTARIK    = trim($data[$i]["V"]);
        $REGISTER    = trim($data[$i]["W"]);
        $CARAHITUNG  = trim($data[$i]["X"]);
        $HEADER1     = trim($data[$i]["Y"]);
        $HEADER2     = trim($data[$i]["Z"]);
        $KDHEADER    = trim($data[$i]["AA"]);
        $NOITEM      = trim($data[$i]["AB"]);
        $NMITEM      = trim($data[$i]["AC"]);
        $VOL1        = trim($data[$i]["AD"]);
        $SAT1        = trim($data[$i]["AE"]);
        $VOL2        = trim($data[$i]["AF"]);
        $SAT2        = trim($data[$i]["AG"]);
        $VOL3        = trim($data[$i]["AH"]);
        $SAT3        = trim($data[$i]["AI"]);
        $VOL4        = trim($data[$i]["AJ"]);
        $SAT4        = trim($data[$i]["AK"]);
        $VOLKEG      = trim($data[$i]["AL"]);
        $SATKEG      = trim($data[$i]["AM"]);
        $HARGASAT    = trim($data[$i]["AN"]);
        $JUMLAH      = trim($data[$i]["AO"]);
        $JUMLAH2     = trim($data[$i]["AP"]);
        $PAGUPHLN    = trim($data[$i]["AQ"]);
        $PAGURMP     = trim($data[$i]["AR"]);
        $PAGURKP     = trim($data[$i]["AS"]);
        $KDBLOKIR    = trim($data[$i]["AT"]);
        $BLOKIRPHLN  = trim($data[$i]["AU"]);
        $BLOKIRRMP   = trim($data[$i]["AV"]);
        $BLOKIRRKP   = trim($data[$i]["AW"]);
        $RPHBLOKIR   = trim($data[$i]["AX"]);
        $KDCOPY      = trim($data[$i]["AY"]);
        $KDABT       = trim($data[$i]["AZ"]);
        $KDSBU       = trim($data[$i]["BA"]);
        $VOLSBK      = trim($data[$i]["BB"]);
        $VOLRKAKL    = trim($data[$i]["BC"]);
        $BLNKONTRAK  = trim($data[$i]["BD"]);
        $NOKONTRAK   = trim($data[$i]["BE"]);
        $TGKONTRAK   = trim($data[$i]["BF"]);
        $NILKONTRAK  = trim($data[$i]["BG"]);
        $JANUARI     = trim($data[$i]["BH"]);
        $PEBRUARI    = trim($data[$i]["BI"]);
        $MARET       = trim($data[$i]["BJ"]);
        $APRIL       = trim($data[$i]["BK"]);
        $MEI         = trim($data[$i]["BL"]);
        $JUNI        = trim($data[$i]["BM"]);
        $JULI        = trim($data[$i]["BN"]);
        $AGUSTUS     = trim($data[$i]["BO"]);
        $SEPTEMBER   = trim($data[$i]["BP"]);
        $OKTOBER     = trim($data[$i]["BQ"]);
        $NOPEMBER    = trim($data[$i]["BR"]);
        $DESEMBER    = trim($data[$i]["BS"]);
        $JMLTUNDA    = trim($data[$i]["BT"]);
        $KDLUNCURAN  = trim($data[$i]["BU"]);
        $JMLABT      = trim($data[$i]["BV"]);
        $NOREV       = trim($data[$i]["BW"]);
        $KDUBAH      = trim($data[$i]["BX"]);
        $KURS        = trim($data[$i]["BY"]);
        $INDEXKPJM   = trim($data[$i]["BZ"]);
        $KDIB        = trim($data[$i]["CA"]);
        $string .= "('".$THANG."','".$KDJENDOK."','".$KDSATKER."','".$KDDEPT."','".$KDUNIT."','".$KDPROGRAM."','".$KDGIAT."','".$NMGIAT."','".$KDOUTPUT."','".$NMOUTPUT."','".$KDSOUTPUT."','".$NMSOUTPUT."','".$KDKMPNEN."','".$NMKMPNEN."','".$KDSKMPNEN."','".$NMSKMPNEN."','".$KDAKUN."','".$NMAKUN."','".$KDKPPN."','".$KDBEBAN."','".$KDJNSBAN."','".$KDCTARIK."','".$REGISTER."','".$CARAHITUNG."','".$HEADER1."','".$HEADER2."','".$KDHEADER."','".$NOITEM."','".$NMITEM."','".$VOL1."','".$SAT1."','".$VOL2."','".$SAT2."','".$VOL3."','".$SAT3."','".$VOL4."','".$SAT4."','".$VOLKEG."','".$SATKEG."','".$HARGASAT."','".$JUMLAH."','".$JUMLAH2."','".$PAGUPHLN."','".$PAGURMP."','".$PAGURKP."','".$KDBLOKIR."','".$BLOKIRPHLN."','".$BLOKIRRMP."','".$BLOKIRRKP."','".$RPHBLOKIR."','".$KDCOPY."','".$KDABT."','".$KDSBU."','".$VOLSBK."','".$VOLRKAKL."','".$BLNKONTRAK."','".$NOKONTRAK."','".$TGKONTRAK."','".$NILKONTRAK."','".$JANUARI."','".$PEBRUARI."','".$MARET."','".$APRIL."','".$MEI."','".$JUNI."','".$JULI."','".$AGUSTUS."','".$SEPTEMBER."','".$OKTOBER."','".$NOPEMBER."','".$DESEMBER."','".$JMLTUNDA."','".$KDLUNCURAN."','".$JMLABT."','".$NOREV."','".$KDUBAH."','".$KURS."','".$INDEXKPJM."','".$KDIB."'),";
      }
      $query = substr($string,0,-1);
      $result = $this->query($query);
      return $result;
    }
  }

?>
