<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\BaseMaterial;
use Illuminate\Http\Request;

class BaseMaterialController extends Controller
{
    public function index() {
        return response()->json(BaseMaterial::get(), 200);
    }
}
