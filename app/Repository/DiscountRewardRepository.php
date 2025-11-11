<?php

namespace App\Repository;

use App\Models\DiscountReward;
use Illuminate\Support\Facades\DB;

class DiscountRewardRepository
{
    /**
     * Get all discount rewards for a seller
     */
    public function list($seller_id)
    {
        return DiscountReward::where('seller_id', $seller_id)
            ->orderBy('discount_percentage', 'asc')
            ->get();
    }

    /**
     * Get active discount rewards for a seller
     */
    public function listActive($seller_id)
    {
        return DiscountReward::where('seller_id', $seller_id)
            ->where('is_active', true)
            ->orderBy('discount_percentage', 'asc')
            ->get();
    }

    /**
     * Get a specific discount reward
     */
    public function get($id, $seller_id = null)
    {
        $query = DiscountReward::where('id', $id);

        if ($seller_id) {
            $query->where('seller_id', $seller_id);
        }

        return $query->first();
    }

    /**
     * Create a new discount reward
     */
    public function create(array $data)
    {
        return DiscountReward::create($data);
    }

    /**
     * Update a discount reward
     */
    public function update($id, $seller_id, array $data)
    {
        $discountReward = $this->get($id, $seller_id);

        if (!$discountReward) {
            return null;
        }

        $discountReward->update($data);
        return $discountReward;
    }

    /**
     * Delete a discount reward
     */
    public function delete($id, $seller_id)
    {
        $discountReward = $this->get($id, $seller_id);

        if (!$discountReward) {
            return false;
        }

        return $discountReward->delete();
    }

    /**
     * Toggle active status
     */
    public function toggleActive($id, $seller_id)
    {
        $discountReward = $this->get($id, $seller_id);

        if (!$discountReward) {
            return null;
        }

        $discountReward->is_active = !$discountReward->is_active;
        $discountReward->save();

        return $discountReward;
    }
}
