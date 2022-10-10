<?php

namespace App\Http\Controllers;
use DB;
use App\Model\Prescriptions_m;
use App\Model\Inquiry;
use App\User;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    public function store(Request $request,$selectedMethod,$pspat,$diagnosis_id)
    {
        # $selectedMethod 1 = meal
        # $selectedMethod 2 = frequency
        date_default_timezone_set('Asia/Manila');
        $getUser = User::where(['id'=>$request->dctr])->first();
        $request['created_by'] = 3;
        $request['created_dt'] = date("Y-m-d");
        $request['pspat'] = $pspat;
        $request['doctor'] = $getUser->name;
        $data = Prescriptions_m::create($request->except('_token'));
        $Inquiry = new Inquiry;
        $reg_p = $request->iscustom?0:$request->reg_p;
        $dsc_p = $request->iscustom?0:$request->dsc_p;
        $sc_p =  $request->iscustom?0:$request->src_p;
        $reg_p = $request->reg_p;
        $dsc_p = $request->dsc_p;
        $sc_p = $request->src_p;
        $getQty = 0;
        if($selectedMethod == 1){
            $qty = floatval($request->qty) * floatval($request->days);
            if($request->iscustom){
                $qty = 0;
            }
            $getQty = $qty;
        }else if($request->selectedMethod == 2){
            $qty = floatval($request->qtyF);// * floatval($request->days);//SUBJECT TO CHANGE DUE TO NOT APPLICABLE TO SOME CASES
            if($request->iscustom){
                $qty = 0;
            }
            $getQty = $qty;
        }


        $Inquiry->pk_iwitems = $request->iscustom?0:$request->pk_iwitems;
        $Inquiry->item_description = $request->medecine_desc;
        $Inquiry->item_generic_name = $request->generic_name;
        $Inquiry->item_reg_price = $reg_p;
        $Inquiry->item_discounted_price = $dsc_p;
        $Inquiry->item_sc_price = $sc_p;
        $Inquiry->doctor = trim($getUser->name);
        $Inquiry->item_qty =  floatval($getQty);
        $total_amt_reg = number_format((float)$reg_p, 2, '.', '') * floatval($getQty);//floatval($reg_p) * floatval($qty);
        $total_amt_dsc = number_format((float)$dsc_p, 2, '.', '') * floatval($getQty);//floatval($total_amt_reg) * floatval(0.80);
        $total_amt_sc = number_format((float)$sc_p, 2, '.', '') * floatval($getQty);//floatval($total_amt_dsc) / floatval(1.12);
        $Inquiry->item_total_amt_reg = $total_amt_reg;
        $Inquiry->item_total_amt_disc = $total_amt_dsc;
        $Inquiry->item_total_amt_sc_disc = $total_amt_sc;
        $Inquiry->transaction_id = $diagnosis_id;
        $Inquiry->prescription_id = $data->prescription_id;
        $Inquiry->ancillary_location = 1;
        $Inquiry->pspat = $pspat;
        
        $Inquiry->save();
        echo $data->prescription_id;
    }
    
}
