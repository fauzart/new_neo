	// Using font-awesome icons for datetimepicker
	  $.extend(true, $.fn.datetimepicker.defaults, {
		icons: {
		  time: 'fa fa-clock-o',
		  date: 'fa fa-calendar',
		  up: 'fa fa-angle-up',
		  down: 'fa fa-angle-down',
		  previous: 'fa fa-angle-left',
		  next: 'fa fa-angle-right',
		  today: 'fa fa-calendar-check-o',
		  clear: 'fa fa-calendar-o',
		  close: 'fa fa-calendar-times-o'
		}
	  });
	  
	/*hack jquery validate*/
	$.validator.setDefaults({
	  highlight: function(element) {
		/*$(element).closest('.form-group').addClass('has-error');
		$(element).closest('.form-group').removeClass(
		  'has-success has-feedback').addClass('has-error has-feedback');
		$(element).closest('.form-group').find('i.fa').remove();
		$(element).closest('.form-group').append(
		  '<i class="fa fa-exclamation fa-lg form-control-feedback"></i>');*/
		//$(element).removeClass("is-valid");
		$(element).addClass("is-invalid");
		if($(element).hasClass("selectpicker")){
			//$(element).parent().removeClass("is-valid");
			$(element).parent().addClass("is-invalid");
		}
	  },
	  unhighlight: function(element) {
		/*$(element).closest('.form-group').removeClass('has-error');
		$(element).closest('.form-group').addClass('has-success');
		$(element).closest('.form-group').find('i.fa').remove();
		$(element).closest('.control-label').append(
		  '<i class="fa fa-check fa-lg form-control-feedback"></i>');*/
		$(element).removeClass("is-invalid");
		//$(element).addClass("is-valid");
		if($(element).hasClass("selectpicker")){
			$(element).parent().removeClass("is-invalid");
			//$(element).parent().addClass("is-valid");
		}
	  },
	  errorElement: 'span',
	  errorClass: 'error',
	  errorPlacement: function(error, element) {
		if (element.parent('.input-group').length) {
		  //error.insertBefore(element.parent());
		} else {
		  //error.insertBefore(element);
		}
	  }
	});
	$.validator.addMethod("equals", function(value, element, param) {
		//console.log(value);
		//console.log(param);
	  return this.optional(element) || $.inArray(value,param) != -1;
	}, "Please specify a different value");


	
//functions -->

function log(s){
	console.log(s);
}

function page_ready(){
	//$("."+page).addClass("active");
	
	//notify();
}

function alrt(msg,typ='success',ttl=''){
	$("#modal_process").modal("hide");
	swal({html: true, title: ttl, text: msg, icon: typ});
}

function dttbl_buttons(loc='#mytbl_wrapper .col-md-6:eq(1)'){
	mytbl.buttons().container().appendTo( loc );
	$(loc).addClass("text-right");
}

function commaSeparateNumber(val) {
    while (/(\d+)(\d{3})/.test(val.toString())) {
        val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
    }
    return val;
}

function timepicker(){
	$('.timepicker').datetimepicker({
                    format: 'HH:mm:ss',
					showTodayButton: true,
					showClear: true,
					showClose: true
                });
}
function datepicker(){
	$('.datepicker').datetimepicker({
                    format: 'YYYY-MM-DD',
					showTodayButton: true,
					showClear: true,
					showClose: true
                });
}
function selectpicker(init=false){
	$(".selectpicker").selectpicker("refresh");
	if(init){
		$('.selectpicker').on('change', function () {
			$(this).valid();
		});
	}
}

function getMultipleValues(theid,sep=',',fix=''){
	var ret="";
	var arr=$(theid).val();
	if(arr){
		for(var i=0;i<arr.length;i++){
			if(ret==""){
				ret=arr[i];
			}else{
				ret=ret+sep+arr[i];
			}
		}
	}
	return fix+ret+fix;
}


/*to do notify: get data and show, call timer*/
function notify(){
var isi='';

isi+=''+
'<a href="#" class="dropdown-item d-flex pb-3">'+
'	<div class="notifyimg bg-danger">'+ //bgxxx
'		<i class="fa fa-server"></i>'+ //fa fa-server  / fe fe-hard-drive
'	</div>'+
'	<div>'+
'		<div>Message Sent.</div>'+
'		<div class="small text-muted">3 hours ago</div>'+
'	</div>'+
'</a>';

//all msgs link
//isi+='<a href="#" class="dropdown-item text-center message"> <strong>See All Messages <i class="fa fa-angle-right"></i></strong></a>';

$(".pulse").show();
$("#isilonceng").html(isi);
$("#lonceng").show();

}

function modal(ttl='Processing',body='Please wait ...'){
	$("#process_title").html(ttl);
	$("#process_result").html(body);
	$("#modal_process").modal('show');
}

function openForm(q='',id=0,f='#myf',fid="#rowid"){
	$("#modal_form").modal("show");
	jvalidate.resetForm();
	$(".is-invalid").removeClass("is-invalid");
	$(".is-valid").removeClass("is-valid");
	$(fid).val(id);
	$(f).find("input[type=text], input[type=password], input[type=file], textarea, select").val("");
	$(f).find("input[type=checkbox]").prop('checked',false);
	
	if(id==0){
		$("#bdel").hide();
		//datepicker();
		selectpicker();
	}else{
		$("#bdel").show();
		//modal();
		$.ajax({
			type: 'POST',
			url: 'dataget'+ext,
			data: {q:q,id:id},
			success: function(data){
				var json = JSON.parse(data);
				if(json['code']=='200'){
					$.each(json['msgs'][0],function (key,val){
						$('#'+key).val(val);
					});
					//datepicker();
					selectpicker();
					$("#modal_process").modal("hide");
				}else{
					setTimeout(function(){$(".modal_form").modal("hide")},500);
					//modal(json['ttl'],json['msgs']);
					alrt(json['msgs'],'error',json['ttl']);
				}
			},
			error: function(xhr){
				setTimeout(function(){$(".modal_form").modal("hide")},500);
				//modal('Error','Please check your connection');
				alrt('Please check your connection','error','Error');
			}
		});
	}
}
var deleteForm='#myf';
var saveFlag='#sv';
function confirmDelete(f='#myf',s='#sv'){
	deleteForm=f;
	saveFlag=s;
	//$("#modal_delete").modal("show");
	swal({
	  title: "Are you sure?",
	  text: "Data will be deleted permanently",
	  icon: "warning",
	  buttons: true,
	  dangerMode: true,
	})
	.then((willDelete) => {
	  if (willDelete) {
		deleteData();
	  }
	});
}
function deleteData(){
	//$("#modal_delete").modal("hide");
	sendDataFile("DEL",deleteForm,saveFlag);
}
function saveData(f="#myf",fsv="#sv",fid="#rowid"){
	if($(f).valid()){
		if($(fid).val()=="0"){
			sendDataFile("NEW",f,fsv);
		}else{
			sendDataFile("UPD",f,fsv);
		}
	}
}
function sendDataFile(sv,f='#myf',fsv="#sv"){
	//modal();
	$(fsv).val(sv);
	
	var url='datasave'+ext;
	var mtd='POST';
	var frmdata=new FormData($(f)[0]);
	
	//alert(frmdata);
	
	$.ajax({
		type: mtd,
		url: url,
		data: frmdata,
		cache: false,
		contentType: false,
		processData: false,
		success: function(data){
			var json = JSON.parse(data);
			//modal(json['ttl'],json['msgs']);
			if(json['code']=='200'){
				$(".modal_form").modal("hide");
				if(typeof(reloadtbl)=='function') reloadtbl();
				alrt(json['msgs'],'success',json['ttl']);
			}else{
				alrt(json['msgs'],'error',json['ttl']);
			}
		},
		error: function(xhr){
			//modal('Error','Please check your connection');
			alrt('Please check your connection','error','Error');
		}
	});
};

function resetAvatar(){
	$.ajax({
		type: 'POST',
		url: 'datasave'+ext,
		data: {mnu:'ravatar'},
		success: function(data){
			var json = JSON.parse(data);
			alrt(json['msgs'],'error',json['ttl']);
		},
		error: function(xhr){
			//modal('Error','Please check your connection');
			alrt('Could not execute command '+q,'error','Error');
		}
	});
}

function exec_command(q,h,c,v='',o=''){
	$(r).hide();
	$(".ldr").show();
	var url='/cgi-bin/'+q+'.sh';
	var data="";
	var r=".hasil";
	
	switch(q){
		case 'ping' : data={h:h,c:c}; break;
		case 'trace' : data={h:h,c:c}; break;
		case 'snmp' : data={h:h,c:c,v:v,o:o}; break;
		case 'scan' : data={h:h,c:c}; break;
	}
	
	if(data=="")	{
		alrt('Invalid command '+q,'error','Error');
		$(".ldr").hide();
	}else{
		$.ajax({
			type: 'GET',
			url: url,
			data: data,
			success: function(data){
				$(".ldr").hide();
				$(r).html('<pre>'+data+'</pre>').show();
			},
			error: function(xhr){
				//modal('Error','Please check your connection');
				$(".ldr").hide();
				alrt('Could not execute command '+q,'error','Error');
			}
		});
	}
}

function get_content(url,data,ldr,target,mthd='POST'){
	$(target).hide();
	$(ldr).show();
	$.ajax({
		type: mthd,
		url: url,
		data: data,
		success: function(result){
			$(ldr).hide();
			$(target).html(result).show();
		},
		error: function(xhr){
			$(ldr).hide();
			alrt('Error loading content','error','Error');
		}
	});
}

function getData(q,lnk='dataget',id=0,html=true,selector="."){
	$.ajax({
		type: 'POST',
		url: lnk+ext,
		data: {q:q,id:id},
		success: function(data){
			var json = JSON.parse(data);
			if(json['code']=='200'){
				$.each(json['msgs'][0],function (key,val){
					if(html) {
						$(selector+key).html(val);
					}else{
						$(selector+key).val(val);
					}
				});
			}else{
				log(json['msgs']);
			}
		},
		error: function(xhr){
			log('Please check your connection'+xhr);
		}
	});
}