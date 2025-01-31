<?php

// Instantiate the report

use Admin\Project\Models\FinancialReport;

$report = new FinancialReport();

// Get current month's data
$currentMonthStart = date('Y-m-01');
$currentMonthEnd = date('Y-m-t');

$totalRevenue = $report->getTotalRevenue(null, null);
$totalExpenses = $report->getTotalExpenses(null, null);
$netProfit = $totalRevenue - $totalExpenses;

$paymentMethodBreakdown = $report->getPaymentMethodBreakdown($currentMonthStart, $currentMonthEnd);
$topProducts = $report->getTopProducts();
$monthlyRevenueTrend = $report->getMonthlyRevenueTrend();

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

        <h1>Relatório Financeiro - <?= date('F Y') ?></h1>

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
        // Payment Method Chart
        const paymentData = <?= json_encode(array_column($paymentMethodBreakdown, 'total_amount', 'Metodo_Pagamento')) ?>;
        new Chart(document.getElementById('paymentMethodChart'), {
            type: 'pie',
            data: {
                labels: Object.keys(paymentData),
                datasets: [{
                    data: Object.values(paymentData),
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56']
                }]
            }
        });

        // Top Products Chart
        const topProductsData = <?= json_encode(array_column($topProducts, 'total_revenue', 'product_name')) ?>;
        new Chart(document.getElementById('topProductsChart'), {
            type: 'bar',
            data: {
                labels: Object.keys(topProductsData),
                datasets: [{
                    label: 'Receita',
                    data: Object.values(topProductsData),
                    backgroundColor: '#42A5F5'
                }]
            }
        });

        // Monthly Revenue Chart
        const monthlyRevenueData = <?= json_encode(array_column($monthlyRevenueTrend, 'total_revenue', 'month')) ?>;
        new Chart(document.getElementById('monthlyRevenueChart'), {
            type: 'line',
            data: {
                labels: Object.keys(monthlyRevenueData),
                datasets: [{
                    label: 'Receita Mensal',
                    data: Object.values(monthlyRevenueData),
                    borderColor: '#66BB6A',
                    fill: false
                }]
            }
        });
    </script>
</body>

</html>