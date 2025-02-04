<?php

// Instantiate the report

use Admin\Project\Auth\Class\UserManager;
use Admin\Project\Models\FinancialReport;
use Carbon\Carbon;

$report = new FinancialReport();
$userManager = new UserManager();

if (!$userManager->hasUserToken()) {
    header('Location: / ');
}

// Get current month's data
$currentMonthStart = date('Y-m-01');
$currentMonthEnd = date('Y-m-t');

$totalRevenue = $report->getTotalRevenue($currentMonthStart, $currentMonthEnd);
$totalExpenses = $report->getTotalExpenses($currentMonthStart, $currentMonthEnd);
$netProfit = $totalRevenue - $totalExpenses;

$paymentMethodBreakdown = $report->getPaymentMethodBreakdown($currentMonthStart, $currentMonthEnd);
$topProducts = $report->getTopProducts();
$monthlyRevenueTrend = $report->getMonthlyRevenueTrend();

Carbon::setLocale('pt_BR'); // Define o locale para português
$mesAno = Carbon::now()->translatedFormat('F Y'); // Retorna "Outubro 2023"

?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Relatório Financeiro</title>
    <link rel="stylesheet" href="/../../../public/styles/dashboard/financialReport.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="financial-dashboard">
        <div>
            <form action="/painel">
                <button class="button_exit" type="submit">
                    <span class="info_exit"><img src="../../../public/assets/seta.png" alt=""> Voltar para o
                        painel</span>
                </button>
            </form>
        </div>

        <h1>Relatório Financeiro - <?= ucfirst($mesAno) ?></h1>

        <div class="summary-cards">
            <div class="card">
                <h3>Receita Total</h3>
                <p>R$ <?= number_format($totalRevenue, 2, ',', '.') ?></p>
            </div>
            <div class="card">
                <h3>Despesas</h3>
                <p>R$ <?= number_format($totalExpenses, 2, ',', '.') ?></p>
            </div>
            <div class="card">
                <h3>Lucro Líquido</h3>
                <p>R$ <?= number_format($netProfit, 2, ',', '.') ?></p>
            </div>
        </div>

        <div class="charts-container">
            <div class="chart">
                <h3>Métodos de Pagamento</h3>
                <canvas id="paymentMethodChart"></canvas>
            </div>

            <div class="chart">
                <h3>Produtos Mais Vendidos</h3>
                <canvas id="topProductsChart"></canvas>
            </div>

            <div class="chart">
                <h3>Tendência de Receita Mensal</h3>
                <canvas id="monthlyRevenueChart"></canvas>
            </div>
        </div>
    </div>
    <script>
        // Configurar WebSocket
        const ws = new WebSocket('ws://localhost:3000');

        // Variáveis para armazenar os gráficos
        let paymentMethodChart, topProductsChart, monthlyRevenueChart;



        // Função para inicializar os gráficos
        function initializeCharts(data) {
            // Payment Method Chart
            const paymentCtx = document.getElementById('paymentMethodChart');
            paymentMethodChart = new Chart(paymentCtx, {
                type: 'pie',
                data: {
                    labels: data.paymentMethodBreakdown.map(item => item.Metodo_Pagamento),
                    datasets: [{
                        data: data.paymentMethodBreakdown.map(item => item.total_amount),
                        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56']
                    }]
                }
            });

            // Top Products Chart
            const productsCtx = document.getElementById('topProductsChart');
            topProductsChart = new Chart(productsCtx, {
                type: 'bar',
                data: {
                    labels: data.topProducts.map(item => item.product_name),
                    datasets: [{
                        label: 'Receita',
                        data: data.topProducts.map(item => item.total_revenue),
                        backgroundColor: '#42A5F5'
                    }]
                }
            });

            // Monthly Revenue Chart
            const revenueCtx = document.getElementById('monthlyRevenueChart');
            monthlyRevenueChart = new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: data.monthlyRevenueTrend.map(item => item.month),
                    datasets: [{
                        label: 'Receita Mensal',
                        data: data.monthlyRevenueTrend.map(item => item.total_revenue),
                        borderColor: '#66BB6A',
                        fill: false
                    }]
                }
            });
        }

        // Função para atualizar os gráficos
        function updateCharts(data) {

            const formatter = new Intl.NumberFormat('pt-BR', {
                style: 'currency',
                currency: 'BRL',
            });

            // Atualizar cartões de resumo
            const totalRevenue = parseFloat(data.totalRevenue[0].total_revenue || 0);
            const totalExpenses = parseFloat(data.totalExpenses[0].total_expenses || 0);
            const profit = totalRevenue - totalExpenses;

            document.querySelector('.card:nth-child(1) p').textContent =
                formatter.format(totalRevenue);

            document.querySelector('.card:nth-child(2) p').textContent =
                formatter.format(totalRevenue);

            document.querySelector('.card:nth-child(3) p').textContent =
                formatter.format(totalRevenue);

            // Atualizar gráficos
            if (paymentMethodChart) {
                paymentMethodChart.data.labels = data.paymentMethodBreakdown.map(item => item.Metodo_Pagamento);
                paymentMethodChart.data.datasets[0].data = data.paymentMethodBreakdown.map(item => parseFloat(item.total_amount || 0));
                paymentMethodChart.update();
            }

            if (topProductsChart) {
                topProductsChart.data.labels = data.topProducts.map(item => item.product_name);
                topProductsChart.data.datasets[0].data = data.topProducts.map(item => parseFloat(item.total_revenue || 0));
                topProductsChart.update();
            }

            if (monthlyRevenueChart) {
                monthlyRevenueChart.data.labels = data.monthlyRevenueTrend.map(item => item.month);
                monthlyRevenueChart.data.datasets[0].data = data.monthlyRevenueTrend.map(item => parseFloat(item.total_revenue || 0));
                monthlyRevenueChart.update();
            }
        }
        // Evento de conexão do WebSocket
        ws.onopen = () => {
            console.log('Conectado ao servidor WebSocket');
        };

        // Evento de recebimento de dados
        ws.onmessage = (event) => {
            const data = JSON.parse(event.data);

            if (!paymentMethodChart) {
                // Primeira vez - inicializar gráficos
                initializeCharts(data);
            } else {
                // Atualizar gráficos existentes
                updateCharts(data);
            }
        };

        // Tratamento de erros
        ws.onerror = (error) => {
            console.error('Erro no WebSocket:', error);
        };
    </script>
</body>

</html>