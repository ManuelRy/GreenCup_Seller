<?php

namespace App\Repository;

use App\Models\PendingTransaction;
use Illuminate\Database\Eloquent\Model;

class PendingTransactionRepository
{
  public function listQuery($seller_id)
  {
    return PendingTransaction::where('seller_id', $seller_id)
      ->orderBy('created_at', 'desc');
  }

  public function get($id, $seller_id): ?Model
  {
    return  PendingTransaction::where('seller_id', $seller_id)->where('id', $id)->with(['consumer'])->first();
  }

  public function create($data)
  {
    return PendingTransaction::create([
      ...$data,
      'receipt_code' => $this->generateCode(),
      'status' => 'pending',
    ]);
  }

  public function stats($seller_id)
  {
    $now = now();

    return PendingTransaction::selectRaw("
        COUNT(*) as total,
        SUM(CASE
            WHEN status = 'pending' AND (expires_at IS NULL OR expires_at > ?)
            THEN 1 ELSE 0
        END) as pending,
        SUM(CASE WHEN status = 'claimed' THEN 1 ELSE 0 END) as claimed,
        SUM(CASE
            WHEN status = 'expired' OR (status = 'pending' AND expires_at IS NOT NULL AND expires_at <= ?)
            THEN 1 ELSE 0
        END) as expired,
        SUM(total_points) as total_points_issued,
        SUM(CASE WHEN status = 'claimed' THEN total_points ELSE 0 END) as total_points_claimed
    ", [$now, $now])
      ->where('seller_id', $seller_id)
      ->first()
      ->toArray();
  }
 public function update($id, $seller_id, $data = []): bool
  {
    $receipt = $this->get($id, $seller_id);
    return $receipt ? $receipt->update($data) : false;
  }

  private function generateCode(): string
  {
    $timestamp = date('YmdHis');
    $milliseconds = sprintf('%03d', (int)(microtime(true) * 1000) % 1000);
    return "RCP_{$timestamp}{$milliseconds}";
  }
}
