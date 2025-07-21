<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'item_description' => $this->description,
            'amount' => (float) $this->amount,
            'category' => $this->category->name,
            'expense_date' => $this->expense_date,
            'recorded_by' => $this->user->name,
        ];
    }
}
