<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCarRequest;
use App\Models\Car;
use Carbon\Carbon;
use Illuminate\Http\Response;

class CarController extends Controller
{
    /**
     * @return Response
     */
    public function index(): Response
    {
        $cars = Car::paginate(100)->all();

        $response = ['success' => true, 'data' => $cars];
        return response($response, 200);
    }

    /**
     * @param StoreCarRequest $request
     * @return Response
     */
    public function store(StoreCarRequest $request): Response
    {
        $data = $request->all();

        //Add timestamps
        $data = data_fill($data, '*.created_at', Carbon::now()->toDateTimeString());
        $data = data_fill($data, '*.updated_at', Carbon::now()->toDateTimeString());

        Car::insert($data);

        $response = ['success' => true, 'message' => 'The car(s) have been successfully saved.'];
        return response($response, 200);
    }

    /**
     * @param $id
     * @return Response
     */
    public function show($id): Response
    {
        $car = Car::find($id);

        $response = ['success' => true, 'data' => $car];
        return response($response, 200);
    }


    /**
     * @param StoreCarRequest $request
     * @param $id
     * @return Response
     */
    public function update(StoreCarRequest $request, $id): Response
    {
        $car = Car::find($id);

        if (!$car) {
            $response = ['success' => false, 'message' => 'The car was not found.'];
            return response($response, 200);
        }

        $car->update($request->all());
        $response = ['success' => true, 'message' => 'The car have been successfully updated.'];
        return response($response, 200);
    }

    /**
     * @param $id
     * @return Response
     */
    public function destroy($id): Response
    {
        $car = Car::find($id);

        if (!$car) {
            $response = ['success' => false, 'message' => 'The car was not found.'];
            return response($response, 200);
        }

        $car->delete();

        $response = ['success' => true, 'message' => 'The car have been successfully removed.'];
        return response($response, 200);
    }
}
