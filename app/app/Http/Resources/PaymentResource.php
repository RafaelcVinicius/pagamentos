<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Nette\Utils\Floats;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "uuid"                  => $this->uuid,
            'transectionAmount'     => (float)$this->transection_amount,
            'origemAmount'          => (float)$this->paymentIntention->total_amount,
            'status'                => $this->lastStatus()->status,
            'gateway'               => $this->paymentIntention->gateway,
            'email'                 => $this->email,
            'payer'                 => $this->when($this->paymentIntention->payer, new PayerResource($this->paymentIntention->payer)),
            'feeDetails'            => $this->when($this->feeDelails, new PaymentFeeDetailsCollection($this->feeDetails)),
            'detailCards'           => $this->when($this->payment_type != 'pix', new PaymentDetailCardsCollection($this->detailCards)),
            'detailPix'             => $this->when($this->payment_type == 'pix', new PaymentDetailPixResource($this->detailPix)),
            'detailStatus'          => new PaymentStatusCollection($this->status),
            'calbackUrl'            => $this->paymentIntention->callback_url . '?status=' . $this->lastStatus()->status,
            'webHook'               => $this->paymentIntention->webhook,
        ];
    }
}
