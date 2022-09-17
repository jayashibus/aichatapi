<?php

namespace App\Http\Controllers\Api\V1;


use App\Http\Requests\V1\StoreVoucherRequest;
use App\Http\Requests\V1\UpdateVoucherRequest;
use App\Http\Resources\V1\VoucherResource;
use App\Models\Voucher;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;



class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Voucher:: all();
    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreVoucherRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVoucherRequest $request)
    {
        return Voucher::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function show(Voucher $voucher)
    {
        $message = "Sorry. You are not eligible to redeem the voucher";
        $verify = DB::table('invoices')
        ->leftJoin('vouchers', 'invoices.customer_id', '=', 'vouchers.customer_id')
        ->where('invoices.customer_id', $voucher->id)
        ->where('invoices.total_spent', '>=', 100)
        ->where('invoices.transaction_at', '>', now()->subDays(30)->endOfDay())
        ->whereNull('vouchers.customer_id')
        ->select('invoices.*', 'vouchers.code', 'vouchers.status', 'vouchers.customer_id as vcustomer_id', 'vouchers.issued_at as vissued_at',  'vouchers.created_at as vcreated_at' , 'vouchers.updated_at as vupdated_at')
        ->get();


        $count = count($verify);
        if($count >=3)
        {
            $availbleVoucher = DB::table('vouchers')->where('status', 'A')->value('code');
            $affected = DB::table('vouchers')
            ->where('code', $availbleVoucher)
            ->update(['customer_id' => $voucher->id, 'status' => 'L', 'issued_at' => now(), 'updated_at' => now()]);
            $message = "You are  eligible to redeem the voucher. Please upload the photo with ABC product and redeem  the cash card";
        }

        //return response()->json(['error' => 'Unauthorized'], 401, ['X-Header-One' => 'Header Value']);
       

       return response()->json([
        'message' => $message,
    ], 200);
    




       // $count = count($price);
       
        //return new VoucherResource($verify->data);

      //  SELECT * FROM invoices LEFT JOIN vouchers on invoices.customer_id = vouchers.customer_id WHERE vouchers.customer_id IS NULL;

       // return $count;
    }

   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function edit(Voucher $voucher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateVoucherRequest  $request
     * @param  \App\Models\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVoucherRequest $request, Voucher $voucher)
    {
        $voucher->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Voucher $voucher)
    {
        //
    }
}
