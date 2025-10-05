<?php

namespace App\Repository;

use App\Models\RedeemHistory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class RedeemHistoryRepository
{
  public function get($id): ?Model
  {
    return RedeemHistory::with(['consumer', 'reward'])->where('id', $id)->first();
  }

  public function create(array $data): ?Model
  {
    return RedeemHistory::create($data);
  }

  public function pending($seller_id): Collection
  {
    return RedeemHistory::with(['reward', 'consumer'])
      ->where('status', 'pending')
      ->whereHas('reward', function ($query) use ($seller_id) {
        $query->where('seller_id', $seller_id);
      })
      ->get();
  }

  /**
   * Create a redemption request and increment the reward's quantity_redeemed
   */
  public function createRedemption(int $consumer_id, int $reward_id): ?Model
  {
    $redemption = RedeemHistory::create([
      'consumer_id' => $consumer_id,
      'reward_id' => $reward_id,
      'is_redeemed' => false,
      'status' => 'pending',
    ]);

    // Increment the reward's quantity_redeemed
    if ($redemption) {
      $reward = \App\Models\Reward::find($reward_id);
      if ($reward && $reward->quantity_redeemed < $reward->quantity) {
        $reward->increment('quantity_redeemed');
      }
    }

    return $redemption;
  }

  public function approve($id): bool
  {
    $rh = $this->get($id);
    return $rh ? $rh->update([
      'is_redeemed' => true,
      'status' => 'approved',
      'approved_at' => now(),
    ]) : false;
  }

  public function reject($id, $reason = null): bool
  {
    $rh = $this->get($id);
    return $rh ? $rh->update([
      'status' => 'rejected',
      'rejected_at' => now(),
      'rejection_reason' => $reason,
    ]) : false;
  }
}
