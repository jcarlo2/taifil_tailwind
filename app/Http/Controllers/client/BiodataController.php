<?php

namespace App\Http\Controllers\client;

use data;
use App\Models\jpl_data;
use App\Models\local_emp;
use App\Models\abroad_emp;
use App\Models\sibling_data;
use Illuminate\Http\Request;
use App\Models\children_data;
use App\Models\personal_data;
use App\Models\relative_data;
use App\Models\prometric_data;
use App\Models\vocational_data;
use App\Models\educational_data;
use App\Models\japanvisit_data;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BiodataController extends Controller
{


    public function view(Request $request){
        return view("/pages/biodata",['biodata'=>$request->data]);
    }
    public function view_jp(Request $request){
        return view("jp/pages/biodata",['biodata'=>$request->data]);
    }

    public function uploadData(Request $request)
    {
        $query = "Select * from personal_datas where isdeleted = 0 AND last_name = '" . $request->personal["lastname"] . 
                "' AND first_name = '" . $request->personal["firstname"] . "' AND middle_name = '" .$request->personal["middlename"].
                "' AND job_cat = '" . $request->personal["job_cat"]. "'";
        $IsExist = DB::select($query);
        $personalID = 0;
        $data = [
            'id' => "",
            'success' => false,
            'msgType' => 'error',
            'msgTitle' => 'error!'
        ];
       try {
        DB::beginTransaction();
        if ($request["personalid"] == 0){
            if(COUNT($IsExist) != 0){
                $data = [
                    'id' => '',
                    'success' => false,
                    'msgType' => 'error',
                    'msgTitle' => 'Applicant name with same job category already exists!'
                ];
            }
            else{
                $id = DB::table("personal_datas")->insertGetID([
                    // "code" => $request->personal["code"],
                    "job_cat" => $request->personal["job_cat"],
                    "operation" => $request->personal["operations"],
                    "last_name" => $request->personal["lastname"],
                    "first_name" => $request->personal["firstname"],
                    "middle_name" => $request->personal["middlename"],
                    "nickname" => $request->personal["nickname"],
                    "lastname" => $request->personal["lastname"],
                    "address" => $request->personal["address"],
                    "date_birth" => date('Y-m-d H:i:s',strtotime( $request->personal["birthday"])),
                    "place_birth" => $request->personal["birth_place"],
                    "gender" => $request->personal["gender"],
                    "citizenship" => $request->personal["citizenship"],
                    "age" => (int) $request->personal["age"],
                    "bloodtype" => isset($request->personal["blood_type"])?$request->personal["blood_type"]:'N/A',
                    "civil_status" => $request->personal["civil_status"],
                    "contact" => (int) $request->personal["contact"],
                    "height" => (int) $request->personal["height"],
                    "religion" => $request->personal["religion"],
                    "facebook" => $request->personal["facebook"],
                    "smoking" => $request->personal["smoking"],
                    "weight" => (int) $request->personal["weight"],
                    "jap_reading" => isset($request->personal["jp_reading"])?  $request->personal["jp_reading"] : null,
                    "jap_writing" => isset($request->personal["jp_writing"])?  $request->personal["jp_writing"] : null,
                    "jap_speaking" => isset($request->personal["jp_Speaking"])? $request->personal["jp_Speaking"] : null,
                    "jap_listening" => isset($request->personal["jp_Listening"])? $request->personal["jp_Listening"] : null,
                    "other_lang" => $request->personal["other_lang"],
                    "shoe_size" => (int) $request->personal["shoe_size"],
                    "hobbies" => $request->personal["hobbies"],
                    "person_to_notify" => $request->personal["person_to_notify"],
                    "person_relation" => $request->personal["relation"],
                    "person_address" => $request->personal["person_address"],
                    "person_contact" => (int) $request->personal["person_contact"],
                    "passport_no" => $request->personal["passport"],
                    "issue_date" => date('Y-m-d H:i:s', strtotime($request->personal["issue_date"])),
                    "isdeleted" => 0,
                    "expiry_date" => date('Y-m-d H:i:s', strtotime($request->personal["expiry_date"])),
                    "issue_place" => $request->personal["issue_place"],
                    "allergy" => $request->personal["allergy"] == "1" ? true : false,
                    "food_alergy" => isset($request->personal["food_allergy"]) ? $request->personal["food_allergy"] : null,
                    "tattoo" =>  $request->personal["tattoo"] == "1" ? true : false,
                    "drivers_licensed" =>  $request->personal["licensed"] == "1" ? true : false,
                    "type_licensed" => isset($request->personal["type_licensed"]) ? $request->personal["type_licensed"] : null,
                    "valid_licensed" => isset($request->personal["licensed_until"]) ? date('Y-m-d H:i:s', strtotime($request->personal["licensed_until"])) : null,
                    "job_type" => $request->personal["job_type"],
                    "created_at" => date('Y-m-d H:i:s'),
                    "updated_at" => date('Y-m-d H:i:s')
                ]);
                
                $educ_id = DB::table("educational_datas")->insertGetID([
                    "personal_id" => $id,
                    "name_elem" => $request->educational["name_elem"],
                    "address_elem" => $request->educational["add_elem"],
                    "from_elem" => date('Y-m-d H:i:s' ,strtotime($request->educational["date_from_elem"])),
                    "until_elem" => date('Y-m-d H:i:s' ,strtotime($request->educational["date_until_elem"])),
                    "name_highschool" => $request->educational["name_highschool"],
                    "address_highschool" => $request->educational["add_highschool"],
                    "from_highschool" => date('Y-m-d H:i:s' ,strtotime($request->educational["date_from_highschool"])),
                    "until_highschool" => date('Y-m-d H:i:s' ,strtotime($request->educational["date_until_highschool"])),
                    "name_jp_lang" => isset($request->educational["name_jpl"])?$request->educational["name_jpl"]:null,
                    "address_jp_lang" => isset($request->educational["add_jpl"])?$request->educational["add_jpl"]:null,
                    "from_jp_lang" => isset($request->educational["date_from_jpl"])? date('Y-m-d H:i:s' ,strtotime($request->educational["date_from_jpl"])):null,
                    "until_jp_lang" => isset($request->educational["date_until_jpl"])? date('Y-m-d H:i:s' ,strtotime($request->educational["date_until_jpl"])):null,
                    "certificate_jp_lang" => isset($request->educational["certificate_jpl"])?$request->educational["certificate_jpl"]:null,
                    "certificate_until_jp_lang" => isset($request->educational["date_until_cert_jpl"])? date('Y-m-d H:i:s' ,strtotime($request->educational["date_until_cert_jpl"])):null,
                    "name_college" => $request->educational["name_college"],
                    "address_college" => $request->educational["add_college"],
                    "from_college" => date('Y-m-d H:i:s' ,strtotime($request->educational["date_from_college"])),
                    "until_college" => date('Y-m-d H:i:s' ,strtotime($request->educational["date_until_college"])),
                    "course_college" => $request->educational["course_college"],
                    "certificate_college" => $request->educational["certificate_college"],
                    "certificate_until_college" =>  date('Y-m-d H:i:s' ,strtotime($request->educational["date_until_cert_college"])),
                    "isdeleted" => 0,
                    "created_at" => date('Y-m-d H:i:s'),
                    "updated_at" => date('Y-m-d H:i:s')
                ]);

                foreach ($request->vocational as $vc){
                    vocational_data::create([
                        "educational_id" => $educ_id,
                        "name" => $vc["name"],
                        "address" => $vc["address"],
                        "from" =>  date('Y-m-d H:i:s' ,strtotime($vc["from"])),
                        "until" =>  date('Y-m-d H:i:s' ,strtotime($vc["until"])),
                        "course" => $vc["course"],
                        "certificate" => $vc["certificate"],
                        "certificate_until" =>  date('Y-m-d H:i:s' ,strtotime($vc["certificate_until"])),
                    ]);
                }

                if(isset($request->local_emp)){
                    foreach($request->local_emp as $le){
                        local_emp::create([
                            "personal_id" => $id,
                            "company_name" => $le["company"],
                            "position" => $le["position"],
                            "company_address" => $le["address"],
                            "from" => date('Y-m-d H:i:s' ,strtotime($le["from"])),
                            "until" => date('Y-m-d H:i:s' ,strtotime($le["until"])),
                        ]);
                    }
                }

                if(isset($request->abroad_emp)){
                    foreach($request->abroad_emp as $le){
                        abroad_emp::create([
                            "personal_id" => $id,
                            "company_name" => $le["company"],
                            "position" => $le["position"],
                            "company_address" => $le["address"],
                            "from" => date('Y-m-d H:i:s' ,strtotime($le["from"])),
                            "until" => date('Y-m-d H:i:s' ,strtotime($le["until"]))
                        ]);
                    }
                }
                $overstay = false;
                $fakeidentity = false;
                $surrender =false;
                $approved_visa = false;

                if(isset($request->family["overstay"])){
                    if($request->family["overstay"] == "1"){
                        $overstay = true;
                    }else{
                        $overstay = false;
                    }
                }
                if(isset($request->family["fakeidentity"])){
                    if($request->family["fakeidentity"] == "1"){
                        $fakeidentity = true;
                    }else{
                        $fakeidentity = false;
                    }
                }
                if(isset($request->family["fakeidentity_surrendered"])){
                    if($request->family["fakeidentity_surrendered"] == "1"){
                        $surrender = true;
                    }else{
                        $surrender = false;
                    }
                }
                if(isset($request->family["visa_approved"])){
                    if($request->family["visa_approved"] == "1"){
                        $approved_visa = true;
                    }else{
                        $approved_visa = false;
                    }
                }
                $family_id = DB::table("family_datas")->insertGetId([
                    "personal_id" => $id,
                    "father_name" => isset($request->family["father"])?$request->family["father"] :null ,
                    "father_birth" => isset($request->family["father_birthday"])?date('Y-m-d H:i:s' ,strtotime($request->family["father_birthday"])) :null ,
                    "father_occupation" => isset($request->family["father_occupation"])?$request->family["father_occupation"] :null ,
                    "father_cp" => isset($request->family["father_cp"])?$request->family["father_cp"] :null ,
                    "father_address" => isset($request->family["father_address"])?$request->family["father_address"] :null ,
                    "mother_name" => isset($request->family["mother"])?$request->family["mother"] :null ,
                    "mother_birth" => isset($request->family["mother_birthday"])?date('Y-m-d H:i:s' ,strtotime($request->family["mother_birthday"])) :null ,
                    "mother_occupation" => isset($request->family["mother_occupation"])?$request->family["mother_occupation"] :null ,
                    "mother_cp" => isset( $request->family["mother_cp"])? $request->family["mother_cp"] :null,
                    "mother_address" => isset($request->family["mother_address"])?$request->family["mother_address"] :null ,
                    "spouse_name" => isset($request->family["spouse"])?$request->family["spouse"] :null ,
                    "spouse_birth" => isset($request->family["spouse_birthday"])?date('Y-m-d H:i:s' ,strtotime($request->family["spouse_birthday"])) :null ,
                    "spouse_occupation" => isset($request->family["spouse_occupation"])?$request->family["spouse_occupation"] :null ,
                    "spouse_cp" => isset( $request->family["spouse_cp"])? $request->family["spouse_cp"] :null,
                    "spouse_address" => isset($request->family["spouse_address"])?$request->family["spouse_address"] :null ,
                    "partner_name" => isset($request->family["partner"])?$request->family["partner"] :null ,
                    "partner_birthday" => isset($request->family["partner_birthday"])?date('Y-m-d H:i:s' ,strtotime($request->family["partner_birthday"])) :null ,
                    "partner_Occupation" => isset($request->family["partner_Occupation"])?$request->family["partner_Occupation"] :null ,
                    "partner_cp" => isset($request->family["partner_cp"])?$request->family["partner_cp"] :null ,
                    "partner_address" => isset($request->family["partner_address"])?$request->family["partner_address"] :null ,
                    "went_japan" => ($request->family["went_japan"] == "1")? true :false  ,
                    "how_many_japan" => isset($request->family["japan_times"])?$request->family["japan_times"] :null ,
                    // "when_japan" => isset($request->family["japan_when"])?$request->family["japan_when"] :null ,
                    // "where_japan" => isset($request->family["japan_where"])?$request->family["japan_where"] :null ,
                    "overstay_japan" => $overstay,
                    "how_long_overstay" => isset($request->family["overstay_howlong"])?$request->family["overstay_howlong"] :null ,
                    "fake_identity_japan" => $fakeidentity,
                    "fake_identity_purpose" => isset($request->family["fakeidentity_purpose"])?$request->family["fakeidentity_purpose"] :null ,
                    "fake_identity_surrender" => $surrender,
                    "applied_visa" => ($request->family["visa"] == "1")?true :false ,
                    "type_visa" => isset($request->family["visa_type"])?$request->family["visa_type"] :null ,
                    "when_applied_visa" => isset($request->family["visa_when"])?date('Y-m-d H:i:s' ,strtotime($request->family["visa_when"])) :null ,
                    "approved" => $approved_visa,
                    "isdeleted" => 0,
                    "created_at" => date('Y-m-d H:i:s'),
                    "updated_at" => date('Y-m-d H:i:s')
                ]);
                if(isset($request->relative)){
                    foreach($request->relative as $r){
                        relative_data::create([
                            "family_id" => $family_id,
                            "name" => $r['name'],
                            "relation" => $r['relation'],
                            "cp" => $r['contact'],
                            "address" => $r['address'],

                        ]);
                    }
                }
                if(isset($request->japanvisit)){
                    foreach($request->japanvisit as $c){
                        // DB::table('japanvisit_data')->insert([
                        //     'family_id' => $family_id,
                        //     'where' => $c['where'],
                        //     'when' => date('Y-m-d H:i:s' ,strtotime($c['when'])),
                        // ]);
                         japanvisit_data::create([
                            'family_id' => $family_id,
                            'where' => $c['where'],
                            'when' => date('Y-m-d H:i:s' ,strtotime($c['when'])),
                        ]);
                    }
                }

                if(isset($request->sibling)){
                    foreach($request->sibling as $s){
                        sibling_data::create([
                            "family_id" => $family_id,
                            "sibling_name" => $s['name'],
                            "sibling_birth" => date('Y-m-d H:i:s' ,strtotime($s['birhtday'])),
                            "sibling_occupation" => $s['occupation'],
                            "sibling_cp" => $s['cp'],
                            "sibling_address" => $s['address'],
                        ]);
                    }
                }
                if(isset($request->children)){
                    foreach($request->children as $c){
                        children_data::create([
                            "family_id" => $family_id,
                            "name" => $c["name"],
                            "birthday" => date('Y-m-d H:i:s' ,strtotime($c['birthday'])),
                        ]);
                    }
                }
                if(isset($request->prometric)){
                    foreach($request->prometric as $p){
                        prometric_data::create([
                            "personal_id" => $id,
                            "name" => $p["name"],
                            "address" => $p["address"],
                            "from" => date('Y-m-d H:i:s' ,strtotime($p['from'])),
                            "until" => date('Y-m-d H:i:s' ,strtotime($p['until'])),
                            "certificate" => $p["certificate"],
                            "cert_until" => date('Y-m-d H:i:s' ,strtotime($p['certificate_until'])),
                        ]);
                    }
                }
                if(isset($request->jpl)){
                    foreach($request->jpl as $j){
                        jpl_data::create([
                            "personal_id" => $id,
                            "name" => $j["name"],
                            "address" => $j["address"],
                            "from" => date('Y-m-d H:i:s' ,strtotime($j['from'])),
                            "until" => date('Y-m-d H:i:s' ,strtotime($j['until'])),
                            "certificate" => $j["certificate"],
                            "cert_until" => date('Y-m-d H:i:s' ,strtotime($j['certificate_until'])),
                        ]);
                    }
                }
                $data = [
                    'id' => $id,
                    'success' => true,
                    'msgType' => 'success',
                    'msgTitle' => 'Success!'
                ];
            }
        }
        else{

            if($IsExist[0]->id != $request["personalid"]){
                $data = [
                    'id' => '',
                    'success' => false,
                    'msgType' => 'error',
                    'msgTitle' => 'Applicant name with same job category already exists!'
                ];
            }
            else{
                DB::table("personal_datas")
                ->where('id', $request["personalid"])
                ->update([
                    // "code" => $request->personal["code"],
                    "job_cat" => $request->personal["job_cat"],
                    "operation" => $request->personal["operations"],
                    "last_name" => $request->personal["lastname"],
                    "first_name" => $request->personal["firstname"],
                    "middle_name" => $request->personal["middlename"],
                    "nickname" => $request->personal["nickname"],
                    "lastname" => $request->personal["lastname"],
                    "address" => $request->personal["address"],
                    "date_birth" => date('Y-m-d H:i:s',strtotime( $request->personal["birthday"])),
                    "place_birth" => $request->personal["birth_place"],
                    "gender" => $request->personal["gender"],
                    "citizenship" => $request->personal["citizenship"],
                    "age" => (int) $request->personal["age"],
                    "bloodtype" => isset($request->personal["blood_type"])?$request->personal["blood_type"]:'N/A',
                    "civil_status" => $request->personal["civil_status"],
                    "contact" => (int) $request->personal["contact"],
                    "height" => (int) $request->personal["height"],
                    "religion" => $request->personal["religion"],
                    "facebook" => $request->personal["facebook"],
                    "smoking" => $request->personal["smoking"],
                    "weight" => (int) $request->personal["weight"],
                    "jap_reading" => isset($request->personal["jp_reading"])?  $request->personal["jp_reading"] : null,
                    "jap_writing" => isset($request->personal["jp_writing"])?  $request->personal["jp_writing"] : null,
                    "jap_speaking" => isset($request->personal["jp_Speaking"])? $request->personal["jp_Speaking"] : null,
                    "jap_listening" => isset($request->personal["jp_Listening"])? $request->personal["jp_Listening"] : null,
                    "other_lang" => $request->personal["other_lang"],
                    "shoe_size" => (int) $request->personal["shoe_size"],
                    "hobbies" => $request->personal["hobbies"],
                    "person_to_notify" => $request->personal["person_to_notify"],
                    "person_relation" => $request->personal["relation"],
                    "person_address" => $request->personal["person_address"],
                    "person_contact" => (int) $request->personal["person_contact"],
                    "passport_no" => $request->personal["passport"],
                    "issue_date" => date('Y-m-d H:i:s', strtotime($request->personal["issue_date"])),
                    "expiry_date" => date('Y-m-d H:i:s', strtotime($request->personal["expiry_date"])),
                    "issue_place" => $request->personal["issue_place"],
                    "allergy" => $request->personal["allergy"] == "1" ? true : false,
                    "food_alergy" => isset($request->personal["food_allergy"]) ? $request->personal["food_allergy"] : null,
                    "tattoo" =>  $request->personal["tattoo"] == "1" ? true : false,
                    "drivers_licensed" =>  $request->personal["licensed"] == "1" ? true : false,
                    "type_licensed" => isset($request->personal["type_licensed"]) ? $request->personal["type_licensed"] : null,
                    "valid_licensed" => isset($request->personal["licensed_until"]) ? date('Y-m-d H:i:s', strtotime($request->personal["licensed_until"])) : null,
                    "job_type" => $request->personal["job_type"],
                    "updated_at" => date('Y-m-d H:i:s')
                ]);
                
                DB::table("educational_datas")
                ->where('personal_id', $request["personalid"])
                ->update([
                    "personal_id" => $request["personalid"],
                    "name_elem" => $request->educational["name_elem"],
                    "address_elem" => $request->educational["add_elem"],
                    "from_elem" => date('Y-m-d H:i:s' ,strtotime($request->educational["date_from_elem"])),
                    "until_elem" => date('Y-m-d H:i:s' ,strtotime($request->educational["date_until_elem"])),
                    "name_highschool" => $request->educational["name_highschool"],
                    "address_highschool" => $request->educational["add_highschool"],
                    "from_highschool" => date('Y-m-d H:i:s' ,strtotime($request->educational["date_from_highschool"])),
                    "until_highschool" => date('Y-m-d H:i:s' ,strtotime($request->educational["date_until_highschool"])),
                    "name_jp_lang" => isset($request->educational["name_jpl"])?$request->educational["name_jpl"]:null,
                    "address_jp_lang" => isset($request->educational["add_jpl"])?$request->educational["add_jpl"]:null,
                    "from_jp_lang" => isset($request->educational["date_from_jpl"])? date('Y-m-d H:i:s' ,strtotime($request->educational["date_from_jpl"])):null,
                    "until_jp_lang" => isset($request->educational["date_until_jpl"])? date('Y-m-d H:i:s' ,strtotime($request->educational["date_until_jpl"])):null,
                    "certificate_jp_lang" => isset($request->educational["certificate_jpl"])?$request->educational["certificate_jpl"]:null,
                    "certificate_until_jp_lang" => isset($request->educational["date_until_cert_jpl"])? date('Y-m-d H:i:s' ,strtotime($request->educational["date_until_cert_jpl"])):null,
                    "name_college" => $request->educational["name_college"],
                    "address_college" => $request->educational["add_college"],
                    "from_college" => date('Y-m-d H:i:s' ,strtotime($request->educational["date_from_college"])),
                    "until_college" => date('Y-m-d H:i:s' ,strtotime($request->educational["date_until_college"])),
                    "course_college" => $request->educational["course_college"],
                    "certificate_college" => $request->educational["certificate_college"],
                    "certificate_until_college" =>  date('Y-m-d H:i:s' ,strtotime($request->educational["date_until_cert_college"])),
                    "updated_at" => date('Y-m-d H:i:s')
                ]);
    
                $educ_id = DB::select("select id from educational_datas where personal_id = '" . $request["personalid"] . "'");
    
                DB::table('vocational_datas')->where('educational_id', $educ_id[0]->id)->delete();
                foreach ($request->vocational as $vc){
                    vocational_data::create([
                        "educational_id" => $educ_id[0]->id,
                        "name" => $vc["name"],
                        "address" => $vc["address"],
                        "from" =>  date('Y-m-d H:i:s' ,strtotime($vc["from"])),
                        "until" =>  date('Y-m-d H:i:s' ,strtotime($vc["until"])),
                        "course" => $vc["course"],
                        "certificate" => $vc["certificate"],
                        "certificate_until" =>  date('Y-m-d H:i:s' ,strtotime($vc["certificate_until"])),
                    ]);
                }
                if(isset($request->local_emp)){
                    DB::table('local_emps')->where('personal_id', $request["personalid"])->delete();
                    foreach($request->local_emp as $le){
                        local_emp::create([
                            "personal_id" => $request["personalid"],
                            "company_name" => $le["company"],
                            "position" => $le["position"],
                            "company_address" => $le["address"],
                            "from" => date('Y-m-d H:i:s' ,strtotime($le["from"])),
                            "until" => date('Y-m-d H:i:s' ,strtotime($le["until"])),
                        ]);
                    }
                }
    
                if(isset($request->abroad_emp)){
                    DB::table('abroad_emps')->where('personal_id', $request["personalid"])->delete();
                    foreach($request->abroad_emp as $le){
                        abroad_emp::create([
                            "personal_id" => $request["personalid"],
                            "company_name" => $le["company"],
                            "position" => $le["position"],
                            "company_address" => $le["address"],
                            "from" => date('Y-m-d H:i:s' ,strtotime($le["from"])),
                            "until" => date('Y-m-d H:i:s' ,strtotime($le["until"]))
                        ]);
                    }
                }
                $overstay = false;
                $fakeidentity = false;
                $surrender =false;
                $approved_visa = false;
    
                if(isset($request->family["overstay"])){
                    if($request->family["overstay"] == "1"){
                        $overstay = true;
                    }else{
                        $overstay = false;
                    }
                }
                if(isset($request->family["fakeidentity"])){
                    if($request->family["fakeidentity"] == "1"){
                        $fakeidentity = true;
                    }else{
                        $fakeidentity = false;
                    }
                }
                if(isset($request->family["fakeidentity_surrendered"])){
                    if($request->family["fakeidentity_surrendered"] == "1"){
                        $surrender = true;
                    }else{
                        $surrender = false;
                    }
                }
    
                if(isset($request->family["visa_approved"])){
                    if($request->family["visa_approved"] == "1"){
                        $approved_visa = true;
                    }else{
                        $approved_visa = false;
                    }
                }
                DB::table("family_datas")
                ->where('personal_id', $request["personalid"])
                ->update([
                    "personal_id" => $request["personalid"],
                    "father_name" => isset($request->family["father"])?$request->family["father"] :null ,
                    "father_birth" => isset($request->family["father_birthday"])?date('Y-m-d H:i:s' ,strtotime($request->family["father_birthday"])) :null ,
                    "father_occupation" => isset($request->family["father_occupation"])?$request->family["father_occupation"] :null ,
                    "father_cp" => isset($request->family["father_cp"])?$request->family["father_cp"] :null ,
                    "father_address" => isset($request->family["father_address"])?$request->family["father_address"] :null ,
                    "mother_name" => isset($request->family["mother"])?$request->family["mother"] :null ,
                    "mother_birth" => isset($request->family["mother_birthday"])?date('Y-m-d H:i:s' ,strtotime($request->family["mother_birthday"])) :null ,
                    "mother_occupation" => isset($request->family["mother_occupation"])?$request->family["mother_occupation"] :null ,
                    "mother_cp" => isset( $request->family["mother_cp"])? $request->family["mother_cp"] :null,
                    "mother_address" => isset($request->family["mother_address"])?$request->family["mother_address"] :null ,
                    "spouse_name" => isset($request->family["spouse"])?$request->family["spouse"] :null ,
                    "spouse_birth" => isset($request->family["spouse_birthday"])?date('Y-m-d H:i:s' ,strtotime($request->family["spouse_birthday"])) :null ,
                    "spouse_occupation" => isset($request->family["spouse_occupation"])?$request->family["spouse_occupation"] :null ,
                    "spouse_cp" => isset( $request->family["spouse_cp"])? $request->family["spouse_cp"] :null,
                    "spouse_address" => isset($request->family["spouse_address"])?$request->family["spouse_address"] :null ,
                    "partner_name" => isset($request->family["partner"])?$request->family["partner"] :null ,
                    "partner_age" => isset($request->family["partner_age"])?$request->family["partner_age"] :null ,
                    "partner_howlong" => isset($request->family["partner_howlong"])?$request->family["partner_howlong"] :null ,
                    "partner_cp" => isset($request->family["partner_cp"])?$request->family["partner_cp"] :null ,
                    "partner_address" => isset($request->family["partner_address"])?$request->family["partner_address"] :null ,
                    "went_japan" => ($request->family["went_japan"] == "1")? true :false  ,
                    "how_many_japan" => isset($request->family["japan_times"])?$request->family["japan_times"] :null ,
                    "when_japan" => isset($request->family["japan_when"])?$request->family["japan_when"] :null ,
                    "where_japan" => isset($request->family["japan_where"])?$request->family["japan_where"] :null ,
                    "overstay_japan" => $overstay,
                    "how_long_overstay" => isset($request->family["overstay_howlong"])?$request->family["overstay_howlong"] :null ,
                    "fake_identity_japan" => $fakeidentity,
                    "fake_identity_purpose" => isset($request->family["fakeidentity_purpose"])?$request->family["fakeidentity_purpose"] :null ,
                    "fake_identity_surrender" => $surrender,
                    "applied_visa" => ($request->family["visa"] == "1")?true :false ,
                    "type_visa" => isset($request->family["visa_type"])?$request->family["visa_type"] :null ,
                    "when_applied_visa" => isset($request->family["visa_when"])?date('Y-m-d H:i:s' ,strtotime($request->family["visa_when"])) :null ,
                    "approved" => $approved_visa,
                    "updated_at" => date('Y-m-d H:i:s')
                ]);
                $family_id = DB::select("select id from family_datas where personal_id = " . $request["personalid"]);
                if(isset($request->relative)){
                    DB::table('relative_datas')->where('family_id', $family_id[0]->id)->delete();
                    foreach($request->relative as $r){
                        relative_data::create([
                            "family_id" => $family_id[0]->id,
                            "name" => $r['name'],
                            "relation" => $r['relation'],
                            "cp" => $r['contact'],
                            "address" => $r['address'],
                            
                        ]);
                    }
                }
    
                if(isset($request->sibling)){
                    DB::table('sibling_datas')->where('family_id', $family_id[0]->id)->delete();
                    foreach($request->sibling as $s){
                        sibling_data::create([
                            "family_id" => $family_id[0]->id,
                            "sibling_name" => $s['name'],
                            "sibling_birth" => date('Y-m-d H:i:s' ,strtotime($s['birhtday'])),
                            "sibling_occupation" => $s['occupation'],
                            "sibling_cp" => $s['cp'],
                            "sibling_address" => $s['address'],
                        ]);
                    }
                }
                if(isset($request->children)){
                    DB::table('children_datas')->where('family_id', $family_id[0]->id)->delete();
                    foreach($request->children as $c){
                        children_data::create([
                            "family_id" => $family_id[0]->id,
                            "name" => $c["name"],
                            "birthday" => date('Y-m-d H:i:s' ,strtotime($c['birthday'])),
                        ]);
                    }
                }
                if(isset($request->prometric)){
                    DB::table('prometric_datas')->where('personal_id', $request["personalid"])->delete();
                    foreach($request->prometric as $p){
                        prometric_data::create([
                            "personal_id" => $request["personalid"],
                            "name" => $p["name"],
                            "address" => $p["address"],
                            "from" => date('Y-m-d H:i:s' ,strtotime($p['from'])),
                            "until" => date('Y-m-d H:i:s' ,strtotime($p['until'])),
                            "certificate" => $p["certificate"],
                            "cert_until" => date('Y-m-d H:i:s' ,strtotime($p['certificate_until'])),
                        ]);
                    }
                }
                if(isset($request->jpl)){
                    DB::table('jpl_datas')->where('personal_id', $request["personalid"])->delete();
                    foreach($request->jpl as $j){
                        jpl_data::create([
                            "personal_id" => $request["personalid"],
                            "name" => $j["name"],
                            "address" => $j["address"],
                            "from" => date('Y-m-d H:i:s' ,strtotime($j['from'])),
                            "until" => date('Y-m-d H:i:s' ,strtotime($j['until'])),
                            "certificate" => $j["certificate"],
                            "cert_until" => date('Y-m-d H:i:s' ,strtotime($j['certificate_until'])),
                        ]);
                    }
                }
                $data = [
                    'id' => $request["personalid"],
                    'success' => true,
                    'msgType' => 'success',
                    'msgTitle' => 'Success!'
                ];
            }
            
        }
        DB::commit();

        
       } catch (\Throwable $th) {
        DB::rollBack();
        $data = [
            'id' => "",
            'success' => false,
            'msgType' => 'error',
            'msgTitle' => $th->getMessage()
        ];
       }
       return response()->json($data);
    }

    public function upload_image(Request $request){
        
        $data = [
			'msg' => 'Completing Transaction has failed.',
            'data' => [],
			'success' => true,
            'msgType' => 'warning',
            'msgTitle' => 'Failed!'
        ];

        try {
            $data = personal_data::find($request->id);
            // $data->gov_id_picture = $request->file('gov_id')->store('gov_id_pictures',"public");
            // $data->passport_id_picture =$request->file('passport_id')->store('passport_id_pictures',"public");
            // $data->id_picture=$request->file('picture')->store('1x1_pictures',"public");
             $data->gov_id_picture = file_get_contents($request->file('gov_id')->getPathname());
             $data->passport_id_picture = file_get_contents($request->file('passport_id')->getPathname());
             $data->id_picture= file_get_contents($request->file('picture')->getPathname());

            
            
            if($data->update()){
                $data = [
                    'msg' => 'The Biodata has been uploaded',
                    'data' => [],
                    'success' => true,
                    'msgType' => 'success',
                    'msgTitle' => 'Success!'
                ];
            }

            
            
        } catch (\Throwable $th) {
            $data = [
                'msg' => $th->getMessage(),
                'data' => [],
                'success' => false,
                'msgType' => 'error',
                'msgTitle' => 'Error!'
            ];
        }
        return response()->json($data);
    }
    public function get_code(Request $request){
       $data = DB::table("m_jobcodes")->where('IsDeleted',0)->select()->get();
       return $data;
    }
    public function get_categories(Request $request){
        $type = strtoupper($request->type);
        $data = DB::table('m_jobcategories')
        ->select('ID','JobType','Category')
        ->where("JobType",$type)
        ->where("IsDeleted",0)
        ->orderby("Category","asc")
        ->Get();
        return $data;
    }
    public function get_operations(Request $request){
        $data = DB::table('m_joboperations')
        ->select('ID','JobCategoriesID','Operation')
        ->where("JobCategoriesID",$request->ID)
        ->where("IsDeleted",0)
        ->orderby("Operation","asc")
        ->Get();
        return $data;
    }

    public function GetPersonalData(Request $request)
    {
        $personalid = $request->session()->get('personaldata');
        $personaldata = DB::table('personal_datas')
            ->where("id", $personalid)
            ->where("IsDeleted", 0)
            ->select()->Get();
        
        $personaldata[0]->date_birth = date('m/d/Y', strtotime(explode(" ", $personaldata[0]->date_birth)[0]));
        $personaldata[0]->issue_date = date('m/d/Y', strtotime(explode(" ", $personaldata[0]->issue_date)[0]));
        $personaldata[0]->expiry_date = date('m/d/Y', strtotime(explode(" ", $personaldata[0]->expiry_date)[0]));
        $personaldata[0]->id_picture = file_put_contents("test.jpg", $personaldata[0]->id_picture);
        $personaldata[0]->gov_id_picture = file_put_contents("test.jpg", $personaldata[0]->gov_id_picture);
        $personaldata[0]->passport_id_picture = file_put_contents("test.jpg", $personaldata[0]->passport_id_picture);
        $personaldata[0]->id_picture = base64_encode($personaldata[0]->id_picture);
        $personaldata[0]->gov_id_picture = base64_encode($personaldata[0]->gov_id_picture);
        $personaldata[0]->passport_id_picture = base64_encode($personaldata[0]->passport_id_picture);
        $educationaldata = DB::table('educational_datas')
            ->where("personal_id", $personalid)
            ->where("IsDeleted", 0)
            ->select()->Get();
        $educationaldata[0]->from_elem = date('m/d/Y', strtotime(explode(" ", $educationaldata[0]->from_elem)[0]));
        $educationaldata[0]->until_elem = date('m/d/Y', strtotime(explode(" ", $educationaldata[0]->until_elem)[0]));
        $educationaldata[0]->from_highschool = date('m/d/Y', strtotime(explode(" ", $educationaldata[0]->from_highschool)[0]));
        $educationaldata[0]->until_highschool = date('m/d/Y', strtotime(explode(" ", $educationaldata[0]->until_highschool)[0]));
        $educationaldata[0]->from_jp_lang = date('m/d/Y', strtotime(explode(" ", $educationaldata[0]->from_jp_lang)[0]));
        $educationaldata[0]->until_jp_lang = date('m/d/Y', strtotime(explode(" ", $educationaldata[0]->until_jp_lang)[0]));
        $educationaldata[0]->certificate_until_jp_lang = date('m/d/Y', strtotime(explode(" ", $educationaldata[0]->certificate_until_jp_lang)[0]));
        $educationaldata[0]->from_college = date('m/d/Y', strtotime(explode(" ", $educationaldata[0]->from_college)[0]));
        $educationaldata[0]->until_college = date('m/d/Y', strtotime(explode(" ", $educationaldata[0]->until_college)[0]));
        $educationaldata[0]->certificate_until_college = date('m/d/Y', strtotime(explode(" ", $educationaldata[0]->certificate_until_college)[0]));

        $vocationaldata = DB::table('vocational_datas')
            ->where("educational_id", $educationaldata[0]->id)
            ->where("IsDeleted", 0)
            ->select()->Get();

        for($i = 0; $i < COUNT($vocationaldata); $i++){
            $vocationaldata[$i]->certificate_until = date('m/d/Y', strtotime(explode(" ", $vocationaldata[$i]->certificate_until)[0]));
            $vocationaldata[$i]->from = date('m/d/Y', strtotime(explode(" ", $vocationaldata[$i]->from)[0]));
            $vocationaldata[$i]->until = date('m/d/Y', strtotime(explode(" ", $vocationaldata[$i]->until)[0]));
        }
        
        $employmentlocaldata = DB::table('local_emps')
            ->where("personal_id", $personalid)
            ->where("IsDeleted", 0)
            ->select()->Get();

        for($i = 0; $i < COUNT($employmentlocaldata); $i++){
            $employmentlocaldata[$i]->from = date('m/d/Y', strtotime(explode(" ", $employmentlocaldata[$i]->from)[0]));
            $employmentlocaldata[$i]->until = date('m/d/Y', strtotime(explode(" ", $employmentlocaldata[$i]->until)[0]));
        }
        
        $employmentabroaddata = DB::table('abroad_emps')
            ->where("personal_id", $personalid)
            ->where("IsDeleted", 0)
            ->select()->Get();

        for($i = 0; $i < COUNT($employmentabroaddata); $i++){
            $employmentabroaddata[$i]->from = date('m/d/Y', strtotime(explode(" ", $employmentabroaddata[$i]->from)[0]));
            $employmentabroaddata[$i]->until = date('m/d/Y', strtotime(explode(" ", $employmentabroaddata[$i]->until)[0]));
        }

        $familydata = DB::table('family_datas')
            ->where("personal_id", $personalid)
            ->where("IsDeleted", 0)
            ->select()->Get();
        $familydata[0]->father_birth = date('m/d/Y', strtotime(explode(" ", $familydata[0]->father_birth)[0]));
        $familydata[0]->mother_birth = date('m/d/Y', strtotime(explode(" ", $familydata[0]->mother_birth)[0]));
        $familydata[0]->spouse_birth = date('m/d/Y', strtotime(explode(" ", $familydata[0]->spouse_birth)[0]));
        $familydata[0]->when_japan = date('m/d/Y', strtotime(explode(" ", $familydata[0]->when_japan)[0]));
        $familydata[0]->when_applied_visa = date('m/d/Y', strtotime(explode(" ", $familydata[0]->when_applied_visa)[0]));

        $siblingdata = DB::table('sibling_datas')
            ->where("family_id", $familydata[0]->id)
            ->where("IsDeleted", 0)
            ->select()->Get();
        for($i = 0; $i < COUNT($siblingdata); $i++){
            $siblingdata[$i]->sibling_birth = date('m/d/Y', strtotime(explode(" ", $siblingdata[$i]->sibling_birth)[0]));
        }
        
        $childrendata = DB::table('children_datas')
            ->where("family_id", $familydata[0]->id)
            ->where("IsDeleted", 0)
            ->select()->Get();
        for($i = 0; $i < COUNT($childrendata); $i++){
            $childrendata[$i]->birthday = date('m/d/Y', strtotime(explode(" ", $childrendata[$i]->birthday)[0]));
        }

        $relativedata = DB::table('relative_datas')
            ->where("family_id", $familydata[0]->id)
            ->where("IsDeleted", 0)
            ->select()->Get();

        $data = [
            "personaldata" => $personaldata,
            "educationaldata" => $educationaldata,
            "vocationaldata" => $vocationaldata,
            "employmentlocaldata" => $employmentlocaldata,
            "employmentabroaddata" => $employmentabroaddata,
            "familydata" => $familydata,
            "siblingdata" => $siblingdata,
            "childrendata" => $childrendata,
            "relativedata" => $relativedata
        ];
        return $data;
    }
}
