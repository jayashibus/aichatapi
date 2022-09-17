<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\V1\StoreRedeemVoucherRequest;
use App\Http\Requests\V1\UpdateRedeemVoucherRequest;
use App\Models\RedeemVoucher;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
class RedeemVoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreRedeemVoucherRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRedeemVoucherRequest $request)
    {
        $request->validate([
            'selfieImage' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'customerId' => 'required'
        ]);

        $imageName = time().'.'.$request->selfieImage->extension();

        // Public Folder
        //$request->image->move(public_path('images'), $imageName);

        if($imageName)
        {
            
            $availbleVoucher = DB::table('vouchers')->where('status', 'L')->where('customer_id', $request->customerId)->first();          
                $noofminutes =  now()->diffInMinutes($availbleVoucher->issued_at);

          
                if($noofminutes >=10)
                {
                    $affected = DB::table('vouchers')
                    ->where('code', $availbleVoucher->code)
                    ->update(['customer_id' => NULL, 'status' => 'A', 'issued_at' => now(), 'updated_at' => now()]);
                    $message = "You coupon code expired. Request new code";
                }
                else{
                    $affected = DB::table('vouchers')
                    ->where('code', $availbleVoucher->code)
                    ->update(['status' => 'I', 'issued_at' => now(), 'updated_at' => now()]);
                    $message = "You are successfully redeemed you cash voucher. Your code : $availbleVoucher->code.";
                }
            
            
        }       
        

        return  response()->json([
            'message' => $message,
            'imagename' => $imageName,
            'customerid' => $request->customer_id,
            'availblevoucher' => $availbleVoucher->code,
            'voucher_issued' => $availbleVoucher->issued_at,
            'TimeDifference' => $noofminutes,
           

         ], 200);     
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RedeemVoucher  $redeemVoucher
     * @return \Illuminate\Http\Response
     */
    public function show(RedeemVoucher $redeemVoucher)
    {
        $verify = DB::table('invoices')
        ->leftJoin('vouchers', 'invoices.customer_id', '=', 'vouchers.customer_id')
        ->where('invoices.customer_id', $redeemVoucher->id)
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
        }

        return $verify;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RedeemVoucher  $redeemVoucher
     * @return \Illuminate\Http\Response
     */
    public function edit(RedeemVoucher $redeemVoucher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRedeemVoucherRequest  $request
     * @param  \App\Models\RedeemVoucher  $redeemVoucher
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRedeemVoucherRequest $request, RedeemVoucher $redeemVoucher)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RedeemVoucher  $redeemVoucher
     * @return \Illuminate\Http\Response
     */
    public function destroy(RedeemVoucher $redeemVoucher)
    {
        //
    }
}
