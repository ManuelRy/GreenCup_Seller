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
  public function pending($seller_id): Collection
  {
    return RedeemHistory::with(['reward', 'consumer'])
      ->whereHas('reward', function ($query) use ($seller_id) {
        $query->where('seller_id', $seller_id);
      })
      ->get();
  }

  public function approve($id): bool
  {
    $rh = $this->get($id);
    return $rh ? $rh->update([
      'is_redeemed' => true
    ]) : false;
  }
  public function reject($id): bool
  {
    $rh = $this->get($id);
    return $rh ? $rh->delete() : false;
  }
}
