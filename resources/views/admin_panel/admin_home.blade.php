@extends('layouts.admin')
<?php
use App\Models\Order;
use App\Models\Item;
use App\Models\User;
?>
@section('content')
    <div class="p-3">
        <div class="row flex-column flex-lg-row pt-md-4">
            <a href="/admin/orders" class="col text-decoration-none text-dark">
                <div class="card mb-3">
                    <div class="card-body">
                        <h3>{{ count(Order::all()) }}</h3>
                        <span class="text-secondary">
                            <i class="fa-solid fa-basket-shopping"></i>
                            Orders
                        </span>
                    </div>
                </div>
            </a>
            <a href="/admin/items" class="col text-decoration-none text-dark">
                <div class="card mb-3">
                    <div class="card-body">
                        <h3>{{ count(Item::all()) }}</h3>
                        <span class="text-secondary">
                            <i class="fa-solid fa-rectangle-list"></i>
                            Items
                        </span>
                    </div>
                </div>
            </a>
            <div class="col">
                <div class="card mb-3">
                    <div class="card-body">
                        <h3>{{ count(User::all()) }}</h3>
                        <span class="text-secondary">
                            <i class="fa fa-users"></i>
                            Users
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-12">
            <canvas class="w-100" id="orderChart" height="300"></canvas>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('orderChart').getContext('2d');
        var chartData = @json($chartData);

        var labels = chartData.labels;
        var datasets = chartData.datasets;

        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: datasets
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
