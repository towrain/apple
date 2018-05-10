<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ngaqalogger;

use App\nga_q_aloggers;

use App\user;


use Illuminate\Support\Facades\DB;



use Illuminate\Support\Facades\Input;

class ngaqalogging extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("forms.ngaQAlogger");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return view("forms.NGACallLogger");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$action = new ngaQAlogger;
		
		$action->repname = Input::get("agentName");		
		$action->taskType = Input::get("workType");
		$action->portalid = Input::get("portalID");
		$action->rsp = Input::get("RSP");
		$action->total = Input::get("demo2");
		$action->notes = Input::get("QAnotes");
		//var_dump($action);
		$action->save();
		
       $variables = array(input::get("managerName"),Input::get("agentName"));

		//return redirect('/NGACallReporting')->with('data', $variables);
		return redirect('/ngaQAlogger')-> with('status',$variables);
									 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //echo Input::get('agentName')
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
	//and Repname = '".$request->agent."'
public function findRSP(request $request){
	$ps=DB::select(
							"SELECT 
							*
							FROM ngaticksheets
							where OrderID like '%".$request->portalid."%' ;
							"		
					);
		return $ps;
	}

public function submitNewQa(request $request){
	$ps3=DB::select(
					"
					INSERT INTO nga_q_aloggers (repname, taskType, portalid,rsp,total,notes)
					VALUES ('".$request->repname."','".$request->taskType."','".$request->portalid."','".$request->rsp."','".$request->total."','".$request->notes."');
					"		
					);
		return $ps3;
	}

public function findUserName2(request $request){
	$ps=DB::select(
							"SELECT 
							name
							FROM users
							where Manager = '".$request->manager."' and role_id = 5;
							"		
					);
		return $ps;
	}
#findTaskType
public function findTaskType(request $request){
	$ps2=DB::select(
				"SELECT 
				*
				FROM ngaworkreasons
				"		
					);
		return $ps2;
	}
#findQA
public function findQA(request $request){
	$ps2=DB::select(
				"SELECT 
				*
				FROM nga_q_aloggers
				where repname ='".$request->agent."' and created_at BETWEEN NOW() - INTERVAL 30 DAY AND NOW()
				"		
			);
		return $ps2;
	}	

#skillM

public function skillM(request $request){
	$ps2=DB::select(
			"SELECT 
			*
			FROM skillmatrix
			where repname ='".$request->agent."'
			"		
		);

	
	json_encode($ps2);
	//print_r($ps2);
	return $ps2;

}
	
}
