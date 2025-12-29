<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AuditorWallet;
use Illuminate\Support\Facades\Log;

class AuditorWalletTransaction extends Model
{
    protected $fillable = [
        'auditor_id',
        'audit_id',
        'amount'
    ];


    public static function createTransaction(int $auditor_id, int $audit_id, float $amount)
    {
        try {
            // Ensure the amount is valid
            if ($amount <= 0) {
                throw new \InvalidArgumentException('Amount must be greater than zero.');
            }

            // Check if the auditor already has a payment for this audit_id
            $existingTransaction = self::where('auditor_id', $auditor_id)
                ->where('audit_id', $audit_id)
                ->exists();

            if ($existingTransaction) {
                throw new \Exception('The auditor already has a payment for this audit ID.');
            }

            // Use a database transaction to ensure atomicity
            return \DB::transaction(function () use ($auditor_id, $audit_id, $amount) {
                // Create the transaction
                $transaction = self::create([
                    'auditor_id' => $auditor_id,
                    'audit_id' => $audit_id,
                    'amount' => $amount,
                ]);

                // Update the wallet balance
                AuditorWallet::updateOrCreate(
                    ['auditor_id' => $auditor_id],
                    ['amount' => \DB::raw('amount + ' . $amount)]
                );

                return $transaction;
            });
        } catch (\Exception $e) {
            // Log the error and return false
            Log::error('Transaction creation failed: ' . $e->getMessage());
            return false;
        }
    }
}
