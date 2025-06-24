<?php

declare(strict_types=1);

namespace Luecano\NumeroALetras;

final class NumeroALetras
{
    /** @var int Número máximo soportado */
    public const MAX_NUMBER = 999999999;

    /** @var int Número mínimo soportado */
    public const MIN_NUMBER = 0;

    /** @var int Máximo de decimales permitidos */
    public const MAX_DECIMALS = 10;
    /**
     * Cache for pre-computed numbers 0-999
     */
    private static array $cache = [];
    private static bool $cacheInitialized = false;

    /**
     * @var array Unidades básicas (0-20)
     */
    private array $unidades = [
        '', 'UNO', 'DOS', 'TRES', 'CUATRO', 'CINCO', 'SEIS', 'SIETE', 'OCHO', 'NUEVE',
        'DIEZ', 'ONCE', 'DOCE', 'TRECE', 'CATORCE', 'QUINCE', 'DIECISÉIS', 'DIECISIETE',
        'DIECIOCHO', 'DIECINUEVE', 'VEINTE'
    ];

    /**
     * @var array Veintenas (21-29) con acentuación correcta RAE
     */
    private array $veintenas = [
        21 => 'VEINTIUNO',
        22 => 'VEINTIDÓS',
        23 => 'VEINTITRÉS',
        24 => 'VEINTICUATRO',
        25 => 'VEINTICINCO',
        26 => 'VEINTISÉIS',
        27 => 'VEINTISIETE',
        28 => 'VEINTIOCHO',
        29 => 'VEINTINUEVE'
    ];

    /**
     * @var array Decenas (30-90)
     */
    private array $decenas = [
        30 => 'TREINTA', 40 => 'CUARENTA', 50 => 'CINCUENTA',
        60 => 'SESENTA', 70 => 'SETENTA', 80 => 'OCHENTA', 90 => 'NOVENTA'
    ];

    /**
     * @var array Centenas (200-900)
     */
    private array $centenas = [
        200 => 'DOSCIENTOS', 300 => 'TRESCIENTOS', 400 => 'CUATROCIENTOS',
        500 => 'QUINIENTOS', 600 => 'SEISCIENTOS', 700 => 'SETECIENTOS',
        800 => 'OCHOCIENTOS', 900 => 'NOVECIENTOS'
    ];

    /**
     * @var string
     */
    public string $conector = 'CON';

    /**
     * @var bool Activar apócope para compatibilidad
     */
    public bool $apocope = false;

    public function __construct()
    {
        $this->initializeCache();
    }

    /**
     * Initialize cache for numbers 0-999 (sin apócope, aplicado dinámicamente)
     */
    private function initializeCache(): void
    {
        if (self::$cacheInitialized) {
            return;
        }

        for ($i = 0; $i <= 999; $i++) {
            self::$cache[$i] = $this->computeBaseNumberWithoutApocope($i);
        }

        self::$cacheInitialized = true;
    }

    /**
     * Convierte número a palabras
     *
     * @param float|int $number Número a convertir (0-999,999,999)
     * @param int $decimals Decimales a procesar (0-10)
     * @return string Número en letras
     * @throws \InvalidArgumentException Si el número está fuera del rango válido
     */
    public function toWords(float|int $number, int $decimals = 2): string
    {
        $this->validateDecimals($decimals);

        $number = number_format($number, $decimals, '.', '');
        $splitNumber = explode('.', $number);

        $splitNumber[0] = $this->wholeNumber((int)$splitNumber[0]);

        if (!empty($splitNumber[1]) && (int)$splitNumber[1] > 0) {
            $splitNumber[1] = $this->convertNumber((int)$splitNumber[1]);
        } else {
            $splitNumber[1] = '';
        }

        return $this->concat($splitNumber);
    }

    /**
     * Convierte a moneda
     *
     * @param float $number Cantidad a convertir
     * @param int $decimals Decimales (0-10)
     * @param string $currency Nombre de la moneda
     * @param string $cents Nombre de los centavos
     * @return string Cantidad en letras con moneda
     * @throws \InvalidArgumentException Si los parámetros son inválidos
     */
    public function toMoney(float $number, int $decimals = 2, string $currency = '', string $cents = ''): string
    {
        $this->validateDecimals($decimals);

        $number = number_format($number, $decimals, '.', '');
        $splitNumber = explode('.', $number);

        $splitNumber[0] = $this->wholeNumber((int)$splitNumber[0]) . ' ' . mb_strtoupper($currency, 'UTF-8');

        if (!empty($splitNumber[1]) && (int)$splitNumber[1] > 0) {
            $centValue = (int)$splitNumber[1];
            $splitNumber[1] = $this->convertNumber($centValue) . ' ' . mb_strtoupper($cents, 'UTF-8');
        } else {
            $splitNumber[1] = '';
        }

        return $this->concat($splitNumber);
    }

    /**
     * Formato de factura estándar
     *
     * @param float $number Monto de la factura
     * @param int $decimals Decimales (0-10)
     * @param string $currency Moneda
     * @return string Monto en formato factura (ej: "CIEN Y 50/100 SOLES")
     * @throws \InvalidArgumentException Si los parámetros son inválidos
     */
    public function toInvoice(float $number, int $decimals = 2, string $currency = ''): string
    {
        $this->validateDecimals($decimals);

        $number = number_format($number, $decimals, '.', '');
        $splitNumber = explode('.', $number);

        $splitNumber[0] = $this->wholeNumber((int)$splitNumber[0]);

        if (!empty($splitNumber[1])) {
            $splitNumber[1] = str_pad($splitNumber[1], 2, '0', STR_PAD_RIGHT) . '/100';
        } else {
            $splitNumber[1] = '00/100';
        }

        return implode(' Y ', array_filter($splitNumber)) . ' ' . mb_strtoupper($currency, 'UTF-8');
    }

    /**
     * Compatibilidad con versión anterior
     *
     * @param float|int $number Número a convertir
     * @param int $decimals Decimales
     * @param string $whole_str Texto para parte entera
     * @param string $decimal_str Texto para decimales
     * @return string Resultado en letras
     */
    public function toString(float|int $number, int $decimals = 2, string $whole_str = '', string $decimal_str = ''): string
    {
        return $this->toMoney($number, $decimals, $whole_str, $decimal_str);
    }

    /**
     * Convierte número entero
     */
    private function wholeNumber(int $number): string
    {
        if ($number === 0) {
            return 'CERO';
        }
        return $this->convertNumber($number);
    }

    /**
     * Concatena partes con conector
     */
    private function concat(array $splitNumber): string
    {
        $filteredParts = array_filter($splitNumber, function ($part) {
            return !empty(trim($part));
        });

        if (count($filteredParts) <= 1) {
            return implode('', $filteredParts);
        }

        return implode(' ' . mb_strtoupper($this->conector, 'UTF-8') . ' ', $filteredParts);
    }

    /**
     * Conversión principal optimizada por rangos
     */
    private function convertNumber(int $number): string
    {
        if ($number < self::MIN_NUMBER || $number > self::MAX_NUMBER) {
            throw new \InvalidArgumentException(
                sprintf('Number must be between %d and %s', self::MIN_NUMBER, number_format(self::MAX_NUMBER))
            );
        }

        if ($number === 0) {
            return '';
        }

        // Rango 1-999: usar cache y aplicar apócope si está activado
        if ($number <= 999) {
            $result = self::$cache[$number] ?? '';
            if ($this->apocope) {
                $result = $this->applyApocopeToResult($result);
            }
            return $result;
        }

        // Rango 1000-999999: optimización para miles
        if ($number < 1000000) {
            return $this->convertThousands($number);
        }

        // Rango 1000000-999999999: millones
        return $this->convertMillions($number);
    }

    /**
     * Convierte números 1-999 sin apócope (para cache)
     */
    private function computeBaseNumberWithoutApocope(int $number): string
    {
        if ($number === 0) {
            return '';
        }

        $result = '';

        // Centenas
        if ($number >= 100) {
            if ($number === 100) {
                return 'CIEN';
            }

            $hundreds = intval($number / 100);
            if ($hundreds === 1) {
                $result .= 'CIENTO ';
            } else {
                $result .= $this->centenas[$hundreds * 100] . ' ';
            }
            $number %= 100;
        }

        if ($number === 0) {
            return trim($result);
        }

        // Números 1-20
        if ($number <= 20) {
            $result .= $this->unidades[$number];
            return trim($result);
        }

        // Veintenas 21-29 con acentuación
        if ($number <= 29) {
            $result .= $this->veintenas[$number];
            return trim($result);
        }

        // Decenas 30-99
        $tens = intval($number / 10) * 10;
        $units = $number % 10;

        $result .= $this->decenas[$tens];

        if ($units > 0) {
            $result .= ' Y ' . $this->unidades[$units];
        }

        return trim($result);
    }

    /**
     * Aplica apócope a un resultado ya generado
     */
    private function applyApocopeToResult(string $text): string
    {
        // UNO al final -> UN
        if ($text === 'UNO') {
            return 'UN';
        }

        // VEINTIUNO -> VEINTIÚN
        $text = str_replace('VEINTIUNO', 'VEINTIÚN', $text);

        // Para casos como "TREINTA Y UNO" -> "TREINTA Y UN"
        $text = str_replace(' Y UNO', ' Y UN', $text);

        // Para casos que terminan en UNO
        if (str_ends_with($text, ' UNO')) {
            $text = substr($text, 0, -4) . ' UN';
        }

        return $text;
    }

    /**
     * Convierte miles (1000-999999)
     */
    private function convertThousands(int $number): string
    {
        $thousands = intval($number / 1000);
        $remainder = $number % 1000;

        $result = '';

        if ($thousands === 1) {
            $result = 'MIL';
        } else {
            $result = self::$cache[$thousands] . ' MIL';
        }

        if ($remainder > 0) {
            $result .= ' ' . self::$cache[$remainder];
        }

        return trim($result);
    }

    /**
     * Convierte millones (1000000-999999999)
     */
    private function convertMillions(int $number): string
    {
        $millions = intval($number / 1000000);
        $remainder = $number % 1000000;

        $result = '';

        if ($millions === 1) {
            $result = 'UN MILLÓN';
        } else {
            $cached = self::$cache[$millions] ?? $this->computeBaseNumberWithoutApocope($millions);
            if ($this->apocope) {
                $cached = $this->applyApocopeToResult($cached);
            }
            $result = $cached . ' MILLONES';
        }

        if ($remainder > 0) {
            if ($remainder >= 1000) {
                $result .= ' ' . $this->convertThousands($remainder);
            } else {
                $remainderText = self::$cache[$remainder] ?? $this->computeBaseNumberWithoutApocope($remainder);
                if ($this->apocope) {
                    $remainderText = $this->applyApocopeToResult($remainderText);
                }
                $result .= ' ' . $remainderText;
            }
        }

        return trim($result);
    }

    /**
     * Valida el parámetro de decimales
     */
    private function validateDecimals(int $decimals): void
    {
        if ($decimals < 0 || $decimals > self::MAX_DECIMALS) {
            throw new \InvalidArgumentException(
                sprintf('Decimals must be between 0 and %d', self::MAX_DECIMALS)
            );
        }
    }
}
