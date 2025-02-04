const WebSocket = require('ws');
const mysql = require('mysql2/promise'); // Note: Changed to mysql2 for better Promise support

// Configuração de Pool de Conexão
const pool = mysql.createPool({
    host: 'localhost', // Added host parameter
    user: 'user_app',
    password: 'password',
    database: 'lldb',
    port: 3306,
    waitForConnections: true,
    connectionLimit: 10,
    queueLimit: 0
});

// Função para buscar dados financeiros
async function fetchFinancialData() {
    try {
        const queries = {
            totalRevenue: `SELECT 
                SUM(CAST(REPLACE(Valor_Total, ',', '.') AS DECIMAL(10,2))) as total_revenue 
                FROM Pedidos WHERE Status = 'Concluído'`,
            
            totalExpenses: `SELECT 
                SUM(pp.Quantidade * p.Preco_Custo) as total_expenses
                FROM Pedidos_Produtos pp
                JOIN Produtos p ON pp.ID_Produto = p.ID_Produto
                JOIN Pedidos ped ON pp.ID_Pedido = ped.ID_Pedido
                WHERE ped.Status = 'Concluído'`,
            
            paymentMethodBreakdown: `SELECT 
                Metodo_Pagamento, 
                COUNT(*) as transaction_count,
                SUM(CAST(REPLACE(Valor_Total, ',', '.') AS DECIMAL(10,2))) as total_amount
                FROM Pagamentos p
                JOIN Pedidos ped ON p.ID_Pedido = ped.ID_Pedido
                WHERE ped.Status = 'Concluído'
                GROUP BY Metodo_Pagamento`,
            
            topProducts: `SELECT 
                p.Nome as product_name, 
                SUM(pp.Quantidade) as total_quantity,
                SUM(CAST(pp.Valor_Total AS DECIMAL(10,2))) as total_revenue
                FROM Pedidos_Produtos pp
                JOIN Produtos p ON pp.ID_Produto = p.ID_Produto
                JOIN Pedidos ped ON pp.ID_Pedido = ped.ID_Pedido
                WHERE ped.Status = 'Concluído'
                GROUP BY p.ID_Produto
                ORDER BY total_quantity DESC
                LIMIT 5`,
            
            monthlyRevenueTrend: `SELECT 
                DATE_FORMAT(Data, '%Y-%m') as month,
                SUM(CAST(REPLACE(Valor_Total, ',', '.') AS DECIMAL(10,2))) as total_revenue
                FROM Pedidos
                WHERE Status = 'Concluído'
                AND Data >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
                GROUP BY month
                ORDER BY month`
        };

        const results = {};
        
        // Execute todas as queries em paralelo
        const queryPromises = Object.entries(queries).map(async ([key, query]) => {
            const [rows] = await pool.execute(query);
            results[key] = rows;
        });
        
        await Promise.all(queryPromises);
        return results;
    } catch (error) {
        console.error('Erro detalhado:', {
            message: error.message,
            code: error.code,
            errno: error.errno,
            syscall: error.syscall,
            stack: error.stack // Added stack trace for better debugging
        });
        throw error;
    }
}

// Servidor WebSocket
const wss = new WebSocket.Server({ port: 3000 });

wss.on('connection', (ws) => {
    console.log('Cliente conectado');
    
    const sendFinancialData = async () => {
        try {
            const data = await fetchFinancialData();
            ws.send(JSON.stringify(data));
        } catch (error) {
            console.error('Falha ao enviar dados:', error);
            // Envie uma mensagem de erro para o cliente
            ws.send(JSON.stringify({ error: 'Falha ao buscar dados financeiros' }));
        }
    };

    // Envio inicial e periódico
    sendFinancialData();
    const intervalId = setInterval(sendFinancialData, 5000);

    // Tratamento de erros do WebSocket
    ws.on('error', (error) => {
        console.error('Erro no WebSocket:', error);
        clearInterval(intervalId);
    });

    ws.on('close', () => {
        clearInterval(intervalId);
        console.log('Cliente desconectado');
    });
});

// Tratamento de erros não capturados
process.on('unhandledRejection', (error) => {
    console.error('Erro não tratado:', error);
});

console.log('Servidor WebSocket rodando na porta 3000');