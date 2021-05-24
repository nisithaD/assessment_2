<?php

namespace App\Http\Controllers;

use App\BusSchedule;
use App\BusScheduleBooking;
use App\Http\Requests\BookScheduleRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\Routes;
use App\Http\Resources\Schedules;
use App\Http\Resources\UserBookings;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //user Register
    public function userRegister(UserStoreRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token', ['book_schedule,schedule_list,my_bookings,cancel_bookings'])->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    //user Login
    public function userlogin(UserLoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    //get bus schedule list
    public function bus_schedule_list(Request $request)
    {
        $user = $request->user();
        if ($user->tokenCan('schedule_list')) {
            $relations = [
                'routeRelation',
            ];
            return Schedules::collection(BusSchedule::with($relations)->get());
        }
    }

    //book schedule
    public function book_schedule(BookScheduleRequest $request)
    {
        $user = $request->user();
        if ($user->tokenCan('book_schedule')) {
            $route = BusScheduleBooking::create([
                'bus_seat_id' => $request->bus_seat_id,
                'user_id' => $request->user()->id,
                'bus_schedule_id' => $request->bus_schedule_id,
                'status' => $request->status
            ]);

            if ($route) {
                return response()->json([
                    'message' => 'New booking record added successfully!'
                ]);
            } else {
                return response()->json([
                    'message' => 'New booking failed!'
                ]);
            }
        }
    }

    //my_bookings
    public function user_bookings(Request $request)
    {
//        $user_bookings=DB::table('bus_schedule_bookings')
//            ->join('bus_seats','bus_schedule_bookings.bus_seat_id','bus_seats.id')
//            ->join('bus_schedules','bus_schedule_bookings.bus_schedule_id','bus_schedules.id')
//            ->select('bus_schedule_bookings.*','bus_seats.*','bus_schedules.*')
//            ->where('bus_schedule_bookings.user_id',$request->user()->id)->get();
//
//        return response()->json(['data'=>$user_bookings]);

        $user = $request->user();
        if ($user->tokenCan('my_bookings')) {
            return UserBookings::collection(BusScheduleBooking::with(['getBusScheduleRelation', 'getBusSeatRelation'])->where('user_id', $request->user()->id)->get());
        }
    }

    public function cancel_bookings($id)
    {
        $booking = BusScheduleBooking::where('id', $id)->first();

        $time_difference = (int)($booking->created_at->diff(Carbon::now('IST'))->format('%H'));

        if ($time_difference <= 10 && $booking->status == 1) {
            BusScheduleBooking::where('id', $id)
                ->update([
                    'status' => 0,
                ]);
            return response()->json([
                'message' => 'Booking canceled successfully!'
            ]);
        } else {
            return response()->json([
                'message' => 'Booking cancel failed!'
            ]);
        }
    }
}
