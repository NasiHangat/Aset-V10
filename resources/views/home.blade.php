@extends('layouts.app')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.28.0/dist/apexcharts.min.js"></script>
<main id="main" class="main">

    <div class="pagetitle" style="margin-top:20px">
      <h1>Dashboard</h1>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">
        <!-- Grafik Aset -->
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <a href="{{ url('asetTetap') }}">
                <h5 class="card-title">Aset</h5>
              </a>
              <!-- Line Chart -->
              <div id="grafik"></div>
              <div id="myChart"></div>
              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  new ApexCharts(document.querySelector("#reportsChart"), {
                    series: [{
                      name: 'Aset Tetap',
                      data: [31, 40, 28, 51, 42, 82, 56],
                    }, {
                      name: 'Aset Bergerak',
                      data: [11, 32, 45, 32, 34, 52, 41]
                    }],
                    chart: {
                      height: 350,
                      type: 'area',
                      toolbar: {
                        show: false
                      },
                    },
                    markers: {
                      size: 4
                    },
                    colors: ['#4154f1', '#2eca6a', '#ff771d'],
                    fill: {
                      type: "gradient",
                      gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.3,
                        opacityTo: 0.4,
                        stops: [0, 90, 100]
                      }
                    },
                    dataLabels: {
                      enabled: false
                    },
                    stroke: {
                      curve: 'smooth',
                      width: 2
                    },
                    xaxis: {
                      type: 'date',
                      categories: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des"]
                    },
                    tooltip: {
                      x: {
                        format: 'dd/MM/yy'
                      },
                    }
                  }).render();
                });
              </script>
              <!-- End Line Chart -->
            </div>
          </div>
        </div>
        <!-- End Grafik Aset -->
        <!-- Grafik Barang Habis Pakai -->
        <div class="col-6">
          <div class="card">
            <div class="card-body">
              <a href="{{ url('items') }}">
                <h5 class="card-title">Barang Habis Pakai</h5>
              </a>
              <!-- Bar Chart -->
              <div id="grafik1" style="min-height: 400px; user-select: none;" class="echart" _echarts_instance_="ec_1689028823468">
                  <div style="position: relative; width: 443px; height: 400px; padding: 0px; margin: 0px; border-width: 0px; cursor: default;">
                      <canvas style="position: absolute; left: 0px; top: 0px; width: 443px; height: 400px; user-select: none; padding: 0px; margin: 0px; border-width: 0px;" data-zr-dom-id="zr_0" width="443" height="400"></canvas>
                  </div>
              </div>
              <!-- End Bar Chart -->
            </div>
          </div>
        </div>
        <!-- End Barang Habis Pakai -->
      </div>
    </section>

  </main>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script type="text/javascript">
  var aset1 = <?php echo json_encode($quantityBergerak) ?>;
  var aset2 = <?php echo json_encode($quantityTetap) ?>;
  var bulan = <?php echo json_encode($bulan) ?>;

  Highcharts.chart('grafik',{
    title : {
      text: 'Grafik Aset'
    },
    xAxis : {
      categories : bulan
    },
    yAxis : {
      title: {
        text : 'Nominal'
      }
    },
    plotOptions: {
      series: {
        allowPointSelect: true
      }
    },
    series: [
      {
        name: 'Bergerak',
        data: aset1
      },
      {
        name: 'Tetap',
        data: aset2
      }
    ]
  });
  
  var barang1 = <?php echo json_encode($quantityRT) ?>;
  var barang2 = <?php echo json_encode($quantityATK) ?>;
  var barang3 = <?php echo json_encode($quantityLab) ?>;
  var bulan1 = <?php echo json_encode($bulan1) ?>;

  Highcharts.chart('grafik1',{
    title : {
      text: 'Grafik Barang Habis Pakai'
    },
    xAxis : {
      categories : bulan1
    },
    yAxis : {
      title: {
        text : 'Nominal'
      }
    },
    plotOptions: {
      series: {
        allowPointSelect: true
      }
    },
    series: [
      {
        name: 'Rumah Tangga',
        data: barang1
      },
      {
        name: 'Laboratorium',
        data: barang3
      },
      {
        name: 'ATK',
        data: barang2
      }
    ]
  });
</script>


@endsection
