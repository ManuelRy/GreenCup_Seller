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
}
