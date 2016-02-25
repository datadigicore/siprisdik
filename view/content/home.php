<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Dashboard
      <small>Menu</small>
    </h1>
    <ol class="breadcrumb">
      <li><i class="fa fa-dashboard"></i> Dashboard</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-aqua">
          <div class="inner">
            <h3>150</h3>
            <p>Laporan keluar</p>
          </div>
          <div class="icon">
            <i class="ion ion-document-text"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-green">
          <div class="inner">
            <h3>53<sup style="font-size: 20px">%</sup></h3>
            <p>Statistik Anggaran</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-yellow">
          <div class="inner">
            <h3>44</h3>
            <p>Orang terdaftar</p>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-red">
          <div class="inner">
            <h3>65</h3>
            <p>Data anggaran</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
    </div>
    <div class="row">
      <!-- <section class="col-lg-7 connectedSortable">
        <div id="chartBasic"></div>
      </section> -->
      <section class="col-lg-12 connectedSortable">
        <div id="chartDonut"></div>
      </section>
    </div>
  </section>
</div>
<script type="text/javascript">
  $(function () {
    $(document).ready(function () {
      $.ajax({
        type: "post",
        url : "<?php echo $url_rewrite.'process/report/laporan_bulanan_TA'; ?>",
        dataType: "json",
        success: function(result)
        {
          // alert(result);
          // chartbar.series[0].setData(result);
          chartpie.series[0].setData(result);
        }
      });
      // var chartbar = new Highcharts.Chart({
      //   chart: {
      //       renderTo : 'chartBasic',
      //       type: 'column'
      //   },
      //   title: {
      //       text: 'Rekap Data Bulanan Direktorat'
      //   },
      //   subtitle: {
      //       text: 'Kemenristek Dikti'
      //   },
      //   xAxis: {
      //       categories: [
      //           'Jan',
      //           'Feb',
      //           'Mar',
      //           'Apr',
      //           'May',
      //           'Jun',
      //           'Jul',
      //           'Aug',
      //           'Sep',
      //           'Okt',
      //           'Nov',
      //           'Des'
      //       ],
      //       crosshair: true
      //   },
      //   yAxis: {
      //       min: 0,
      //       title: {
      //           text: 'Rainfall (mm)'
      //       }
      //   },
      //   tooltip: {
      //       headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
      //       pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
      //           '<td style="padding:0"><b>{point.y:.1f} Rupiah</b></td></tr>',
      //       footerFormat: '</table>',
      //       shared: true,
      //       useHTML: true
      //   },
      //   plotOptions: {
      //       column: {
      //           pointPadding: 0.2,
      //           borderWidth: 0
      //       }
      //   },
      //   series: [{
      //       name: '5696',
      //       data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]
      //   }, {
      //       name: '5697',
      //       data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]
      //   }, {
      //       name: '5698',
      //       data: [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5, 106.6, 92.3]
      //   }, {
      //       name: '5699',
      //       data: [48.9, 38.8, 39.3, 41.4, 47.0, 48.3, 59.0, 59.6, 52.4, 65.2, 59.3, 51.2]
      //   }, {
      //       name: '5700',
      //       data: [42.4, 33.2, 34.5, 39.7, 52.6, 75.5, 57.4, 60.4, 47.6, 39.1, 46.8, 51.1]
      //   }]
      // });
      var chartpie = new Highcharts.Chart({
        chart: {
          renderTo: 'chartDonut',
          plotBackgroundColor: null,
          plotBorderWidth: null,
          plotShadow: false,
          type: 'pie'
        },
        title: {
          text: 'Realisasi Dana RKAKL'
        },
        tooltip: {
          pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
          pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
            enabled: false
          },
            showInLegend: true
          }
        },
        series: [{
          name: 'Prosentase',
          colorByPoint: true,
          data: [{
            name: 'Dana RKAKL',
            y: 56.33
            }, {
              name: '5696',
              y: 24.03,
              sliced: true,
              selected: true
            }, {
              name: '5697',
              y: 10.38
            }, {
              name: '5698',
              y: 4.77
            }, {
              name: '5699',
              y: 0.91
            }, {
            name: '5670',
            y: 0.2
          }]
        }]
      });
    });
  });
</script>
<script src="<?php echo $url_rewrite;?>static/plugins/highcharts/js/highcharts.js"></script>
<script src="<?php echo $url_rewrite;?>static/plugins/highcharts/js/modules/exporting.js"></script>