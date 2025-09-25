<?php

namespace App\Repository;

use App\Models\Seller;
use Illuminate\Database\Eloquent\Model;

class SellerRepository
{

  public function get($id): ?Model
  {
    return Seller::find($id);
  }
  public function update(int $id, array $data): bool
  {
    $seller = $this->get($id);
    return $seller ? $seller->update($data) : false;
  }
   public function addPoints($id, $points): bool
  {
    $seller = $this->get($id);
    if (!$seller) return false;

    $seller->total_points += $points;
    $seller->save();
    return true;
  }
}
