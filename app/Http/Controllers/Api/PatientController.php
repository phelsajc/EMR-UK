<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Diagnosis;
use App\Model\Patient;
use App\User;
use Intervention\Image\ImageManagerStatic as Image;
use DB;

class PatientController extends Controller
{
    
    public function filterEmployee(Request $request)
    {
        //date_default_timezone_set('Asia/Manila');
        $length = 10;
        $start = $request->start?$request->start:0;
        $val = $request->searchTerm2;
        if($val!=''||$start>0){   
            $data =  DB::connection('pgsql')->select("select * from patients_1 where patientname ilike '%".$val."%' and cast(registrydate as date) >= '".date("Y-m-d")."' LIMIT $length offset $start");
            $count =  DB::connection('pgsql')->select("select * from patients_1 where patientname ilike '%".$val."%' and cast(registrydate as date) >= '".date("Y-m-d")."' ");
        }else{
            $data =  DB::connection('pgsql')->select("select * from patients_1 where cast(registrydate as date) >= '".date("Y-m-d")."' LIMIT $length");
            $count =  DB::connection('pgsql')->select("select * from patients_1 where cast(registrydate as date) >= '".date("Y-m-d")."'");
        }
        
        $count_all_record =  DB::connection('pgsql')->select("select count(*) as count from patients_1 where cast(registrydate as date) >= '".date("Y-m-d")."'");

        $data_array = array();

        foreach ($data as $key => $value) {
            $arr = array();

            $arr['patientname'] =  $value->patientname;
            if($value->attending_phy){
                $physicians = DB::connection('bizbox_uk')->select("select dbo.udf_ConcatAllPatientsDoctor($value->attending_phy) as d"); 
                $arr['attending_phy'] =  $physicians[0]->d;
            }else{
                $arr['attending_phy'] =  "";
            }
            $arr['chiefcomplaint'] =  $value->chiefcomplaint;
            $arr['pk_pspatregisters'] =  $value->pk_pspatregisters;
            $arr['patientid'] =  $value->patientid;
            $arr['sex'] =  $value->sex;

            $data_array[] = $arr;
        }
        /* if($val!=''||$start>0){   
            $data = DB::connection('bizbox_uk')->select("SELECT PK_psPatRegisters,
            CAST(a.registrydate as varchar(30)) as registrydate,
            a.chiefcomplaint,
            CAST(dischdate as varchar(30)) as dischdate,
            a.registrystatus,
            dbo.udf_GetFullName(a.FK_emdPatients) PatientName,
            dbo.udf_GetPatID(a.FK_emdPatients) HospitalNo,
            d.gender,
            d.civilstatus,
            CAST(d.birthdate as varchar(30)) as birthdate,
            eg.FK_mscICD10Mstr as icd10Code, eg.description as icd10Description,
            (select
                top 1
                cc.PK_emdDoctors
                from emdDoctors cc
                inner join psDctrLedgers dd
                on   dd.FK_emdDoctors = cc.PK_emdDoctors
                where dd.fk_emdConsultantTypes = 1002
                and   dd.FK_psPatRegisters  = a.PK_psPatRegisters) AS AttendingDoctor,
            (select top 1 cc.PK_psDatacenter
                from emddoctors aa
                    inner join psdctrledgers bb
                    on aa.pk_emddoctors = bb.fk_emddoctors
                    inner join psdatacenter cc
                    on aa.pk_emddoctors = cc.pk_psdatacenter
                    where bb.fk_pspatregisters = a.PK_psPatRegisters and bb.fk_emdconsultanttypes = 1002) as dr_id
            FROM psPatRegisters a
            left join psPersonaldata d
            on d.PK_psPersonalData = a.FK_emdPatients
            left join psPatFinalDXDtls eg
            on eg.FK_psPatRegisters = a.PK_psPatRegisters
            WHERE a.pattrantype = 'O'
            AND   (registrystatus <> 'D' and registrystatus <> 'X')
            AND     dbo.udf_GetFullName(a.FK_emdPatients) like '%$val%'
            AND registrydate between cast(convert(char(30), getdate(), 112) + ' 00:00:00' as datetime) and cast(convert(char(30), getdate(), 112) + ' 23:59:59' as datetime)
            ORDER BY PatientName OFFSET $start ROWS FETCH NEXT $length ROWS ONLY
            ");

            $count =  DB::connection('bizbox_uk')->select("SELECT  PK_psPatRegisters,
            CAST(a.registrydate as varchar(30)) as registrydate,
            CAST(dischdate as varchar(30)) as dischdate,
            a.registrystatus,
            dbo.udf_GetFullName(a.FK_emdPatients) PatientName,
            dbo.udf_GetPatID(a.FK_emdPatients) HospitalNo,
            d.gender,
            d.civilstatus,
            CAST(d.birthdate as varchar(30)) as birthdate,
            eg.FK_mscICD10Mstr as icd10Code, eg.description as icd10Description,
            (select
                top 1
                cc.PK_emdDoctors
                from emdDoctors cc
                inner join psDctrLedgers dd
                on   dd.FK_emdDoctors = cc.PK_emdDoctors
                where dd.fk_emdConsultantTypes = 1002
                and   dd.FK_psPatRegisters  = a.PK_psPatRegisters) AS AttendingDoctor,
            (select top 1 cc.PK_psDatacenter
                from emddoctors aa
                    inner join psdctrledgers bb
                    on aa.pk_emddoctors = bb.fk_emddoctors
                    inner join psdatacenter cc
                    on aa.pk_emddoctors = cc.pk_psdatacenter
                    where bb.fk_pspatregisters = a.PK_psPatRegisters and bb.fk_emdconsultanttypes = 1002) as dr_id
            FROM psPatRegisters a
            left join psPersonaldata d
            on d.PK_psPersonalData = a.FK_emdPatients
            left join psPatFinalDXDtls eg
            on eg.FK_psPatRegisters = a.PK_psPatRegisters
            WHERE a.pattrantype = 'O'
            AND   (registrystatus <> 'D' and registrystatus <> 'X')
            AND     dbo.udf_GetFullName(a.FK_emdPatients) like '%$val%'
            AND registrydate between cast(convert(char(30), getdate(), 112) + ' 00:00:00' as datetime) and cast(convert(char(30), getdate(), 112) + ' 23:59:59' as datetime)
            ORDER BY PatientName");

        }else{
                $data = DB::connection('bizbox_uk')->select("SELECT TOP $length PK_psPatRegisters,
                CAST(a.registrydate as varchar(30)) as registrydate,
                a.chiefcomplaint,
                CAST(dischdate as varchar(30)) as dischdate,
                a.registrystatus,
                dbo.udf_GetFullName(a.FK_emdPatients) PatientName,
                dbo.udf_GetPatID(a.FK_emdPatients) HospitalNo,
                d.gender,
                d.civilstatus,
                CAST(d.birthdate as varchar(30)) as birthdate,
                eg.FK_mscICD10Mstr as icd10Code, eg.description as icd10Description,
                (select
                    top 1
                    cc.PK_emdDoctors
                    from emdDoctors cc
                    inner join psDctrLedgers dd
                    on   dd.FK_emdDoctors = cc.PK_emdDoctors
                    where dd.fk_emdConsultantTypes = 1002
                    and   dd.FK_psPatRegisters  = a.PK_psPatRegisters) AS AttendingDoctor,
                (select top 1 cc.PK_psDatacenter
                    from emddoctors aa
                        inner join psdctrledgers bb
                        on aa.pk_emddoctors = bb.fk_emddoctors
                        inner join psdatacenter cc
                        on aa.pk_emddoctors = cc.pk_psdatacenter
                        where bb.fk_pspatregisters = a.PK_psPatRegisters and bb.fk_emdconsultanttypes = 1002) as dr_id
                FROM psPatRegisters a
                left join psPersonaldata d
                on d.PK_psPersonalData = a.FK_emdPatients
                left join psPatFinalDXDtls eg
                on eg.FK_psPatRegisters = a.PK_psPatRegisters
                WHERE a.pattrantype = 'O'
                AND   (registrystatus <> 'D' and registrystatus <> 'X')
                AND     dbo.udf_GetFullName(a.FK_emdPatients) like '%$val%'
                AND registrydate between cast(convert(char(30), getdate(), 112) + ' 00:00:00' as datetime) and cast(convert(char(30), getdate(), 112) + ' 23:59:59' as datetime)
                ORDER BY PatientName 
                ");

            $count =  DB::connection('bizbox_uk')->select("SELECT  PK_psPatRegisters,
            CAST(a.registrydate as varchar(30)) as registrydate,
            CAST(dischdate as varchar(30)) as dischdate,
            a.registrystatus,
            dbo.udf_GetFullName(a.FK_emdPatients) PatientName,
            dbo.udf_GetPatID(a.FK_emdPatients) HospitalNo,
            d.gender,
            d.civilstatus,
            CAST(d.birthdate as varchar(30)) as birthdate,
            eg.FK_mscICD10Mstr as icd10Code, eg.description as icd10Description,
            (select
                  top 1
                  cc.PK_emdDoctors
                from emdDoctors cc
                  inner join psDctrLedgers dd
                   on   dd.FK_emdDoctors = cc.PK_emdDoctors
                where dd.fk_emdConsultantTypes = 1002
                  and   dd.FK_psPatRegisters  = a.PK_psPatRegisters) AS AttendingDoctor,
            (select top 1 cc.PK_psDatacenter
                from emddoctors aa
                    inner join psdctrledgers bb
                    on aa.pk_emddoctors = bb.fk_emddoctors
                    inner join psdatacenter cc
                    on aa.pk_emddoctors = cc.pk_psdatacenter
                    where bb.fk_pspatregisters = a.PK_psPatRegisters and bb.fk_emdconsultanttypes = 1002) as dr_id
            FROM psPatRegisters a
            left join psPersonaldata d
            on d.PK_psPersonalData = a.FK_emdPatients
            left join psPatFinalDXDtls eg
            on eg.FK_psPatRegisters = a.PK_psPatRegisters
            WHERE a.pattrantype = 'O'
            AND   (registrystatus <> 'D' and registrystatus <> 'X')
            AND     dbo.udf_GetFullName(a.FK_emdPatients) like '%$val%'
            AND registrydate between cast(convert(char(30), getdate(), 112) + ' 00:00:00' as datetime) and cast(convert(char(30), getdate(), 112) + ' 23:59:59' as datetime)
            ORDER BY PatientName");
        } */
        $datasets = array(["data"=>$data_array,"count"=>round(sizeof($count)/$length)],"summary"=>($start+10)." of ".$count_all_record[0]->count, "patient"=>$data_array);
        return response()->json($datasets);
    }
    
    public function check_doctors_detail($id)
    { 
        $physicians = DB::connection('bizbox_uk')->select("select dbo.udf_ConcatAllPatientsDoctor($id) as d"); 
        return response()->json($physicians[0]->d);
    }

    public function saveInitialData(Request $request)
    {
        $checkDetails = Diagnosis::where(['ps_patregisgter'=>$request->pspat])->first();
        if(!$checkDetails){
            $diagnosis = new Diagnosis;
            $diagnosis->o2_stat = $request->o2_stat;
            $diagnosis->temp = $request->temp;
            $diagnosis->bp = $request->bp;
            $diagnosis->weight = $request->weight;
            $diagnosis->height = $request->height;
            $diagnosis->chiefcomplaints = $request->chiefcomplaints;
            $diagnosis->pulse_rate = $request->pulse_rate;
            $diagnosis->rr = $request->rr;
            $diagnosis->ps_patregisgter = $request->pspat;
            $diagnosis->inserted_initial_data_dt = date("Y-m-d H:i");
            $diagnosis->inserted_initial_data_by = $request->user_id;   
            $diagnosis->save();    
        }else{

        }
        
        return true;
    }

    public function getPxInfo($pspat)
    {
        $data = Patient::where(['pk_pspatregisters'=>$pspat])->first();
        return response()->json($data);
    }

    public function EditInitialData($id)
    {
        $data = Diagnosis::where(['ps_patregisgter'=>$id])->first();
        return response()->json($data);
    }
   
}
