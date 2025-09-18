<?php

namespace App\Repository;

use App\Models\Item;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ItemRepository
{
  public function list($seller_id): Collection
  {
    return Item::where('seller_id', $seller_id)->orderBy('name')->get();
  }
  public function listQuery($seller_id, $query = null)
  {
    $items = Item::query();
    if ($query) {
      $items->where('name', 'like', '%' . $query . '%');
    }
    return $items->orderBy('name')->paginate(15);
  }
  public function get($id, $seller_id): ?Model
  {
    return Item::where('id', $id)->where('seller_id', $seller_id)->first();
  }
  public function create($data = []): ?Model
  {
    return Item::create($data);
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
}
