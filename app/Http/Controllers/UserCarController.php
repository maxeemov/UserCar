<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserCarRequest;
use App\Models\Car;
use App\Models\User;
use App\Models\UserCar;
use Carbon\Carbon;
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

    /**
     * StoreUserCarRequest checks unique entry
     * @return Response
     */
    public function store(StoreUserCarRequest $request): Response
    {
        $data = $request->all();

        //Add timestamps
        $data = data_fill($data, '*.created_at', Carbon::now()->toDateTimeString());
        $data = data_fill($data, '*.updated_at', Carbon::now()->toDateTimeString());

        UserCar::insert($data);

        $response = ['success' => true, 'message' => 'The car(s) have been successfully saved.'];
        return response($response, 200);
    }

    /**
     * Detach all cars by user id
     * @param $id
     * @return Response
     */
    public function detachUser($id): Response
    {
        $user = User::find($id);

        if (!$user) {
            $response = ['success' => false, 'message' => 'The user was not found.'];
            return response($response, 404);
        }

        $user->cars()->detach();

        $response = ['success' => true, 'message' => 'All cars have been successfully detached.'];
        return response($response, 200);
    }

    /**
     * Detach all users by car id
     * @param $id
     * @return Response
     */
    public function detachCar($id): Response
    {
        $car = Car::find($id);

        if (!$car) {
            $response = ['success' => false, 'message' => 'The car was not found.'];
            return response($response, 404);
        }

        $car->users()->detach();

        $response = ['success' => true, 'message' => 'All users have been successfully detached.'];
        return response($response, 200);
    }
}
