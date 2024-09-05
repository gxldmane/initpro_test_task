<?php

namespace App\Http\Controllers;

use App\Services\TenderService;
use Illuminate\Http\Request;

class TenderController extends Controller
{
    public function __construct(private TenderService $tenderService)
    {}

    public function getTenders()
    {

    }
}
