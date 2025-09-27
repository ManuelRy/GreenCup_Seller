<?php

namespace App\Repository;

use App\Models\Reward;
use Illuminate\Database\Eloquent\Model;

class RewardRepository
{
  public function list($seller_id)
  {
    return  Reward::where('seller_id', $seller_id)
      ->orderBy('created_at', 'desc')
      ->paginate(12);
  }
  public function get($id, $seller_id): ?Model
  {
    return Reward::where('id', $id)->where('seller_id', $seller_id)->first();
  }
  public function create($data = []): ?Model
  {
    return Reward::create($data);
  }
  public function update($id, $seller_id, $data = []): bool
  {
    $item = $this->get($id, $seller_id);
    return $item ? $item->update($data) : false;
  }

  public function delete($id, $seller_id): bool
  {
    $item = $this->get($id, $seller_id);
    return $item ? $item->delete() : false;
  }

  /**
   * Increment the quantity_redeemed for a reward
   */
  public function incrementQuantityRedeemed($reward_id): bool
  {
    $reward = Reward::find($reward_id);
    if ($reward && $reward->quantity_redeemed < $reward->quantity) {
      $reward->increment('quantity_redeemed');
      return true;
    }
    return false;
  }

  /**
   * Decrement the quantity_redeemed for a reward (used when redemption is rejected)
   */
  public function decrementQuantityRedeemed($reward_id): bool
  {
    $reward = Reward::find($reward_id);
    if ($reward && $reward->quantity_redeemed > 0) {
      $reward->decrement('quantity_redeemed');
      return true;
    }
    return false;
  }
}
