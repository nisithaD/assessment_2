<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Bus;
use App\BusRoute;
use App\BusSchedule;
use App\BusSeat;
use App\Http\Requests\AddScheduleRequest;
use App\Http\Requests\AddSeatRequest;
use App\Http\Requests\EditMappingRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserNameUpdate;
use App\Http\Requests\AddBusRequest;
use App\Http\Requests\AddRouteRequest;
use App\Http\Requests\CreateMappingRequest;
use App\Http\Resources\Mappings;
use App\Http\Resources\Routes;
use App\Http\Resources\Schedules;
use App\Http\Resources\Seats;
use App\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\UserPasswordUpdate;
use App\Http\Resources\Buses as BusesResource;
use App\Http\Resources\Routes as RoutesResource;
use App\Http\Resources\Mappings as MappingResource;



class AdminController extends Controller
{
    //admin Login
    public function adminlogin(UserLoginRequest $request)
    {
        //check_email
        $user = Admin::where('email', $request['email'])->firstOrFail();

        //check_password
        if (!$user || !Hash::check($request['password'], $user->password)) {
            return response([
                'message' => 'Invalid creds'
            ], 401);
        }

        $token = $user->createToken('auth_token', ['management:admin', 'management:bus', 'management:route', 'bus_mapping', 'seat_management', 'schedule_management'])->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    //admin management
    public function admin_name_update(UserNameUpdate $request)
    {
        $user = $request->user();
        if ($user->tokenCan('management:admin')) {
            $affected = DB::table('admins')
                ->where('id', $request->user()->id)
                ->update(['name' => $request['name']]);

            return response()->json([
                'success',
                'response' => $affected
            ]);
        }
    }

    public function admin_pw_update(UserPasswordUpdate $request)
    {
        $user = $request->user();
        if ($user->tokenCan('management:admin')) {
            if (Hash::check($request['current_password'], $user->password)) {
                $affected = DB::table('admins')
                    ->where('id', $request->user()->id)
                    ->update(['password' => Hash::make($request->new_password)]);

                return response()->json([
                    'success',
                    'response' => $affected
                ]);
            } else {
                return response()->json([
                    'message' => 'password update failed!',
                ]);
            }
        }
    }
    //end admin manage

    //bus_management

    public function add_bus(AddBusRequest $request)
    {
        $user = $request->user();
        if ($user->tokenCan('management:bus')) {
            $bus = Bus::create([
                'name' => $request->name,
                'type' => $request->type,
                'vehicle_number' => $request->vehicle_number,
            ]);
            if ($bus) {
                return response()->json([
                    'message' => 'New bus added successfully!'
                ]);
            } else {
                return response()->json([
                    'message' => 'New bus adding failed!'
                ]);
            }
        }
        return response()->json([
            'message' => 'you have no permission!'
        ]);
    }

    public function get_buses()
    {
        return BusesResource::collection(Bus::all());
    }

    //update bus
    public function update_bus(Request $request, $id)
    {
        $user = $request->user();
        if ($user->tokenCan('management:bus')) {
            $affected = Bus::where('id', $id)
                ->update(['name' => $request['name'], 'type' => $request['type'], 'vehicle_number' => $request['vehicle_number']]);

            return response()->json([
                'success',
                'response' => $affected]);
        }
    }

    //delete bus
    public function delete_bus(Request $request, $id)
    {
        $user = $request->user();
        if ($user->tokenCan('management:bus')) {
            $bus = Bus::where('id', $id)->delete();
            if (!$bus) {
                return response()->json([
                    'failed',
                    'message' => 'Delete failed!']);
            }
            return response()->json([
                'success',
                'message' => 'Successfully deleted!']);
        }
    }

    //end bus_management

    //route management

    //add route

    public function add_route(AddRouteRequest $request)
    {
        $user = $request->user();
        if ($user->tokenCan('management:route')) {
            $route = Route::create([
                'node_one' => $request->node_one,
                'node_two' => $request->node_two,
                'route_number' => $request->route_number,
                'distance' => $request->distance
            ]);

            if ($route) {
                return response()->json([
                    'message' => 'New route added successfully!'
                ]);
            } else {
                return response()->json([
                    'message' => 'New route adding failed!'
                ]);
            }
        }
    }

    public function get_routes(Request $request)
    {
        $user = $request->user();
        if ($user->tokenCan('management:route')) {
            return RoutesResource::collection(Route::all());
        }
    }

    //update route
    public function update_route(AddRouteRequest $request, $id)
    {
        $user = $request->user();
        if ($user->tokenCan('management:route')) {
            $affected = Route::where('id', $id)
                ->update(['node_one' => $request['node_one'], 'node_two' => $request['node_two'], 'route_number' => $request['route_number'], 'distance' => $request['distance']]);

            if ($affected) {
                return response()->json([
                    'message' => 'Route updated successfully!'
                ]);
            } else {
                return response()->json([
                    'message' => 'Route update failed!'
                ]);
            }
        }
    }

    public function delete_route(Request $request, $id)
    {
        $user = $request->user();
        if ($user->tokenCan('management:route')) {
            $route = Route::where('id', $id)->delete();
            if (!$route) {
                return response()->json([
                    'failed',
                    'message' => 'Delete failed!']);
            }
            return response()->json([
                'success',
                'message' => 'Successfully deleted!']);
        }
    }

    //end route management

    //route_bus_mapping
    public function create_mapping(CreateMappingRequest $request)
    {
        $user = $request->user();
        if ($user->tokenCan('bus_mapping')) {
            $route = BusRoute::create([
                'bus_id' => $request->bus_id,
                'route_id' => $request->route_id,
                'status' => $request->status,
            ]);

            if ($route) {
                return response()->json([
                    'message' => 'New map added successfully!'
                ]);
            } else {
                return response()->json([
                    'message' => 'New map adding failed!'
                ]);
            }
        }
    }

    public function get_mappings(Request $request)
    {
        $user = $request->user();
        if ($user->tokenCan('bus_mapping')) {
            $relations = [
                'getBusRelation',
                'getRouteRelation',
            ];
            return Mappings::collection(BusRoute::with($relations)->get());
        }
    }
    public function update_mappings(EditMappingRequest $request,$id)
    {
        $user = $request->user();
        if ($user->tokenCan('bus_mapping')) {
            $affected = BusRoute::where('id', $id)
                ->update([
                    'bus_id' => $request->bus_id,
                    'route_id' => $request->route_id,
                    'status' => $request->status,]);
        }

        if ($affected) {
            return response()->json([
                'message' => 'Mapping updated successfully!'
            ]);
        } else {
            return response()->json([
                'message' => 'Mapping update failed!'
            ]);
        }
    }

    public function delete_mapping(Request $request,$id)
    {
        $user = $request->user();
        if ($user->tokenCan('management:route')) {
            $route = BusRoute::where('id', $id)->delete();
            if (!$route) {
                return response()->json([
                    'failed',
                    'message' => 'Delete failed!']);
            }
            return response()->json([
                'success',
                'message' => 'Successfully deleted!']);
        }
    }
    //end route_bus_mapping

    //bus_seat_management
    public function add_seat(AddSeatRequest $request)
    {
        $user=$request->user();
        if($user->tokenCan('seat_management')){
            $route = BusSeat::create([
                'bus_id' => $request->bus_id,
                'seat_number' => $request->seat_number,
                'price' => $request->price,
            ]);

            if ($route) {
                return response()->json([
                    'message' => 'New seat added successfully!'
                ]);
            } else {
                return response()->json([
                    'message' => 'New seat adding failed!'
                ]);
            }
        }
    }

    public function update_seat(AddSeatRequest $request,$id)
    {
        $user=$request->user();
        if($user->tokenCan('seat_management')){
            $affected = BusSeat::where('id', $id)
                ->update([
                    'bus_id' => $request->bus_id,
                    'seat_number' => $request->seat_number,
                    'price' => $request->price,
                    ]);
        }
        if ($affected) {
            return response()->json([
                'message' => 'Seat updated successfully!'
            ]);
        } else {
            return response()->json([
                'message' => 'Seat update failed!'
            ]);
        }
    }

    public function get_seat_data(Request $request)
    {
        $user=$request->user();
        if($user->tokenCan('seat_management')) {

            $relations = [
                'getBusRelation',
            ];
            return Seats::collection(BusSeat::with($relations)->get());
        }
    }

    public function delete_seat(Request $request,$id)
    {
        $user = $request->user();
        if ($user->tokenCan('seat_management')) {
            $route = BusSeat::where('id', $id)->delete();
            if (!$route) {
                return response()->json([
                    'failed',
                    'message' => 'Delete failed!']);
            }
            return response()->json([
                'success',
                'message' => 'Successfully deleted!']);
        }
    }
    //end_bus_seat_management

    //schedule management
    public function create_schedule(AddScheduleRequest $request)
    {
        $user = $request->user();
        if ($user->tokenCan('schedule_management')) {
            $route = BusSchedule::create([
                'route_id' => $request->route_id,
                'direction' => $request->direction,
                'start_timestamp' => $request->start_timestamp,
                'end_timestamp'=>$request->end_timestamp
            ]);

            if ($route) {
                return response()->json([
                    'message' => 'New schedule added successfully!'
                ]);
            } else {
                return response()->json([
                    'message' => 'New schedule adding failed!'
                ]);
            }
        }
    }

    public function get_schedules(Request $request)
    {
        $user=$request->user();
        if($user->tokenCan('schedule_management')) {
            $relations = [
                'routeRelation',
            ];

            return Schedules::collection(BusSchedule::with($relations)->get());
        }
    }

    public function update_schedule(AddScheduleRequest $request,$id)
    {
        $user=$request->user();
        if($user->tokenCan('schedule_management')){
            $affected = BusSchedule::where('id', $id)
                ->update([
                    'route_id' => $request->route_id,
                    'direction' => $request->direction,
                    'start_timestamp' => $request->start_timestamp,
                    'end_timestamp' => $request->end_timestamp,
                ]);
        }
        if ($affected) {
            return response()->json([
                'message' => 'Schedule updated successfully!'
            ]);
        } else {
            return response()->json([
                'message' => 'Schedule update failed!'
            ]);
        }
    }

    public function delete_schedule(Request $request,$id)
    {
        $user = $request->user();
        if ($user->tokenCan('schedule_management')) {
            $route = BusSchedule::where('id', $id)->delete();
            if (!$route) {
                return response()->json([
                    'failed',
                    'message' => 'Delete failed!']);
            }
            return response()->json([
                'success',
                'message' => 'Successfully deleted!']);
        }
    }
}
