<?php
require 'vendor/autoload.php';

use Luecano\NumeroALetras\NumeroALetras;

$formatter = new NumeroALetras();

// Números de ejemplo para mostrar las mejoras (incluyendo casos complicados)
$ejemplosBasicos = [
    0, 1, 16, 21, 22, 23, 26, 31, 84, 100, 101, 123, 456, 789,
    1000, 1016, 1234, 5678, 9999, 10000, 12345, 50000, 100000,
    250000, 500000, 1000000, 2500000, 10000000,
    // Números más complicados
    999999999, 123456789, 987654321, 111111111, 222222222,
    516726, 821031, 999000999, 100100100, 505050505
];

// Procesar formularios
$testNumber = $_POST['test_number'] ?? '';
$testMoney = $_POST['test_money'] ?? '';
$currency = $_POST['currency'] ?? 'SOLES';
$cents = $_POST['cents'] ?? 'CENTIMOS';
$testInvoice = $_POST['test_invoice'] ?? '';
$invoiceCurrency = $_POST['invoice_currency'] ?? 'SOLES';
$enableApocope = isset($_POST['enable_apocope']);

if ($enableApocope) {
    $formatter->apocope = true;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NumeroALetras - Demo Completo</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
            line-height: 1.6;
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 10px;
            font-size: 2.2em;
        }

        .subtitle {
            text-align: center;
            color: #7f8c8d;
            margin-bottom: 30px;
            font-style: italic;
        }

        .section {
            margin-bottom: 40px;
        }

        .section h2 {
            color: #34495e;
            border-bottom: 2px solid #3498db;
            padding-bottom: 5px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ecf0f1;
        }

        th {
            background-color: #3498db;
            color: white;
            font-weight: 600;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        tr:hover {
            background-color: #e8f4f8;
        }

        .numero {
            font-weight: bold;
            text-align: right;
            font-family: 'Courier New', monospace;
            color: #2c3e50;
        }

        .resultado {
            color: #27ae60;
            font-weight: 500;
        }

        .form-group {
            background-color: #ecf0f1;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .form-group h3 {
            margin-top: 0;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        .form-row {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
            align-items: center;
            flex-wrap: wrap;
        }

        input[type="number"], input[type="text"], select {
            padding: 10px;
            border: 2px solid #bdc3c7;
            border-radius: 5px;
            font-size: 14px;
            min-width: 150px;
        }

        input[type="number"]:focus, input[type="text"]:focus, select:focus {
            border-color: #3498db;
            outline: none;
        }

        button {
            padding: 12px 25px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #2980b9;
        }

        .result-box {
            margin-top: 15px;
            padding: 15px;
            background-color: #d5edda;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
            font-weight: bold;
            color: #155724;
            word-wrap: break-word;
        }

        .highlight {
            background-color: #fff3cd;
            padding: 15px;
            border-left: 4px solid #ffc107;
            margin-bottom: 20px;
        }

        .badge {
            background-color: #e74c3c;
            color: white;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.8em;
            font-weight: bold;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 15px;
        }

        .checkbox-container input[type="checkbox"] {
            min-width: auto;
            width: auto;
        }

        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
                align-items: stretch;
            }

            input[type="number"], input[type="text"], select {
                min-width: 100%;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h1>🔢 NumeroALetras - Demo Completo</h1>
    <p class="subtitle">Conversión exacta de números a letras en español con acentuación RAE</p>

    <div class="highlight">
        <strong>✨ Mejoras implementadas:</strong> Acentuación correcta (dieciséis, veintidós, veintitrés, veintiséis),
        apócope contextual, optimización por rangos (0-999,999,999), y compatibilidad total.
    </div>

    <!-- Conversión Básica -->
    <div class="section">
        <h2>📊 Ejemplos de Conversión Básica</h2>
        <table>
            <thead>
            <tr>
                <th>Número</th>
                <th>En Letras</th>
                <th>Observaciones</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($ejemplosBasicos as $numero): ?>
                <tr>
                    <td class="numero"><?= number_format($numero) ?></td>
                    <td class="resultado"><?= $formatter->toWords($numero) ?></td>
                    <td>
                        <?php if (in_array($numero, [16, 22, 23, 26])): ?>
                            <span class="badge">Con tilde RAE</span>
                        <?php elseif (in_array($numero, [21, 31, 101])): ?>
                            <span class="badge">Caso UNO</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Pruebas Interactivas -->
    <div class="grid">
        <div class="form-group">
            <h3>🧮 Conversión Básica</h3>
            <form method="POST">
                <div class="checkbox-container">
                    <input type="checkbox" id="enable_apocope" name="enable_apocope" <?= $enableApocope ? 'checked' : '' ?>>
                    <label for="enable_apocope">Activar apócope (UNO → UN)</label>
                </div>
                <div class="form-row">
                    <input type="number" name="test_number" placeholder="Ingresa un número"
                           value="<?= htmlspecialchars($testNumber) ?>" min="0" max="999999999">
                    <button type="submit">Convertir</button>
                </div>
            </form>

            <?php if ($testNumber !== ''): ?>
                <?php $testNum = (int)$testNumber; ?>
                <div class="result-box">
                    <strong><?= number_format($testNum) ?></strong><br>
                    → <?= $formatter->toWords($testNum) ?>
                    <?php if ($enableApocope): ?>
                        <br><small>(Con apócope activado)</small>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <h3>💰 Conversión a Moneda</h3>
            <form method="POST">
                <div class="form-row">
                    <input type="number" name="test_money" placeholder="Cantidad" step="0.01"
                           value="<?= htmlspecialchars($testMoney) ?>" min="0">
                    <input type="text" name="currency" placeholder="Moneda"
                           value="<?= htmlspecialchars($currency) ?>">
                    <input type="text" name="cents" placeholder="Céntimos"
                           value="<?= htmlspecialchars($cents) ?>">
                </div>
                <button type="submit">Convertir Moneda</button>
            </form>

            <?php if ($testMoney !== ''): ?>
                <?php $moneyAmount = (float)$testMoney; ?>
                <div class="result-box">
                    <strong><?= number_format($moneyAmount, 2) ?> <?= $currency ?></strong><br>
                    → <?= $formatter->toMoney($moneyAmount, 2, $currency, $cents) ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="form-group">
        <h3>🧾 Conversión para Facturas</h3>
        <form method="POST">
            <div class="form-row">
                <input type="number" name="test_invoice" placeholder="Monto factura" step="0.01"
                       value="<?= htmlspecialchars($testInvoice) ?>" min="0">
                <input type="text" name="invoice_currency" placeholder="Moneda"
                       value="<?= htmlspecialchars($invoiceCurrency) ?>">
                <button type="submit">Formato Factura</button>
            </div>
        </form>

        <?php if ($testInvoice !== ''): ?>
            <?php $invoiceAmount = (float)$testInvoice; ?>
            <div class="result-box">
                <strong>Factura: <?= number_format($invoiceAmount, 2) ?> <?= $invoiceCurrency ?></strong><br>
                → <?= $formatter->toInvoice($invoiceAmount, 2, $invoiceCurrency) ?>
                <br><small>* Formato estándar para facturas (sin apócope automático)</small>
            </div>
        <?php endif; ?>
    </div>

    <!-- Casos Especiales -->
    <div class="section">
        <h2>🎯 Casos Especiales Destacados</h2>
        <table>
            <thead>
            <tr>
                <th>Número</th>
                <th>Conversión Normal</th>
                <th>Con Apócope</th>
                <th>Formato Factura</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $casosEspeciales = [1, 21, 31, 101, 121, 1001];
            $formatterSinApocope = new NumeroALetras(); // Sin apócope
            $formatterConApocope = new NumeroALetras();
            $formatterConApocope->apocope = true; // Con apócope

            foreach ($casosEspeciales as $numero):
                ?>
                <tr>
                    <td class="numero"><?= $numero ?></td>
                    <td class="resultado"><?= $formatterSinApocope->toWords($numero) ?></td>
                    <td class="resultado"><?= $formatterConApocope->toWords($numero) ?></td>
                    <td class="resultado"><?= $formatterSinApocope->toInvoice($numero, 2, 'SOLES') ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Ejemplos de Monedas -->
    <div class="section">
        <h2>💵 Ejemplos de Conversión de Monedas</h2>
        <table>
            <thead>
            <tr>
                <th>Cantidad</th>
                <th>Resultado</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $ejemplosMoneda = [
                [10.50, 'SOLES', 'CÉNTIMOS'],
                [123.45, 'DÓLARES', 'CENTAVOS'],
                [1000.00, 'EUROS', 'CÉNTIMOS'],
                [2500.75, 'PESOS', 'CENTAVOS'],
                [10000.99, 'LEMPIRAS', 'CENTAVOS']
            ];

            foreach ($ejemplosMoneda as [$cantidad, $moneda, $centimos]):
                ?>
                <tr>
                    <td class="numero"><?= number_format($cantidad, 2) ?> <?= $moneda ?></td>
                    <td class="resultado"><?= $formatter->toMoney($cantidad, 2, $moneda, $centimos) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Performance Info -->
    <div class="section">
        <h2>⚡ Información de Rendimiento</h2>
        <div style="background: #e8f5e8; padding: 20px; border-radius: 8px;">
            <p><strong>Cache optimizado:</strong> Números 0-999 pre-calculados para máximo rendimiento</p>
            <p><strong>Algoritmos específicos:</strong> Miles (1K-999K) y millones (1M-999M) con rutas optimizadas</p>
            <p><strong>Rango soportado:</strong> 0 a 999,999,999 con precisión RAE completa</p>
            <p><strong>Compatible:</strong> PHP 8.3+ y Laravel 12</p>
        </div>
    </div>

    <div style="text-align: center; margin-top: 30px; color: #7f8c8d;">
        <p><strong>NumeroALetras</strong> - Conversión exacta según reglas RAE 2023</p>
    </div>
</div>
</body>
</html>