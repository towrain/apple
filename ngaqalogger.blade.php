@extends('layouts.app')

@section('content')

@if (Auth::check())

@if (session('status'))
	<div class="container">
<div class="alert alert-success">
    <strong>                           Success! </strong>
	      QA sheet has been submitted!
</div>
</div>
@endif


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>


<div class="container">
<form action="/ngaqalogger/store" method="POST">

<div class="form-group">
	 <label for="ManagerName">Manager Name:</label>
    <select  class="form-control " id="managerName" value = "managerName" name="managerName" aria-describedby="ManagerNamehelp" required onchange="">
	
	@if (session('status'))
	<option value=" 
	<?php $data3 = \Session::get('status'); 
	$selectedManager = $data3[0];
	
	echo $selectedManager;?>" selected>
	<?php $data3 = \Session::get('status'); 
	echo $selectedManager;?>
	</option>
	<!-- check manager name -->
		<option value="" disabled > -- Select Manager --</option>
		<option value="Courtney Lawson" > Courtney Lawson </option>
		<option value="Tracy Belcher" > Tracy Belcher </option>
		<option value="Mark Vince" > Mark Vince </option>
		<option value="Helen Hill" > Helen Hill </option>
	
	@else
		<option value="" disabled selected> -- Select Manager --</option>
		<option value="Courtney Lawson" > Courtney Lawson </option>
		<option value="Tracy Belcher" > Tracy Belcher </option>
		<option value="Mark Vince" > Mark Vince </option>
		<option value="Helen Hill" > Helen Hill </option>
	@endif
	
	<!--
	<option value="" disabled selected> -- Select Manager --</option>
		<option value="Courtney Lawson" > Courtney Lawson </option>
		<option value="Tracy Belcher" > Tracy Belcher </option>
		<option value="Mark Vince" > Mark Vince </option>
		<option value="Helen Hill" > Helen Hill </option>
	-->
	<!-- manager -->
	<!--
	@foreach($managerNames as $managerName)
                  <option value="{{$managerName->name}}">
                    {{$managerName->name}}
                  </option>
      @endforeach
    -->
	</select>	 
</div>


<hr>
<div class="form-group">

	 <label for="AgentName" class="agentName" style="text-align:center">Agent Name: </label>
	 
	
	 
    <select  class="userName w3-round-xlarge w3-light-grey" id="agentName" value = "agentName" name="agentName" aria-describedby="AgentNamehelp" onchange="myfunction4()" required>
		 @if (session('status'))
		<option value=" <?php $data3 = \Session::get('status'); echo $data3[1];?>" selected> <?php $data3 = \Session::get('status'); echo $data3[1]; ?></option>
		<option value="" > -- Select Agent Name --</option>
	@else
		<option value="" disabled selected> -- Select Agent Name -- </option>
	@endif
	</select>
		
</div>

<hr>



<div class="container">
  <h2>Coaching Sheet</h2>
  <p>For QA :</p> 
  <h6> Number of QA order has been completed for 
  <label id="aNmeas"> Agent </label>
  </h6> 
  <script>
  function myfunction4(){
	  var x = document.getElementById("agentName").value;
	  document.getElementById("aNmeas").innerHTML = x;
  }
  </script>
  <br>

  <div id="myName" class="myName" style="text-align:center"> 
 
  </div>
  
  
  
  <!-- ajaxa code below -->
  
 <script type ="text/javascript">
		$(document).ready(function(){
			//may need to change to class name ????
			$(document).on('change','.form-control',function(){
				//console.log('its change $$$$$$$$$');
				//this refer the thing it called it
				var manager_id=$(this).val();
				//console.log(manager_id);
				
				var div=$(this).parent().parent();
				var op=" ";
				$.ajax({
					type:'get',	
					url:'{!!URL::to('findUserName')!!}',
					data:{'name':manager_id},
					
					success:function(data){

						console.log('success');
						console.log(data);
						console.log(data.length);
						
						op+='<option value="0" selected disable> -- Select Agent Name --</option>';
						
						for(var i=0;i<data.length;i++){
							
							op+='<option value="'+data[i].name+'">'+data[i].name+'</option>';
						}
						div.find('.userName').html(" ");
						div.find('.userName').append(op);
					},
					
					error:function(){
						
					}
				});
				
			});
			
			// below for portal id  
			$(document).on('change','.userName',function(){
				
				console.log('this is for portal id look up according to different agent name');
				
				var userID=$(this).val();
				
				console.log(userID);
				
				var a=$(this).parent().parent();//maybe worry ????
				
				var b=$(this);
				
				var op=" ";
				$.ajax({
					type:'get',	
					url:'{!!URL::to('findPortal')!!}',
					data:{'userName':userID},
					dataType:'json',//return data will be json
					success:function(data){
						
						op = data;
						a.find('.myName').html(" ");
						a.find('.myName').append(op);
						
						//a.find('.myName').val(data.length)
					},
					
					error:function(){
						
					}
				});
			});
			
			
			
		});
</script>
 
  
 
  <hr>
  
  <table class="table table-bordered w3-striped">
    <thead class="w3-blue">
      <tr>
        <th>Task Type</th>
        <th>Portal ID</th>
		<th>RSP</th>
		<th>Comms to RSP</th>
		<th>Actions</th>
		<th>Total</th>
		<th>Notes</th>
		
      </tr>
    </thead>
	
    <tbody>
      <tr>
	  
        <td>
		<select class="form-control" id="workType"  name="workType" aria-describedby="RSPhelp" required>
	<option value="" disabled selected>Select Work Type</option>
	
	<?php $reason = 
	DB::select(			"SELECT 
							*
							FROM ngaworkreasons 
							");

	foreach ($reason as $reasonName){
			echo '<option>'.$reasonName -> reason.'</option>';
	};						

?>
	<option value="MCI">MCI</option>
	
	</select>
	</td>
	
	<td><input type="text" id="portalID" name="portalID" size="10" maxlength="13" placeholder="Portal ID" class="form-control"></td>
        
		<td>
	<select class="form-control" id="RSP"  name="RSP"aria-describedby="RSPhelp" required>
	<option value="" disabled selected>Select RSP</option>
	<?php $rsp = 
	DB::select(			"SELECT 
							*
							FROM rsps 
							");

	foreach ($rsp as $rspName){
			echo '<option>'.$rspName -> name.'</option>';		
	};						

?>

	</select>
	</td>
		
		<td>  
<table class="table-condensed">
   <tr >
     <td>Lvl Of Info : 
	 <select type="text" name="LvlOfInfor" value="" id="a" onchange="myFunction()" class="form-control">
	  <option value="0" >0</option>
	  <option value="1" >1</option>
	  <option value="2" >2</option>
	  <option value="3" >3</option>
	  <option value="4" >4</option>
	  <option value="5" >5</option>
    </select>
	</td>
	</tr>
	<tr>
     <td>Personality : <select type="text" name="Personality" id="b" onchange="myFunction()" value="" class="form-control">
	  <option value="0" >0</option>
	  <option value="1" >1</option>
	  <option value="2" >2</option>
	  <option value="3" >3</option>
	  <option value="4" >4</option>
	  <option value="5" >5</option>
    </select> </td>
	</tr>
	<tr>
	 <td>Tone : <select type="text" name="Tone" value="" id="c" onchange="myFunction()" class="form-control">
	  <option value="0" >0</option>
	  <option value="1" >1</option>
	  <option value="2" >2</option>
	  <option value="3" >3</option>
	  <option value="4" >4</option>
	  <option value="5" >5</option>
    </select></td>
   </tr>
   <tr>
	 <td>Accuracy : <select type="text" name="Accuracy" id="d" value="" onchange="myFunction()" class="form-control">
	  <option value="0" >0</option>
	  <option value="1" >1</option>
	  <option value="2" >2</option>
	  <option value="3" >3</option>
	  <option value="4" >4</option>
	  <option value="5" >5</option>
    </select>
	</td>

   </tr>
   
   <tr>
   
	 <td>Pct / Gram : <select type="text" name="Pct" value="" id="e" onchange="myFunction()" class="form-control">
	  <option value="0" >0</option>
	  <option value="1" >1</option>
	  <option value="2" >2</option>
	  <option value="3" >3</option>
	  <option value="4" >4</option>
	  <option value="5" >5</option>
    </select></td>
   </tr>
   
   
   <td>
   
   Score: <output id="demo" name="x"  type="text" onchange="myFunction3()">
   <script>
            function myFunction() {
                var a = document.getElementById("a").value;
                var b = document.getElementById("b").value;
				var c = document.getElementById("c").value;
				var d = document.getElementById("d").value;
				var e = document.getElementById("e").value;
                var f = Number(a)+Number(b)+ Number(c) +Number(d)+Number(e);
                var z = f / 5 *20
				      
					  if (z > 90){
                
                   document.getElementById("demo").style.backgroundColor = '#99C262';
                
                } else if (z<=80){ 
                			document.getElementById("demo").style.backgroundColor = '#FF0000';
                		}
					else if (80<z<=90){ 
                			document.getElementById("demo").style.backgroundColor = '#FFF000';
                		}
						
				document.getElementById("demo").innerHTML = z;
				
				myFunction3()
            }
        
      </script>
	  </output>
	  
   </td>
   
   </table></td>
   
  
   
   
   <td>  
		<table class="table-condensed">
   <tr>
     <td>Investigation: <select type="text" name="Investigateion" id="a1" value="" onchange="myFunction2()" class="form-control">
	
	  <option value="0">0</option>
	  <option value="1">1</option>
	  <option value="2">2</option>
	  <option value="3">3</option>
	  <option value="4">4</option>
	  <option value="5">5</option>
    </select>
	</td>
	</tr>
	<tr>
     <td>Process : <select type="text" name="Process" value="" id="b1" onchange="myFunction2()" class="form-control">
	  <option value="0">0</option>
	  <option value="1">1</option>
	  <option value="2">2</option>
	  <option value="3">3</option>
	  <option value="4">4</option>
	  <option value="5">5</option>
    </select> </td>
	</tr>
	<tr>
	 <td>ICMS Notes : <select type="text" name="ICMS" value="" id="c1" onchange="myFunction2()" class="form-control">
	  <option value="0">0</option>
	  <option value="1">1</option>
	  <option value="2">2</option>
	  <option value="3">3</option>
	  <option value="4">4</option>
	  <option value="5">5</option>
    </select></td>
   </tr>
   <tr>
	 <td>Action Taken : <select type="text" name="Action" value="" id="d1" onchange="myFunction2()" class="form-control">
	  <option value="0">0</option>
	  <option value="1">1</option>
	  <option value="2">2</option>
	  <option value="3">3</option>
	  <option value="4">4</option>
	  <option value="5">5</option>
    </select></td>
   </tr>
   <tr>
	 <td>System Notes : <select type="text" name="System" value="" id="e1" onchange="myFunction2()" class="form-control">
	  <option value="0">0</option>
	  <option value="1">1</option>
	  <option value="2">2</option>
	  <option value="3">3</option>
	  <option value="4">4</option>
	  <option value="5">5</option>
    </select></td>
   </tr>
 
   
   <td>
   
   Score: <output id="demo1" name="x"  type="text" >
   <script>
            function myFunction2() {
                var a = document.getElementById("a1").value;
                var b = document.getElementById("b1").value;
				var c = document.getElementById("c1").value;
				var d = document.getElementById("d1").value;
				var e = document.getElementById("e1").value;
                var f = Number(a)+Number(b)+ Number(c) +Number(d)+Number(e);
                
				var z = f / 5 *20 
				
				      if (z > 90){
                
                   document.getElementById("demo1").style.backgroundColor = '#99C262';
                
                } else if (z<=80){ 
                			document.getElementById("demo1").style.backgroundColor = '#FF0000';
                		}
						
					else if (80<z<=90){ 
                			document.getElementById("demo1").style.backgroundColor = '#FFF000';
                		}	
						
				
				document.getElementById("demo1").innerHTML = z;
				
				myFunction3()
					
					
					
            }

      </script>
	  
	  </output>
	  
   </td>
   
   
   </table>
   
     
   </td>
   
		<td><input size="1" type="text" id="demo2" name="demo2" class="form-control" readonly required></td>
      <script>
            function myFunction3() {
                var a = document.getElementById("demo").innerHTML;
                var b = document.getElementById("demo1").innerHTML;
				
                var c = Number(a)+Number(b);
				var d = c/2;
				
				if (d > 90){
                
                   document.getElementById("demo2").style.backgroundColor = '#99C262';
                
                } else if (d<=80){ 
                			document.getElementById("demo2").style.backgroundColor = '#FF0000';
                		}
						
					else if (80<d<=90){ 
                			document.getElementById("demo2").style.backgroundColor = '#FFF000';
                		}	
				
				
				document.getElementById("demo2").value = d + "%";
				
            }

      </script>
	  
		
		<td ><textarea  id = "QAnotes" name="QAnotes" rows="9" cols="10" class="form-control"></textarea></td>
	
	</tr>
	
	
	
	  
    </tbody>
  </table>
</div>



<br>
<div class="form-group">

    <input type="submit" class="form-control w3-btn w3-border w3-hover-blue" id="submitbtn" >

</div>

<div>
<input type="hidden" name="_token" value="{{csrf_token()}}">
<input type="hidden" name="username" value="{{ Auth::user()->name }}">
</div>
</form>
</div>

@else
	<div class="container" align="center">
	<p> Your must be logged in to view this menu</p>
	</div>
@endif


@endsection