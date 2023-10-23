<?php

namespace App\Http\Resources;

use App\Models\OrderPrescriptions;
use App\Models\Pharmacy;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $address = UserAddress::find($this->delivering_address_id);
        $pharmchy = Pharmacy::find($this->pharmchy_id) || null;
        $prescriptions = OrderPrescriptions::where(['order_id' => $this->id])->get();
        return [
            'id' => $this->id,
            'status' => $this->status,
            'is_insured' => $this->is_insured,
            'order_total_price' => $this->total_price,
            'ordered_at' => $this->created_at->diffForHumans(),
            'address' => new UserAddressResource($address),
            'pharmchy' =>$pharmchy,
            'prescription' =>OrderPrescriptionsResource::collection($prescriptions)
        ];
    }
}
