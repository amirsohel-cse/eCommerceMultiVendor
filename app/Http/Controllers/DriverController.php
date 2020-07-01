<?php

namespace App\Http\Controllers;

use App\Driver;
use App\Mail\OrderEmailDriver;
use App\Order;
use App\OrderDetail;
use Illuminate\Http\Request;
use App\Staff;
use App\Role;
use App\User;
use Hash;
use Illuminate\Support\Facades\Mail;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $drivers = Driver::orderBy('updated_at','desc')->get();
         return view('driver.index', compact('drivers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('driver.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255|string',
            'phone' => 'required|unique:drivers,phone|max:255|string',
            'email' => 'required|unique:drivers,email|max:255|string',
            'password' => 'required|min:6|string',
        ]);
        if($validatedData){
               $driver = new Driver;
               $driver->name = $request['name'];
               $driver->phone = $request['phone'];
               $driver->email = $request['email'];
               $driver->password = Hash::make($request['password']);
               $driver->plate_no = $request['plate_no'];
               $driver->city = $request['city'];
               $driver->area = $request['area'];
               $driver->status = $request['status'];
           if($driver->save()){
               flash(__('Driver has been inserted successfully'))->success();
               return redirect()->route('driver.index');
           }else{
               flash(__('Something went wrong'))->error();
               return back();
           }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function delivered_ordered(){
        $delivered_orders = OrderDetail::where('delivery_status','delivered')->distinct()->get(['order_id']);
        return view('driver.delivered_order',compact('delivered_orders'));

    }
    public function non_delivered_order(){
        $delivered_orders = OrderDetail::where('delivery_status','!=','delivered')->distinct()->get(['order_id']);
        return view('driver.non_delivered',compact('delivered_orders'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $driver = Driver::findOrFail(decrypt($id));
        return view('driver.edit',compact('driver'));
    }
    public function details(Request $request)
    {
        return Driver::where('id',$request->driver_id)->select(['id','name','phone','plate_no','area','city','email'])->first();
    }
    public function insert(Request $request)
    {
        $order_update = OrderDetail::where('order_id',$request->order_id)->update(['driver_id'=>$request->driver_id,'delivery_status'=>'driver assigned']);
        if($order_update){
            $order = Order::find($request->order_id);
            $driver = Driver::find($request->driver_id);
            $shipping_address = json_decode($order->shipping_address);

            $array['view'] = 'emails.order';
            $array['subject'] = 'Order Placed - '.$order->code;
            $array['from'] = env('MAIL_USERNAME');
            $array['content'] = 'A product with tracking number '.$order->code.' assigned to you. Please deliver';
            $array['driver_name'] =$driver->name;

            \Mail::to($driver->email)->queue(new OrderEmailDriver($array));

            flash(__('Driver has been assigned and send mail successfully'))->success();



            $mobileMessage = "Dear". $shipping_address->name.",Your order# '.$order->code.' has been assigned to driver($driver->name), 
            kindly share your GPS location on the given mobile#".$shipping_address->phone;

            sendSMS($shipping_address->phone, $mobileMessage);

            return redirect()->back();
        }
        flash(__('Something went wrong'))->error();
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function driver_update(Request $request, $id)
    {

        $validatedData = $request->validate([
            'name' => 'required|max:255|string',
        ]);
       if($validatedData){
           $driver = Driver::findOrFail($id);
           $driver->name = $request['name'];
           $driver->password = Hash::make($request['password']);
           $driver->plate_no = $request['plate_no'];
           $driver->city = $request['city'];
           $driver->area = $request['area'];
           $driver->status = $request['status'];
           if($driver->save()){
               flash(__('Driver has been updated successfully'))->success();
               return redirect()->route('driver.index');
           }else{
               flash(__('Something went wrong'))->error();
               return back();
           }
       }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
//        User::destroy(Staff::findOrFail($id)->user->id);
        if(Driver::destroy($id)){
            flash(__('Driver has been deleted successfully'))->success();
            return redirect()->route('driver.index');
        }

        flash(__('Something went wrong'))->error();
        return back();
    }
}
