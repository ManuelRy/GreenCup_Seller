<?php

namespace App\Repository;

use App\Models\SellerPhoto;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class SellerGalleryRepository
{
  public function list($seller_id): Collection
  {
    return SellerPhoto::where('seller_id', $seller_id)->get();
  }

  public function create($data = [])
  {
    return SellerPhoto::create($data);
  }

  public function get($id, $seller_id): ?Model
  {
    return SellerPhoto::where('id', $id)->where('seller_id', $seller_id)->first();
  }

  public function update($id, $seller_id, $data = []): bool
  {
    $photo = $this->get($id, $seller_id);
    return $photo ? $photo->update($data) : false;
  }

  public function delete($id, $seller_id): bool
  {
    $gallery = $this->get($id, $seller_id);
    return $gallery ? $gallery->delete() : false;
  }
}
