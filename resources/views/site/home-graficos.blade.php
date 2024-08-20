@extends('site.layout')
@section('title','Página Home')

@section('content')

@php
    use Illuminate\Support\Facades\Log;
    $chartData = \App\Http\Controllers\ChartController::getChartData();
    Log::info('Teste chartData =', $chartData);
@endphp

<!-- Novo Menu de Gráficos -->
<nav class="blue">
    <div class="nav-wrapper center-align">
        <ul id="nav-mobile" class="center">
            <li><a href="javascript:void(0);" class="active" onclick="showSection('graficos')">Gráficos</a></li>
            <li><a href="javascript:void(0);" onclick="showSection('sobre')">Sobre os Gráficos</a></li>
        </ul>
    </div>
</nav>

<!-- Seções de Conteúdo -->
<section id="graficos" class="content-section">
    <div class="row">
        <!-- Card de Seleção da Região -->
        <div class="col s12 m6 l2 region-menu-container">
            <div class="card">
                <div class="card-content">
                    <h5 class="region-title">Selecione a Região</h5>
                    <ul id="region-menu">
                        @foreach($regions as $index => $region)
                            <li>
                                <a href="javascript:void(0);" onclick="selectRegion('{{ $region['id'] }}', '{{ $region['description'] }}')" title="{{ $region['description'] }}" class="{{ $index === 0 ? 'active' : '' }}" data-id="{{ $region['id'] }}">
                                    {{ Str::limit($region['description'], 60) }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!-- Card de Seleção do Período -->
        <div class="col s12 m6 l2">
            <div class="card">
                <div class="card-content">
                    <h5 class="region-title">Selecione o Período</h5>
                    <ul id="period-menu" class="period-menu">
                        @foreach($periods as $index => $period)
                            <li>
                                <a href="javascript:void(0);" onclick="selectPeriod({{ $index }}, '{{ $period }}')" class="{{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}">
                                    {{ $period }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!-- Gráficos -->
        <div class="col s12 l8">
            <div class="card">
                <h3 id="chart-title">Gráfico: {{ $regions[0]['description'] }}</h3>
                <div class="grafico-container">
                    <canvas id="mainChart"></canvas>
                </div>
                @include('partials.charts.main_chart', ['chartData' => $chartData])
            </div>
        </div>
    </div>
</section>

<section id="sobre" class="content-section hidden">
    @include('partials.home.apresentacao')
</section>

@include('partials.home.parallax')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let mainChartInstance = null;
    let selectedPeriod = '1 semana'; // Período padrão

    function showSection(section) {
        document.querySelectorAll('.content-section').forEach(sec => sec.classList.add('hidden'));
        document.getElementById(section).classList.remove('hidden');

        document.querySelectorAll('#nav-mobile li a').forEach(item => item.classList.remove('active'));
        if (section === 'graficos') {
            document.querySelector('#nav-mobile li a[onclick="showSection(\'graficos\')"]').classList.add('active');
        } else if (section === 'sobre') {
            document.querySelector('#nav-mobile li a[onclick="showSection(\'sobre\')"]').classList.add('active');
        }
    }

    function selectRegion(id, description) {
        document.querySelectorAll('#region-menu li a').forEach(item => item.classList.remove('active'));
        document.querySelectorAll(`#region-menu li a`).forEach(item => {
            if (item.dataset.id == id) {
                item.classList.add('active');
            }
        });

        const chartTitleElement = document.getElementById('chart-title');
        if (chartTitleElement) {
            chartTitleElement.textContent = 'Gráfico: ' + description;
        } else {
            console.error('Element with id "chart-title" not found in the DOM.');
        }

        updateChartData(id, selectedPeriod);
    }

    function selectPeriod(index, period) {
        document.querySelectorAll('#period-menu li a').forEach(item => item.classList.remove('active'));
        document.querySelectorAll(`#period-menu li a`).forEach(item => {
            if (item.dataset.index == index) {
                item.classList.add('active');
            }
        });
        selectedPeriod = period;
        updateChartData(getSelectedRegion(), period);
    }

    function getSelectedRegion() {
        const selectedRegion = document.querySelector('#region-menu li a.active');
        return selectedRegion ? selectedRegion.dataset.id : null;
    }

    function updateChartData(regionId, period) {
        console.log('updateChartData chamada com regionId:', regionId, 'e period:', period);

        if (!regionId || !period) {
            console.error('Region ID ou period está faltando');
            return;
        }

        fetch('/update-chart', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ region_id: regionId, period: period })
        })
        .then(response => {
            console.log('Resposta recebida:', response);
            if (response.ok) {
                return response.json();
            } else {
                throw new Error('Resposta da rede não foi ok.');
            }
        })
        .then(data => {
            // Atualizar o gráfico com os dados recebidos
            console.log('Dados recebidos:', data);
            updateChart(data.chartData.mainChartData);
        })
        .catch(error => console.error('Erro ao atualizar gráfico:', error));
    }

    function updateChart(data) {
        // Destruir o gráfico existente se já houver um
        if (mainChartInstance) {
            mainChartInstance.destroy();
        }

        // Remover o elemento canvas antigo e criar um novo
        const canvasContainer = document.querySelector('.grafico-container');
        canvasContainer.innerHTML = '<canvas id="mainChart"></canvas>';

        // Criar o novo gráfico com os dados recebidos
        const ctx = document.getElementById('mainChart').getContext('2d');
        mainChartInstance = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Main Dataset',
                    data: data.data,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        showSection('graficos');
        selectPeriod(0, '1 semana'); // Define "1 semana" como o período selecionado por padrão
    });
</script>

@endsection
