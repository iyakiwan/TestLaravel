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
            <canvas id="myChart" class="mt-3" height="150"></canvas>
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
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['01/12/2020', '02/12/2020', '03/12/2020', '04/12/2020', '05/12/2020', '06/12/2020'],
                datasets: [{
                    label: '# Penjualan',
                    data: [10000, 20000, 50000, 7500, 10000, 34500],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
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
