<?php

namespace App\Http\Controllers;
use DB;
use App\Model\Prescriptions_m;
use App\Model\Inquiry;
use App\Model\Frequency;
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
        $request['created_at'] = date("Y-m-d");
        $request['pspat'] = $pspat;
        $request['doctor'] = $getUser->name;
        $request['diagnosis_id'] = $diagnosis_id;
        $request['medecine_desc'] = $request->item_description;
        $request['generic_name'] = $request->item_generic_name;
        $request['bf_time'] = $request->breakFast;
        $request['sp_time'] = $request->supper;
        $request['ln_time'] = $request->lunch;
        $request['bbt_time'] = $request->bbt;
        $request['quantity'] = $request->qty;
        $request['price'] = $request->reg_p;
        $request['dc_price'] = $request->dsc_p;
        $request['sc_price'] = $request->src_p;
        $request['due'] = $selectedMethod == 1?$request->dueDate:$request->dueDateF;
        if($selectedMethod == 2){
            $getF = Frequency::where(['id'=>$request->frequency])->first();
            $request['time'] = $getF->timing_dosage;
            $request['frequency_txt'] = $getF->frequency;
            $request['quantity'] = $request->qtyF;
            $request['days'] = $request->daysF;
        }
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
        $Inquiry->item_description = $request->item_description;
        $Inquiry->item_generic_name = $request->item_generic_name;
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
        $Inquiry->created_at = date('Y-m-d H:i');
        $Inquiry->inserted_by = $request->dctr;
        
        $Inquiry->save();
        echo $data->prescription_id;
    }

    public function getrequency()
    {
        $data = Frequency::all();
        return response()->json($data);
    }

    public function getPrescribeMedicine($id)
    {
        //$query = Prescriptions_m::where('pspat', $id)->where('doctor',trim($request->getDoctor))->get();
        $query = Prescriptions_m::where('pspat', $id)->get();
        $data = array();
        foreach ($query as $key ) {
            $arr = array();
            $arr['id'] = $key->prescription_id;
            $arr['med_id'] = $key->medecine_id;
            $arr['med_desc'] = $key->medecine_desc;
            $arr['med_gen_name'] = "(".strtolower($key->generic_name).")";
            $arr['dosage'] = $key->dosage;
            $arr['instruction'] = $key->instruction;
            $arr['frequency_txt'] = $key->frequency_txt;
            $arr['quantity'] = $q = $key->quantity;
            $arr['days'] = $key->days;
            $arr['method'] = $key->frequency_txt? 2:1;
            $button = '';
            $button = $button.'<button class="btn  btn-sm btn-primary" title="Edit Prescriptions" onclick="edit_med('."'".$key->prescription_id."'".')"><i class="fa fa-edit" ></i></button>  ';
            $button = $button.'<button type="button" class="btn btn-sm  btn-danger" id="openModalMedicine" title="Remove Prescriptions" onclick="remove_med('."'".$key->prescription_id."'".')"><i class="fa fa-times" ></i> </button> ';
            $arr['actions'] = $button;
            $data[] = $arr;

        }
        return response()->json($data);
    }

    public function getPrecriptionDetail($id)
    {
        $query = Prescriptions_m::where('prescription_id', $id)->first();
        return response()->json($query);
    }

    public function updateMedicine(Request $request,$selectedMethod,$prescription_id)
    {
        if($selectedMethod == 1){
            $qty = floatval($request->qty);
        }else if($selectedMethod == 2){
            $qty = floatval($request->qtyF);// * floatval($request->days);//SUBJECT TO CHANGE DUE TO NOT APPLICABLE TO SOME CASES
        }
        $book = Prescriptions_m::where(['prescription_id'=>$prescription_id])->update([
            'medecine_desc'=>$request->item_description,
            'medecine_id'=>$request->iscustom?0:$request->medecine_id,
            'generic_name'=>$request->item_generic_name,
            'dosage'=>$request->dosage,
            'instruction'=>$request->instruction,
            'bf_time'=>$request->breakFast,
            'ln_time'=>$request->lunch,
            'sp_time'=>$request->supper,
            'bbt_time'=>$request->bbt,
            'frequency'=>$request->selectedMethod == 2 ?$request->frequency:null,
            'frequency_txt'=>$request->selectedMethod == 2 ?$request->frequency_txt:null,
            'days'=>$request->selectedMethod == 2 ?$request->daysF:$request->days,
            'quantity'=>$request->selectedMethod == 2 ?$request->qtyF:$request->qty,
            'ispc'=>$request->ispc,
            'time'=>$request->time,
            'due'=>$request->selectedMethod == 2 ?$request->dueDateF:$request->dueDate,
            ]
        );
        $total_amt_reg = $request->iscustom?0:number_format((float)$request->price, 2, '.', '') * floatval($qty);
        $total_amt_dsc = $request->iscustom?0:number_format((float)$request->dc_price, 2, '.', '') * floatval($qty);
        $total_amt_sc = $request->iscustom?0:number_format((float)$request->sc_price, 2, '.', '') * floatval($qty);

        $inq = Inquiry::where(['prescription_id'=>$request->prescription_id])->update([
            'item_reg_price'=>$request->iscustom?0:floatval($request->price),
            'item_discounted_price'=>$request->iscustom?0:floatval($request->dc_price),
            'item_sc_price'=>$request->iscustom?0:floatval($request->sc_price),
            'item_qty'=>floatval($qty),
            'item_total_amt_reg'=>$total_amt_reg,
            'item_total_amt_disc'=>$total_amt_dsc,
            'item_total_amt_sc_disc'=>$total_amt_sc,
            'item_description'=>$request->medecine_desc,
            'item_generic_name'=>$request->generic_name,
            ]
        );
        $output = array("data" => $book,"inq"=>$inq);
		return true;
    }
    
}
