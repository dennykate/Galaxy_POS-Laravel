<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VoucherSeeder extends Seeder
{
    public function run(): void
    {
        try {
            // Read SQL file
            $sqlPath = base_path('database/sql/database_backup.sql');
            if (!file_exists($sqlPath)) {
                throw new \Exception("SQL file not found at: {$sqlPath}");
            }

            $sql = file_get_contents($sqlPath);
            Log::info("SQL file loaded, length: " . strlen($sql));

            // Extract vouchers data with more specific pattern
            preg_match("/INSERT INTO `vouchers`\s+VALUES\s*\((.*?)\);/s", $sql, $voucherMatches);
            if (!empty($voucherMatches[1])) {
                Log::info("Found vouchers data");
                $voucherValues = $this->parseValues($voucherMatches[1]);
                Log::info("Parsed voucher records: " . count($voucherValues));
                
                if (empty($voucherValues)) {
                    Log::error("No voucher values were parsed");
                    return;
                }

                // Log first voucher for debugging
                Log::info("First voucher data:", ['data' => $voucherValues[0]]);

                // Disable foreign key checks
                DB::statement('SET FOREIGN_KEY_CHECKS=0;');

                try {
                    // Clear existing data
                    DB::table('vouchers')->truncate();
                    Log::info("Truncated vouchers table");
                    
                    // Insert vouchers in smaller chunks
                    foreach (array_chunk($voucherValues, 50) as $i => $chunk) {
                        try {
                            DB::table('vouchers')->insert($chunk);
                            Log::info("Inserted chunk " . ($i + 1) . " of vouchers");
                        } catch (\Exception $e) {
                            Log::error("Error inserting voucher chunk " . ($i + 1) . ": " . $e->getMessage());
                            Log::error("First record in problematic chunk:", ['data' => reset($chunk)]);
                            throw $e;
                        }
                    }
                } catch (\Exception $e) {
                    Log::error("Error during vouchers insertion: " . $e->getMessage());
                    throw $e;
                }
            } else {
                Log::warning("No vouchers data found in SQL file");
                Log::info("SQL file preview (first 500 chars): " . substr($sql, 0, 500));
            }

            // Extract voucher_records data
            preg_match("/INSERT INTO `voucher_records`\s+VALUES\s*\((.*?)\);/s", $sql, $recordMatches);
            if (!empty($recordMatches[1])) {
                Log::info("Found voucher_records data");
                $recordValues = $this->parseValues($recordMatches[1]);
                Log::info("Parsed voucher_record records: " . count($recordValues));

                if (empty($recordValues)) {
                    Log::error("No voucher_record values were parsed");
                    return;
                }

                try {
                    // Clear existing data
                    DB::table('voucher_records')->truncate();
                    Log::info("Truncated voucher_records table");
                    
                    // Insert records in smaller chunks
                    foreach (array_chunk($recordValues, 50) as $i => $chunk) {
                        try {
                            DB::table('voucher_records')->insert($chunk);
                            Log::info("Inserted chunk " . ($i + 1) . " of voucher_records");
                        } catch (\Exception $e) {
                            Log::error("Error inserting voucher_record chunk " . ($i + 1) . ": " . $e->getMessage());
                            Log::error("First record in problematic chunk:", ['data' => reset($chunk)]);
                            throw $e;
                        }
                    }
                } catch (\Exception $e) {
                    Log::error("Error during voucher_records insertion: " . $e->getMessage());
                    throw $e;
                }
            } else {
                Log::warning("No voucher_records data found in SQL file");
            }

        } catch (\Exception $e) {
            Log::error("VoucherSeeder failed: " . $e->getMessage());
            throw $e;
        } finally {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }

    private function parseValues(string $valuesString): array
    {
        $valuesString = trim($valuesString);
        $valueGroups = explode('),(', trim($valuesString, '()'));
        
        $result = [];
        foreach ($valueGroups as $index => $group) {
            try {
                // Replace NULL with actual null value
                $group = preg_replace("/('NULL'|NULL)/", "null", $group);
                
                $values = str_getcsv($group, ',', "'");
                
                if (count($values) === 23) { // Vouchers table
                    $result[] = [
                        'id' => trim($values[0]),
                        'voucher_number' => trim($values[1], "' "),
                        'sub_total' => (int)$values[2],
                        'total' => (int)$values[3],
                        'deli_fee' => (int)$values[4],
                        'actual_cost' => (int)$values[5],
                        'profit' => (int)$values[6],
                        'pay_amount' => (int)$values[7],
                        'reduce_amount' => (int)$values[8],
                        'change' => (int)$values[9],
                        'debt_amount' => (int)$values[10],
                        'promotion_amount' => (int)$values[11],
                        'user_id' => (int)$values[12],
                        'customer_name' => trim($values[13], "' "),
                        'customer_phone' => trim($values[14], "' "),
                        'customer_city' => trim($values[15], "' "),
                        'customer_address' => trim($values[16], "' "),
                        'payment_method' => trim($values[17], "' "),
                        'status' => $values[18] === 'null' ? null : trim($values[18], "' "),
                        'remark' => $values[19] === 'null' ? null : trim($values[19], "' "),
                        'order_date' => trim($values[20], "' "),
                        'created_at' => trim($values[21], "' "),
                        'updated_at' => trim($values[22], "' "),
                    ];
                } elseif (count($values) === 8) { // Voucher_records table
                    $result[] = [
                        'id' => trim($values[0]),
                        'cost' => (int)$values[1],
                        'quantity' => (float)$values[2],
                        'unit_id' => (int)$values[3],
                        'product_id' => (int)$values[4],
                        'voucher_id' => (int)$values[5],
                        'created_at' => trim($values[6], "' "),
                        'updated_at' => trim($values[7], "' "),
                    ];
                } else {
                    Log::warning("Skipping record with unexpected number of values: " . count($values));
                    Log::warning("Values: " . json_encode($values));
                }
            } catch (\Exception $e) {
                Log::error("Error parsing group {$index}: " . $e->getMessage());
                Log::error("Problematic group: " . $group);
                throw $e;
            }
        }
        
        return $result;
    }
}