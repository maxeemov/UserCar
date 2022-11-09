<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserCar;
use Illuminate\Http\Response;

class UserCarController extends Controller
{
    /**
     * @return Response
     */
    public function index(): Response
    {
        $usersCars = User::whereHas('cars')->paginate(100)->all();

        $response = ['success' => true, 'data' => $usersCars];
        return response($response, 200);
    }
}
