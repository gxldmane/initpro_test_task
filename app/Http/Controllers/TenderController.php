<?php

namespace App\Http\Controllers;

use App\Http\Resources\TenderResource;
use App\Models\Tender;
use App\Services\TenderService;

class TenderController extends Controller
{
    public function __construct(private TenderService $tenderService)
    {
    }

    public function getTenders()
    {
        $this->tenderService->parseTenders();

        return TenderResource::collection(Tender::all());
    }
}
