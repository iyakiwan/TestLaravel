@extends('layouts/app')

@section('content')
    <div class="row">
        <div class="col-9">
            <div class="row">
                <div class="col-3">
                    <div class="card bg-light mb-3" style="max-width: 18rem;">
                        <div class="card-body text-center">
                            <h1>{{$data->menunggu}}</h1>
                            <h5 class="card-title">Menunggu</h5>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card bg-light mb-3" style="max-width: 18rem;">
                        <div class="card-body text-center">
                            <h1>{{$data->terima}}</h1>
                            <h5 class="card-title">Diterima</h5>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card bg-light mb-3" style="max-width: 18rem;">
                        <div class="card-body text-center">
                            <h1>{{$data->tolak}}</h1>
                            <h5 class="card-title">Ditolak</h5>
                        </div>
                    </div>
                </div>
            </div>
            <h3 class="mt-3">Data Statistik</h3>
            <h4 class="mt-2">Arus Masuk</h4>
            <canvas id="myChartMasuk" class="mt-3" height="150"></canvas>
            <h4 class="mt-2">Arus Keluar</h4>
            <canvas id="myChartKeluar" class="mt-3" height="150"></canvas>
        </div>
        <div class="col-3 text-center">
            <div class="card text-white bg-app mb-3" style="max-width: 18rem;">
                <div class="card-header">TRANSAKSI BERHASIL</div>
                <div class="card-body">
                    <h1 class="card-title">128</h1>
                </div>
            </div>
            <div class="card text-white bg-app mb-3 mt-5" style="max-width: 18rem;">
                <div class="card-header">TRANSAKSI GAGAL</div>
                <div class="card-body">
                    <h1 class="card-title">14</h1>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        var arus_masuk_label = <?php echo $arus_masuk_label; ?>;
        var arus_masuk_data = <?php echo $arus_masuk_data; ?>;
        var arus_keluar_label = <?php echo $arus_keluar_label; ?>;
        var arus_keluar_data = <?php echo $arus_keluar_data; ?>;
        
        var ctxMasuk = document.getElementById('myChartMasuk').getContext('2d');
        var ctxKeluar = document.getElementById('myChartKeluar').getContext('2d');
        var myChartMasuk = new Chart(ctxMasuk, {
            type: 'line',
            data: {
                labels: arus_masuk_label,
                datasets: [{
                    label: 'Arus Masuk',
                    data: arus_masuk_data,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
        var myChartKeluar = new Chart(ctxKeluar, {
            type: 'line',
            data: {
                labels: arus_keluar_label,
                datasets: [{
                    label: 'Arus Keluar',
                    data: arus_keluar_data,
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
@endpush
