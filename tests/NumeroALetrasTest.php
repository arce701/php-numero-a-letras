<?php

declare(strict_types=1);

namespace Luecano\NumeroALetras\Tests;

use Luecano\NumeroALetras\NumeroALetras;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

final class NumeroALetrasTest extends TestCase
{
    /**
     * @return array<int, array{int, string}>
     */
    public static function basicNumbersProvider(): array
    {
        return [
            [0, 'CERO'],
            [1, 'UNO'], [2, 'DOS'], [3, 'TRES'], [4, 'CUATRO'], [5, 'CINCO'],
            [6, 'SEIS'], [7, 'SIETE'], [8, 'OCHO'], [9, 'NUEVE'], [10, 'DIEZ'],
            [11, 'ONCE'], [12, 'DOCE'], [13, 'TRECE'], [14, 'CATORCE'], [15, 'QUINCE'],
            [16, 'DIECISÉIS'], [17, 'DIECISIETE'], [18, 'DIECIOCHO'], [19, 'DIECINUEVE'], [20, 'VEINTE']
        ];
    }

    /**
     * @return array<int, array{int, string}>
     */
    public static function twentiesProvider(): array
    {
        return [
            [21, 'VEINTIUNO'], [22, 'VEINTIDÓS'], [23, 'VEINTITRÉS'], [24, 'VEINTICUATRO'], [25, 'VEINTICINCO'],
            [26, 'VEINTISÉIS'], [27, 'VEINTISIETE'], [28, 'VEINTIOCHO'], [29, 'VEINTINUEVE']
        ];
    }

    /**
     * @return array<int, array{int, string}>
     */
    public static function tensProvider(): array
    {
        return [
            [30, 'TREINTA'], [31, 'TREINTA Y UNO'], [35, 'TREINTA Y CINCO'], [39, 'TREINTA Y NUEVE'],
            [40, 'CUARENTA'], [41, 'CUARENTA Y UNO'], [45, 'CUARENTA Y CINCO'], [49, 'CUARENTA Y NUEVE'],
            [50, 'CINCUENTA'], [51, 'CINCUENTA Y UNO'], [55, 'CINCUENTA Y CINCO'], [59, 'CINCUENTA Y NUEVE'],
            [60, 'SESENTA'], [61, 'SESENTA Y UNO'], [65, 'SESENTA Y CINCO'], [69, 'SESENTA Y NUEVE'],
            [70, 'SETENTA'], [71, 'SETENTA Y UNO'], [75, 'SETENTA Y CINCO'], [79, 'SETENTA Y NUEVE'],
            [80, 'OCHENTA'], [81, 'OCHENTA Y UNO'], [85, 'OCHENTA Y CINCO'], [89, 'OCHENTA Y NUEVE'],
            [90, 'NOVENTA'], [91, 'NOVENTA Y UNO'], [95, 'NOVENTA Y CINCO'], [99, 'NOVENTA Y NUEVE']
        ];
    }

    /**
     * @return array<int, array{int, string}>
     */
    public static function hundredsProvider(): array
    {
        return [
            [100, 'CIEN'], [101, 'CIENTO UNO'], [110, 'CIENTO DIEZ'], [121, 'CIENTO VEINTIUNO'], [150, 'CIENTO CINCUENTA'],
            [200, 'DOSCIENTOS'], [201, 'DOSCIENTOS UNO'], [222, 'DOSCIENTOS VEINTIDÓS'], [250, 'DOSCIENTOS CINCUENTA'],
            [300, 'TRESCIENTOS'], [301, 'TRESCIENTOS UNO'], [333, 'TRESCIENTOS TREINTA Y TRES'], [350, 'TRESCIENTOS CINCUENTA'],
            [400, 'CUATROCIENTOS'], [401, 'CUATROCIENTOS UNO'], [444, 'CUATROCIENTOS CUARENTA Y CUATRO'],
            [500, 'QUINIENTOS'], [501, 'QUINIENTOS UNO'], [555, 'QUINIENTOS CINCUENTA Y CINCO'],
            [600, 'SEISCIENTOS'], [601, 'SEISCIENTOS UNO'], [666, 'SEISCIENTOS SESENTA Y SEIS'],
            [700, 'SETECIENTOS'], [701, 'SETECIENTOS UNO'], [777, 'SETECIENTOS SETENTA Y SIETE'],
            [800, 'OCHOCIENTOS'], [801, 'OCHOCIENTOS UNO'], [888, 'OCHOCIENTOS OCHENTA Y OCHO'],
            [900, 'NOVECIENTOS'], [901, 'NOVECIENTOS UNO'], [999, 'NOVECIENTOS NOVENTA Y NUEVE']
        ];
    }

    /**
     * @return array<int, array{int, string}>
     */
    public static function thousandsProvider(): array
    {
        return [
            [1000, 'MIL'], [1001, 'MIL UNO'], [1010, 'MIL DIEZ'], [1100, 'MIL CIEN'], [1101, 'MIL CIENTO UNO'],
            [1234, 'MIL DOSCIENTOS TREINTA Y CUATRO'], [1500, 'MIL QUINIENTOS'], [1999, 'MIL NOVECIENTOS NOVENTA Y NUEVE'],
            [2000, 'DOS MIL'], [2001, 'DOS MIL UNO'], [2222, 'DOS MIL DOSCIENTOS VEINTIDÓS'],
            [5000, 'CINCO MIL'], [5678, 'CINCO MIL SEISCIENTOS SETENTA Y OCHO'],
            [10000, 'DIEZ MIL'], [10001, 'DIEZ MIL UNO'], [12345, 'DOCE MIL TRESCIENTOS CUARENTA Y CINCO'],
            [50000, 'CINCUENTA MIL'], [100000, 'CIEN MIL'], [100001, 'CIEN MIL UNO'],
            [123456, 'CIENTO VEINTITRÉS MIL CUATROCIENTOS CINCUENTA Y SEIS'],
            [500000, 'QUINIENTOS MIL'], [999999, 'NOVECIENTOS NOVENTA Y NUEVE MIL NOVECIENTOS NOVENTA Y NUEVE']
        ];
    }

    /**
     * @return array<int, array{int, string}>
     */
    public static function millionsProvider(): array
    {
        return [
            [1000000, 'UN MILLÓN'], [1000001, 'UN MILLÓN UNO'], [1000010, 'UN MILLÓN DIEZ'],
            [1001000, 'UN MILLÓN MIL'], [1234567, 'UN MILLÓN DOSCIENTOS TREINTA Y CUATRO MIL QUINIENTOS SESENTA Y SIETE'],
            [2000000, 'DOS MILLONES'], [2000001, 'DOS MILLONES UNO'], [2500000, 'DOS MILLONES QUINIENTOS MIL'],
            [10000000, 'DIEZ MILLONES'], [100000000, 'CIEN MILLONES'],
            [999999999, 'NOVECIENTOS NOVENTA Y NUEVE MILLONES NOVECIENTOS NOVENTA Y NUEVE MIL NOVECIENTOS NOVENTA Y NUEVE']
        ];
    }

    /**
     * @return array<int, array{int, string}>
     */
    public static function accentCasesProvider(): array
    {
        return [
            // Casos con acentos obligatorios según RAE
            [16, 'DIECISÉIS'], [116, 'CIENTO DIECISÉIS'], [216, 'DOSCIENTOS DIECISÉIS'], [1016, 'MIL DIECISÉIS'],
            [22, 'VEINTIDÓS'], [122, 'CIENTO VEINTIDÓS'], [322, 'TRESCIENTOS VEINTIDÓS'], [1022, 'MIL VEINTIDÓS'],
            [23, 'VEINTITRÉS'], [123, 'CIENTO VEINTITRÉS'], [423, 'CUATROCIENTOS VEINTITRÉS'], [1023, 'MIL VEINTITRÉS'],
            [26, 'VEINTISÉIS'], [126, 'CIENTO VEINTISÉIS'], [526, 'QUINIENTOS VEINTISÉIS'], [1026, 'MIL VEINTISÉIS'],
            [10016, 'DIEZ MIL DIECISÉIS'], [100016, 'CIEN MIL DIECISÉIS'], [1000016, 'UN MILLÓN DIECISÉIS']
        ];
    }

    /**
     * @return array<int, array{int, string}>
     */
    public static function boundaryProvider(): array
    {
        return [
            [99, 'NOVENTA Y NUEVE'], [100, 'CIEN'], [101, 'CIENTO UNO'],
            [999, 'NOVECIENTOS NOVENTA Y NUEVE'], [1000, 'MIL'], [1001, 'MIL UNO'],
            [9999, 'NUEVE MIL NOVECIENTOS NOVENTA Y NUEVE'], [10000, 'DIEZ MIL'], [10001, 'DIEZ MIL UNO'],
            [99999, 'NOVENTA Y NUEVE MIL NOVECIENTOS NOVENTA Y NUEVE'], [100000, 'CIEN MIL'], [100001, 'CIEN MIL UNO'],
            [999999, 'NOVECIENTOS NOVENTA Y NUEVE MIL NOVECIENTOS NOVENTA Y NUEVE'], [1000000, 'UN MILLÓN'], [1000001, 'UN MILLÓN UNO']
        ];
    }

    /**
     * @return array<int, array{int, string}>
     */
    public static function specialCasesProvider(): array
    {
        return [
            // Casos especiales de UNO
            [1, 'UNO'], [21, 'VEINTIUNO'], [31, 'TREINTA Y UNO'], [41, 'CUARENTA Y UNO'],
            [51, 'CINCUENTA Y UNO'], [61, 'SESENTA Y UNO'], [71, 'SETENTA Y UNO'], [81, 'OCHENTA Y UNO'], [91, 'NOVENTA Y UNO'],
            [101, 'CIENTO UNO'], [121, 'CIENTO VEINTIUNO'], [201, 'DOSCIENTOS UNO'], [301, 'TRESCIENTOS UNO'],
            [1001, 'MIL UNO'], [2001, 'DOS MIL UNO'], [10001, 'DIEZ MIL UNO'], [100001, 'CIEN MIL UNO'], [1000001, 'UN MILLÓN UNO']
        ];
    }

    /**
     * @return array<int, array{float, string}>
     */
    public static function decimalProvider(): array
    {
        return [
            [10.25, 'DIEZ CON VEINTICINCO'], [16.22, 'DIECISÉIS CON VEINTIDÓS'], [23.26, 'VEINTITRÉS CON VEINTISÉIS'],
            [100.50, 'CIEN CON CINCUENTA'], [1000.01, 'MIL CON UNO'], [1234.56, 'MIL DOSCIENTOS TREINTA Y CUATRO CON CINCUENTA Y SEIS']
        ];
    }

    /**
     * @return array<int, array{float, string}>
     */
    public static function moneyProvider(): array
    {
        return [
            [10.50, 'DIEZ SOLES CON CINCUENTA CENTIMOS'],
            [123.45, 'CIENTO VEINTITRÉS SOLES CON CUARENTA Y CINCO CENTIMOS'],
            [1000.00, 'MIL SOLES'],
            [2500.75, 'DOS MIL QUINIENTOS SOLES CON SETENTA Y CINCO CENTIMOS'],
            [10000.99, 'DIEZ MIL SOLES CON NOVENTA Y NUEVE CENTIMOS']
        ];
    }

    /**
     * @return array<int, array{float, string}>
     */
    public static function invoiceProvider(): array
    {
        return [
            [100, 'CIEN Y 00/100 SOLES'],
            [121.34, 'CIENTO VEINTIUNO Y 34/100 SOLES'], // Sin apócope
            [1700.50, 'MIL SETECIENTOS Y 50/100 SOLES'],
            [31.75, 'TREINTA Y UNO Y 75/100 SOLES'], // Sin apócope
            [501.00, 'QUINIENTOS UNO Y 00/100 SOLES'] // Sin apócope
        ];
    }

    /**
     * Tests basic number conversion (0-20)
     */
    #[DataProvider('basicNumbersProvider')]
    public function testBasicNumbers(int $number, string $expected): void
    {
        $formatter = new NumeroALetras();
        $this->assertSame($expected, $formatter->toWords($number));
    }

    /**
     * Tests twenties with proper RAE accentuation (21-29)
     */
    #[DataProvider('twentiesProvider')]
    public function testTwenties(int $number, string $expected): void
    {
        $formatter = new NumeroALetras();
        $this->assertSame($expected, $formatter->toWords($number));
    }

    /**
     * Tests tens with Y connector (30-99)
     */
    #[DataProvider('tensProvider')]
    public function testTens(int $number, string $expected): void
    {
        $formatter = new NumeroALetras();
        $this->assertSame($expected, $formatter->toWords($number));
    }

    /**
     * Tests hundreds including CIEN vs CIENTO (100-999)
     */
    #[DataProvider('hundredsProvider')]
    public function testHundreds(int $number, string $expected): void
    {
        $formatter = new NumeroALetras();
        $this->assertSame($expected, $formatter->toWords($number));
    }

    /**
     * Tests thousands range optimization (1000-999999)
     */
    #[DataProvider('thousandsProvider')]
    public function testThousands(int $number, string $expected): void
    {
        $formatter = new NumeroALetras();
        $this->assertSame($expected, $formatter->toWords($number));
    }

    /**
     * Tests millions range (1000000-999999999)
     */
    #[DataProvider('millionsProvider')]
    public function testMillions(int $number, string $expected): void
    {
        $formatter = new NumeroALetras();
        $this->assertSame($expected, $formatter->toWords($number));
    }

    /**
     * Tests mandatory RAE accents
     */
    #[DataProvider('accentCasesProvider')]
    public function testAccentCases(int $number, string $expected): void
    {
        $formatter = new NumeroALetras();
        $this->assertSame($expected, $formatter->toWords($number));
    }

    /**
     * Tests critical boundary numbers
     */
    #[DataProvider('boundaryProvider')]
    public function testBoundaryNumbers(int $number, string $expected): void
    {
        $formatter = new NumeroALetras();
        $this->assertSame($expected, $formatter->toWords($number));
    }

    /**
     * Tests UNO special cases without apocope
     */
    #[DataProvider('specialCasesProvider')]
    public function testSpecialCases(int $number, string $expected): void
    {
        $formatter = new NumeroALetras();
        $this->assertSame($expected, $formatter->toWords($number));
    }

    /**
     * Tests decimal number conversion
     */
    #[DataProvider('decimalProvider')]
    public function testDecimalNumbers(float $number, string $expected): void
    {
        $formatter = new NumeroALetras();
        $this->assertSame($expected, $formatter->toWords($number));
    }

    /**
     * Tests currency conversion
     */
    #[DataProvider('moneyProvider')]
    public function testMoneyConversions(float $amount, string $expected): void
    {
        $formatter = new NumeroALetras();
        $result = $formatter->toMoney($amount, 2, 'SOLES', 'CENTIMOS');
        $this->assertSame($expected, $result);
    }

    /**
     * Tests invoice format (no automatic apocope)
     */
    #[DataProvider('invoiceProvider')]
    public function testInvoiceFormat(float $amount, string $expected): void
    {
        $formatter = new NumeroALetras();
        $result = $formatter->toInvoice($amount, 2, 'SOLES');
        $this->assertSame($expected, $result);
    }

    public function testCachePerformance(): void
    {
        $formatter = new NumeroALetras();

        // Test small numbers (should use cache)
        $start = microtime(true);
        for ($i = 0; $i < 10000; $i++) {
            $formatter->toWords(rand(0, 999));
        }
        $cacheTime = microtime(true) - $start;

        // Test larger numbers
        $start = microtime(true);
        for ($i = 0; $i < 1000; $i++) {
            $formatter->toWords(rand(1000000, 999999999));
        }
        $largeTime = microtime(true) - $start;

        // Cache should be significantly faster per operation
        $cachePerOp = $cacheTime / 10000;
        $largePerOp = $largeTime / 1000;

        $this->assertLessThan(0.001, $cachePerOp, 'Cached operations should be very fast');
        $this->assertLessThan($largePerOp * 2, $cachePerOp, 'Cache should be faster than complex calculations');
    }

    public function testMemoryUsage(): void
    {
        $startMemory = memory_get_usage();

        $formatter = new NumeroALetras();

        // Process many numbers
        for ($i = 0; $i < 1000; $i++) {
            $formatter->toWords(rand(0, 999999));
        }

        $endMemory = memory_get_usage();
        $memoryIncrease = $endMemory - $startMemory;

        // Should not increase memory significantly (cache should be static)
        $this->assertLessThan(5 * 1024 * 1024, $memoryIncrease, 'Memory usage should be reasonable');
    }

    public function testRandomSmallNumbers(): void
    {
        $formatter = new NumeroALetras();

        // Test random numbers 0-99
        for ($i = 0; $i < 50; $i++) {
            $number = rand(0, 99);
            $result = $formatter->toWords($number);
            $this->assertIsString($result);
            $this->assertNotEmpty($result);
        }
    }

    public function testRandomMediumNumbers(): void
    {
        $formatter = new NumeroALetras();

        // Test random numbers 100-9999
        for ($i = 0; $i < 50; $i++) {
            $number = rand(100, 9999);
            $result = $formatter->toWords($number);
            $this->assertIsString($result);
            $this->assertNotEmpty($result);

            // Should contain proper separators
            if ($number >= 1000) {
                $this->assertStringContainsString('MIL', $result);
            }
        }
    }

    public function testRandomLargeNumbers(): void
    {
        $formatter = new NumeroALetras();

        // Test random numbers 10000-999999999
        for ($i = 0; $i < 50; $i++) {
            $number = rand(10000, 999999999);
            $result = $formatter->toWords($number);
            $this->assertIsString($result);
            $this->assertNotEmpty($result);

            // Should contain proper separators for large numbers
            if ($number >= 1000000) {
                $this->assertStringContainsString('MILL', $result);
            }
            if ($number >= 1000) {
                $this->assertStringContainsString('MIL', $result);
            }
        }
    }

    public function testAccentConsistency(): void
    {
        $formatter = new NumeroALetras();

        // Focus on numbers with accents
        $accentNumbers = [16, 22, 23, 26, 116, 122, 123, 126, 216, 222, 223, 226,
            316, 322, 323, 326, 1016, 1022, 1023, 1026, 10016, 100016];

        foreach ($accentNumbers as $number) {
            $result = $formatter->toWords($number);
            $this->assertIsString($result);
            $this->assertNotEmpty($result);

            // Verify accents are present based on last two digits
            $lastTwoDigits = $number % 100;
            if ($lastTwoDigits === 16) {
                $this->assertStringContainsString('DIECISÉIS', $result);
            }
            if ($lastTwoDigits === 22) {
                $this->assertStringContainsString('VEINTIDÓS', $result);
            }
            if ($lastTwoDigits === 23) {
                $this->assertStringContainsString('VEINTITRÉS', $result);
            }
            if ($lastTwoDigits === 26) {
                $this->assertStringContainsString('VEINTISÉIS', $result);
            }
        }
    }

    public function testErrorHandling(): void
    {
        $formatter = new NumeroALetras();

        $this->expectException(\InvalidArgumentException::class);
        $formatter->toWords(-1);
    }

    public function testErrorHandlingLarge(): void
    {
        $formatter = new NumeroALetras();

        $this->expectException(\InvalidArgumentException::class);
        $formatter->toWords(1000000000);
    }

    public function testConnectorChange(): void
    {
        $formatter = new NumeroALetras();
        $formatter->conector = 'Y';

        $result = $formatter->toMoney(10.10, 2, 'PESOS', 'CENTAVOS');
        $this->assertStringContainsString(' Y ', $result);
    }

    public function testToString(): void
    {
        $formatter = new NumeroALetras();
        $result = $formatter->toString(5.2, 1, 'AÑOS', 'MESES');
        $this->assertEquals('CINCO AÑOS CON DOS MESES', $result);
    }

    public function testStressTest(): void
    {
        $formatter = new NumeroALetras();

        // Stress test with many random numbers
        $start = microtime(true);

        for ($i = 0; $i < 1000; $i++) {
            $number = rand(0, 999999999);
            $result = $formatter->toWords($number);
            $this->assertIsString($result);
            $this->assertNotEmpty($result);
        }

        $elapsed = microtime(true) - $start;
        $this->assertLessThan(2.0, $elapsed, 'Should process 1000 random numbers in under 2 seconds');
    }

    public function testRAECompliance(): void
    {
        $formatter = new NumeroALetras();

        // Test all required accents according to RAE
        $raeTests = [
            [16, 'DIECISÉIS'], [22, 'VEINTIDÓS'], [23, 'VEINTITRÉS'], [26, 'VEINTISÉIS'],
            [116, 'CIENTO DIECISÉIS'], [122, 'CIENTO VEINTIDÓS'], [123, 'CIENTO VEINTITRÉS'], [126, 'CIENTO VEINTISÉIS'],
            [1016, 'MIL DIECISÉIS'], [1022, 'MIL VEINTIDÓS'], [1023, 'MIL VEINTITRÉS'], [1026, 'MIL VEINTISÉIS']
        ];

        foreach ($raeTests as [$number, $expected]) {
            $this->assertEquals(
                $expected,
                $formatter->toWords($number),
                "RAE compliance failed for number {$number}"
            );
        }
    }

    public function testAllHundredsVariations(): void
    {
        $formatter = new NumeroALetras();

        // Test all hundreds
        for ($h = 1; $h <= 9; $h++) {
            $hundreds = $h * 100;
            $result = $formatter->toWords($hundreds);
            $this->assertIsString($result);
            $this->assertNotEmpty($result);

            // Test hundreds + 1
            $result = $formatter->toWords($hundreds + 1);
            $this->assertIsString($result);
            $this->assertNotEmpty($result);

            // Test hundreds + random number
            $random = rand(1, 99);
            $result = $formatter->toWords($hundreds + $random);
            $this->assertIsString($result);
            $this->assertNotEmpty($result);
        }
    }

    public function testAllThousandsVariations(): void
    {
        $formatter = new NumeroALetras();

        // Test key thousands
        $thousands = [1000, 2000, 5000, 10000, 50000, 100000, 500000, 999000];

        foreach ($thousands as $thousand) {
            $result = $formatter->toWords($thousand);
            $this->assertIsString($result);
            $this->assertNotEmpty($result);
            $this->assertStringContainsString('MIL', $result);
        }
    }

    public function testAllMillionsVariations(): void
    {
        $formatter = new NumeroALetras();

        // Test key millions
        $millions = [1000000, 2000000, 5000000, 10000000, 100000000, 500000000];

        foreach ($millions as $million) {
            $result = $formatter->toWords($million);
            $this->assertIsString($result);
            $this->assertNotEmpty($result);
            $this->assertStringContainsString('MILL', $result);
        }
    }

    public function testInvoiceApocope(): void
    {
        $formatter = new NumeroALetras();

        // Test que las facturas NO aplican apócope (comportamiento correcto)
        $noApocopeNumbers = [1, 21, 31, 41, 51, 61, 71, 81, 91, 101, 121, 131, 1001, 2001];

        foreach ($noApocopeNumbers as $number) {
            $result = $formatter->toInvoice($number, 2, 'SOLES');
            $this->assertIsString($result);
            $this->assertNotEmpty($result);

            // Las facturas deben mantener UNO (sin apócope)
            if ($number % 100 === 1 || $number % 100 === 21 || $number % 100 === 31 ||
                $number % 100 === 41 || $number % 100 === 51 || $number % 100 === 61 ||
                $number % 100 === 71 || $number % 100 === 81 || $number % 100 === 91) {
                // Debe contener UNO, no UN
                $this->assertStringContainsString('UNO Y', $result);
            }
        }
    }
}
