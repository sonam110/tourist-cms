$(function() {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
});
$(document).on('change','#roles',function() {  
   var roles = $('#roles').val();
   if(roles == 'aggregator'){
      $('#is_show').show();
   }
   else {
       $('#is_show').hide();
   }
   if(roles != 'client'){
      $('#designation-div').show();
   }
   else {
       $('#designation-div').hide();
       $('#designation').val('');
   }
});
var typingTimer;
var doneTypingInterval = 500;
$('body').tooltip({
    selector: '[data-toggle="tooltip"]'
});
$('.addMorenumber').click(function() {
    $('.blockNumber:last').after('<div class="blockNumber"><div class="form-group"> <div class="input-group"> <input id="number" class="form-control" placeholder="Mobile Number" autocomplete="off" required="required" name="number[]" type="number" value=""> <span class="input-group-append"> <button class="btn btn-danger removeNumber" type="button" data-toggle="tooltip" data-placement="top" title="Remove this numbers"><i class="fa fa-minus"></i></button> </span> </div></div></div>'); 
});
$('.numberBox').on('click','.removeNumber',function() {
  $(this).tooltip("hide");
  $(this).parents(".blockNumber").remove();
});

$('.numberBox1').on('click','.removeNumber1',function() {
  $(this).parents(".blockNumber1").remove();
});


$(document).on('click','.remove',function() {
      $(this).tooltip("hide");
      $(this).parent().remove();
  }); 

$(document).on('click','#enableContactForm',function() {
  if ($(this).is(":checked")) {
    $("#RecieverEmail").show();
  } else {
    $("#RecieverEmail").hide();
  }
});
$(document).on('click','.addMorecnumber',function() {
    $('.blockcNumber:last').after('<div class="blockcNumber"><div class="form-group">  <div class="input-group"> <input type="number" name="contactNumbers[]" id="contactNumbers" class="form-control" placeholder="Contact Number" > <span class="input-group-addon btn-danger removecNumber tooltips" data-placement="top" title="Remove"><i class="fa fa-minus" style="cursor"></i></span> </div> </div></div>'); 
});
$(document).on('click','.removecNumber',function() {
  $(this).tooltip("hide");
  $(this).parents(".blockcNumber").remove();
});
$(document).on('click','.addMorEmail',function() {
    $('.blockEmail:last').after('<div class="blockEmail"><div class="form-group">  <div class="input-group"> <input type="email" name="contactEmails[]" id="contactEmails" class="form-control" placeholder="Email" > <span class="input-group-addon btn-danger removeEmail tooltips" data-placement="top" title="Remove"><i class="fa fa-minus" style="cursor"></i></span> </div> </div></div>'); 
});
$(document).on('click','.removeEmail',function() {
  $(this).tooltip("hide");
  $(this).parents(".blockEmail").remove();
});
$(document).on('click','.addMoreKeyword',function() {
    $('.blockKeyword:last').after('<div class="blockKeyword"><div class="form-group">  <div class="input-group"> <input type="text" name="keywords[]" id="keywords" class="form-control" placeholder="keywords" > <span class="input-group-addon btn-danger removeKeyword tooltips" data-placement="top" title="Remove"><i class="fa fa-minus" style="cursor"></i></span> </div> </div></div>'); 
});
$(document).on('click','.removeKeyword',function() {
  $(this).tooltip("hide");
  $(this).parents(".blockKeyword").remove();
});
function getForm(tabname,id){
  $.ajax({
    type: 'POST',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: "getFormTab",
    data:'tabname='+tabname+'&id='+id,
    success:function(info){
      $('#showForm').html(info);
      
    }
  });

}
function getForms(tabname){
var id=document.getElementById('myid').value;
  $.ajax({
    type: 'POST',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: "getFormTab",
    data:'tabname='+tabname+'&id='+id,
    success:function(info){
      $('#showForm1').html(info);
      
    }
  });

}
function getNewSite(){
    id="";
    $.ajax({
      type: 'POST',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
        url: "getNew",
        data:'id='+id,
        success:function(info){
        $("#newSite").html(info); 
      }
    })
  }
function getsite(id) { 
  $.ajax({
    type: 'POST',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: "getSiteinfo",
    data:'id='+id,
    success:function(info){
    $("#newSite").html(info); 
   
    
      
    }
  })
 
  }

$(document).on("click","#addForm button",function(e){
  e.preventDefault();
  var form = $("#addForm");
  var formData = new FormData(form[0]);

  $.ajax({
    url: form.prop('action'),
    type: 'POST',
    data: formData,
      error: function(xhr, status, error) 
        {
         
          $.each(xhr.responseJSON.errors, function (key, item) 
          {
            $("#errors").append("<span class='invalid-feedback'>"+item+"</span>")
          });

        },

    success:function(result){
      var obj = JSON.parse(result);
      var msg =obj['message'];
      if(obj['result'] == "success"){
        toastr.success(msg);
        $('#myid').val(obj['data'])
      }
      if(obj['result'] == "error"){
        $('#myid').val(obj['data'])
        toastr.success(msg);

      }
    },
    cache: false,
    contentType: false,
    processData: false
  });
});
// Add Dlrcode
$(document).on("click", "#addDlrcode", function () {
  $('#addCodeForm').hide();
  $('.loading').show();
  var id = $(this).data('id');
  var type = $(this).data('type');
  var uuid = $(this).data('uuid');
  $.ajax({
    url: appurl+"dlrcodeForm",
    type: 'POST',
    data:{id:id,type:type,uuid:uuid}, 
    success:function(info){
      $('.loading').hide();
      $('#addCodeForm').html(info);
      $('#addCodeForm').show();
    }
  });
});
// Copy Dlrcode
$(document).on("click", "#copyDlrcode", function () {
  $('#copyCodeForm').hide();
  $('.loading').show();
  var id = $(this).data('id');
  var type = $(this).data('type');
  var uuid = $(this).data('uuid');
  var kannelapi = $(this).data('kannelapi');
  $.ajax({
    url: appurl+"copyCodeForm",
    type: 'POST',
    data:{id:id,type:type,uuid:uuid,kannelapi:kannelapi}, 
    success:function(info){
      $('.loading').hide();
      $('#copyCodeForm').html(info);
      $('#copyCodeForm').show();
    }
  });
});


$("#current_balance").bind("keyup change", function(e) {
  var route_type      = $('#route_type').val();
  var current_balance = $('#current_balance').val();
  var userId          = $('#userId').val();
  $.ajax({
    url: appurl+"checkCredit",
    type: 'POST',
    data: 'current_balance='+current_balance+'&route_type='+route_type+'&userId='+userId,  
    success:function(info){
      $('#error').html(info);
    }
  });
})
// assigne Sender id
$(document).on("click", "#assigneSenderid", function () {
  $('#senderId').hide();
  $('.loading').show();
  var id = '';
  $.ajax({
    url: appurl+"assigneSenderid",
    type: 'POST',
    data: "id="+id,  
    success:function(info){
      $('.loading').hide();
      $('#senderId').html(info);
      $('#senderId').show();
    }
  });
});

$(document).on("click","#assigneFormBtn",function(e){
  e.preventDefault();
  var form = $("#assigneForm");
  var formData = new FormData(form[0]);
  
  $.ajax({
    url: form.prop('action'),
    type: 'POST',
    data: formData,
      error: function(xhr, status, error) 
        {
        
          $.each(xhr.responseJSON.errors, function (key, item) 
          {
            toastr.error(item);
          });

        },

    success:function(result){
      var obj = JSON.parse(result);
      var msg =obj['message'];
      if(obj['result'] == "success"){
        toastr.success(msg);
      }
      if(obj['result'] == "error"){
        toastr.success(msg);
      }
    setTimeout(function() {$('#assigneSenderids').modal('hide');}, 200);
    },
    cache: false,
    contentType: false,
    processData: false


  });

});
$(document).ready(function(){
$("#campaign").bind("keyup click", function() {
        var query = $(this).val();
         $.ajax({
          url:appurl+"autocomplete-fetch",
          method:"POST",
          data:{query:query},
          success:function(data){
           $('#myList').fadeIn();  
           $('#myList').html(data);
          }
         });
        
    });

    $(document).on('click', '#camp', function(){  
        $('#campaign').val($(this).text());  
        $('#myList').fadeOut();  
    });  

});
$(document).ready(function(){
 $('#sender_id').keyup(function(){ 
        $('#errormsg').hide();
        var query = $(this).val();
        if(query != '')
        {
         $.ajax({
          url:appurl+"senderid-fetch",
          method:"POST",
          data:{query:query},
          success:function(data){
           $('#myList').fadeIn();  
           $('#myList').html(data);
          }
         });
        }
    });
  $(document).on('change', '#sender_id', function(){  
       checkSenderid();
    });
  function checkSenderid() {
    $('#errormsg').hide();
        var query = $('#sender_id').val();
        if(query.length == '6')
        {
         $.ajax({
          url:appurl+"check-senderid-special",
          method:"POST",
          data:{query:query},
          success:function(data){
            //console.log(data);
            if(data == '1') {
 
            }
            else 
            {
              $('#errormsg').show();
              $('#sender_id').val('');
               toastr.error('This Sender id '+query+' do not used');
            }
             
          }
         });
        }

  }

    $(document).on('click', '#sender', function(){  
        $('#sender_id').val($(this).text());  
        $('#text1').text($(this).text().length);
        $('#myList').fadeOut(); 
        checkSenderid(); 
    });  

});

/*$('#sender_id').keyup(function(){
var value = $('#sender_id').text();
var regex = /\s+/gi;
var wordCount = value.trim().split(regex).length;
$('#text1').html(wordCount);
});*/

$('#sender_id').on('keyup', function(){
    var letters = $(this).val().length;
    $('#text1').text(letters);
    // limit message
    if(letters>6){
        $(this).val(content);
         toastr.error('Sender id no more than 6 letters, please!');
    } else {    
        content = $(this).val();
    }
});

$(document).ready(function(){
  $("#contacts, #custom-send-sms").bind("click", function() {
    var type = $(this).data('type');
    if($("#myContact").length>0)
    {
     $.ajax({
      url:appurl+"contact-fetch",
      method:"POST",
      data:'',
      success:function(data){
        $('#myContact').fadeIn();  
        $('#custom-sms').hide();  
        $('#myContact').html(data);
        $('#sms_type').val(type);
        var e = document.getElementById("myContact");
        e.id = "myContact-new";
        
      }
     });
   }
 });

$(document).ready(function(){
  $("#custom-send-sms").bind("click", function() {
    $('#ratio_percent_set_sec').hide();
    $('#ratio_percent_set').val('0');
  })
});
  
   /* $(document).on('click', '#contacts', function(){  
        $('#contacts').val($(this).text());  
        $('#myList').fadeOut();  
    });  */

});

$(document).on('change', '#files', function(){  
    $('#contactuploaddiv').show();
    $('#contactsdiv').hide();
    $('.input-loader').html('<div class="spinner1"> <div class="double-bounce1"></div> <div class="double-bounce2"></div> </div>');
    var fd = new FormData();
    fd.append('file', this.files[0]); // since this is your file input
    $.ajax({
        url: appurl+"contact-upload",
        type: "post",
        processData: false, // important
        contentType: false, // important
        data: fd,
        success: function(text) {
            $('#contactuploaddiv').hide();
            $('#contactsdiv').show();
            $('#contactsdiv').html(text);
            $("#contacts").off("click");
            $("#file").val('');
            $('.input-loader').text('Choose file');
        },
        error: function(xhr, status, error) 
        {
          $.each(xhr.responseJSON.errors, function (key, item) 
          {
            toastr.error(item);
          });
        },
    });
});

$('#sender_id').bind('keyup blur',function(){ 
  var node = $(this);
  node.val(node.val().replace(/\s+/,''));
  $('#text1').text(node.val().length); 
});

$('#contacts').bind('keyup blur',function(){ 
    var node = $(this);
    node.val(node.val().replace(/[^0-9,\s]+/g,'') );   
});

function updateCount() {
    var x = $(".mygroup:checked").length;
    document.getElementById("group").innerHTML = x;
     $('#totalgroup').val(x);
};
/*$('#contacts').bind('keyup',function(){ 
    countofnums = 0;
    var count = $('textarea').val().split(/[\ \n\r\;\:\,]+/).length;
      document.getElementById("numbers").innerHTML = count;
});*/

/*$("#contacts").on("keyup change input paste", function(e) {
  var content = $("#contacts").val();
  var words = content.split(",").filter(item => item);
  var num_words = words.length;
  document.getElementById("numbers").innerHTML = num_words;
  $('#totalcontact').val(num_words);
});*/

$(document).ready(function(){
 $(".message").on("keyup click input paste", function(e) {
    clearTimeout(typingTimer);
    var query = $(this).val();
    typingTimer = setTimeout(function(){
        $.ajax({
          url:appurl+"template-fetch",
          method:"POST",
          data:{query:query},
          success:function(data){
          $('#myList').fadeIn();
          $('#myList').html(data);
          }
         });
      }, doneTypingInterval);
    });
});
$(document).on('click', '#temp', function(){  
    $('.message').val($(this).text());  
    $('#myList').fadeOut();  
     messageCount();
}); 
 $(document).on('click', '.schedule', function(){  
        $('#scheduleButton').hide();   
        $('#scheduleDiv').show();   
        $('#schedulebut').show();   
  });
  $(document).on('click', '.backschedule', function(){  
        $('#scheduleButton').show();   
        $('#scheduleDiv').hide();   
        $('#schedulebut').hide();
        $('#schedule_date').val('');
        $('#hours').prepend('<option selected></option>').select2({
            placeholder: "HR",
            allowClear: true
        });
        $('#min').prepend('<option selected></option>').select2({
            placeholder: "MIN",
            allowClear: true
        }); 
  }); 
  $(".message").on("keyup change input paste", function(e) {
    var messageType = $("#message_type").val();
    var word = $(this).val();
    var numwords = word.length;
    document.getElementById("counttext").innerHTML = numwords;
    $('#totalmessagecount').val(numwords);
    if(messageType=='English')
    {
      if (numwords > 160) {
          $('#message-count-credit').addClass("changeColour");
      } else {
          $('#message-count-credit').removeClass("changeColour");
      }
      if (parseInt(numwords) <= 306) {
        var credit = parseInt(parseInt(numwords) / 160);
        if (parseInt(numwords) % 160 != 0)
            credit = credit + 1;
      } else {
          var credit = parseInt(parseInt(numwords) / 153);
          if (parseInt(credit) % 153 != 0)
              credit = credit + 1;
      }
      $('#credits_span').html(credit);
    }
    else
    {
      if (numwords > 70) {
          $('#message-count-credit').addClass("changeColour");
      } else {
          $('#message-count-credit').removeClass("changeColour");
      }
      var credit;
      if (parseInt(numwords) <= 70)
          credit = 1;
      else {
          credit = parseInt(parseInt(numwords) / 67);
          if (parseInt(numwords) % 67 != 0)
              credit = credit + 1;
      }
      $('#credits_span').html(credit);
    }
  });
  function messageCount(){
    var words = $('.message').val();
    var messageType = $("#message_type").val();
    var numwords = words.length;
    document.getElementById("counttext").innerHTML = numwords;
    $('#totalmessagecount').val(numwords);
    if(messageType=='English')
    {
      if (numwords > 160) {
          $('#message-count-credit').addClass("changeColour");
      } else {
          $('#message-count-credit').removeClass("changeColour");
      }
      if (parseInt(numwords) <= 306) {
        var credit = parseInt(parseInt(numwords) / 160);
        if (parseInt(numwords) % 160 != 0)
            credit = credit + 1;
      } else {
          var credit = parseInt(parseInt(numwords) / 153);
          if (parseInt(credit) % 153 != 0)
              credit = credit + 1;
      }
      console.log(credit);
      $('#credits_span').html(credit);
    }
    else
    {
      if (numwords > 70) {
          $('#message-count-credit').addClass("changeColour");
      } else {
          $('#message-count-credit').removeClass("changeColour");
      }
      var credit;
      if (parseInt(numwords) <= 70)
          credit = 1;

      else {
          credit = parseInt(parseInt(numwords) / 67);
          if (parseInt(numwords) % 67 != 0)
              credit = credit + 1;
      }
      $('#credits_span').html(credit);
    }
  }
  
  $(document).on('change', '#message_type', function(){  
    var message_type= $(this).val();
    if(message_type=='Unicode'){
      $('#unicode').show();   
      $('#transalte').show();   
      $('#english').hide();   
      document.getElementById("counttext").innerHTML = 0; 
      $('#message_english').val('');  
      $('#message_unicode').prop('required',true);
      $('#message_english').prop('required',false);
    }
    else if(message_type=='English'){
      $('#unicode').hide();   
      $('#transalte').hide();   
      $('#english').show(); 
      $('#message_unicode').val('');  
      $('#message_unicode').prop('required',false);
      $('#message_english').prop('required',true);   
    }
    messageCount();
  });

  // display none block  contact list  when  csv upload
  function valueChanged()
  {
    $("#display-after-read-csv").hide();
    $("#csv-file-upload-section").show();
    $("#dynamic_value_selectbox").hide();
    $("#csv-contact").html(0);
    $("#record_csv").html(''); 
    $('#mobile_field').empty();
    $('#dynamic_field').empty();
    $("#file-csv").val('');
    $('#mobile_field').prop('required',false);
    $('#contacts').prop('required',true);
  }
   $(document).on('click', '#custom-dynamic_field', function(){
      var dynamic_field_val = $(this).data('customval');
       if(dynamic_field_val != ''){
      var message_type= $('#message_type').val();
      if(message_type=='Unicode'){
        var cursorPos = $('#message_unicode').prop('selectionStart'); 
        var v = $('#message_unicode').val();  
        var textBefore = v.substring(0,  cursorPos );
        var textAfter  = v.substring( cursorPos, v.length );
        $('#message_unicode').val(textBefore+ '{{'+dynamic_field_val.trim()+'}}' +textAfter );
      }
      else if(message_type=='English'){
        var cursorPos =$('#message_english').prop('selectionStart');   
        var v = $('#message_english').val();  
        var textBefore = v.substring(0,  cursorPos );
        var textAfter  = v.substring( cursorPos, v.length );
        $('#message_english').val( textBefore+'{{'+ dynamic_field_val.trim() +'}}'+textAfter );   
      } 
    
    }
      
    });

  function checkRouteAndTime()
  {
    var route = $('#route').val();
    var route_type = $('#route_type').val();
    var schedule_date = $('#schedule_date').val();
    var hours = $('#hours').val();
    var min = $('#min').val();
    $.ajax({
      url: appurl+"check-promotional",
      type: 'POST',
      data:{route:route,route_type:route_type,schedule_date:schedule_date,hours:hours,min:min},  
      success:function(data){
        if(data=='not-allow')
        {
          toastr.info('Info, Promotional messages can only be sent between 09:00 to 21:00.', {timeOut: 5000})
        }
        if(data=='old-time')
        {
          toastr.error('Info, Schedule time is incorrect, please change time and send again.', {timeOut: 5000})
        }
      }
    });
  }
  
  $(document).on('click', '.hideThis', function(){  
    $('#myList').hide();
  });

  $('#campaign').keyup(function () {
      $('#campaign-name-conunter').text('');
      var max = 32;
      var len = $(this).val().length;
      if (len >= max) {
          $('#campaign-name-conunter').text('Campaign name should less than 32 characters long.');
      } else {
          var char = max - len;
      }
  });

  function custometotalnums()
  {
    var mobilenumbers = $("#contacts").val();
    if (mobilenumbers != '')
    {
      separatedNumber = mobilenumbers.split(/[\s,]+/);
      separatedNumber = jQuery.grep(separatedNumber, function (n) {
          return (n);
      });
      $('#numbers-count').html(separatedNumber.length);
      $('#numbersCountInput').val(separatedNumber.length);
    } else {
      $('#numbers-count').html('0');
      $('#numbersCountInput').val('0');
    }
  }
  $('#contacts').keyup(function () {
      custometotalnums();
  });

$('#account-info-section a').click(function(e) {
  e.preventDefault();
  $(this).tab('show');
});

// store the currently selected tab in the hash value
$("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
  var id = $(e.target).attr("href").substr(1);
  window.location.hash = id;
});

// on load of the page: switch to the currently selected tab
var hash = window.location.hash;
$('#account-info-section a[href="' + hash + '"]').tab('show');
  
 function calNetAmount()
 {
    var current_balance = document.getElementById('current_balance').value;
    var rate = document.getElementById('rate').value;
    var percentage = document.getElementById('apply-percentage').value;
    if(current_balance!='' && rate!='')
    {
      $("#net-amount-section").show();
      var totalTax = (parseFloat(parseFloat(current_balance * rate) * percentage) /100);
      var tamount = parseFloat(current_balance * rate);
      var netamount = tamount + totalTax;
      $("#totalAmount").html(tamount.toFixed(2));
      $("#totalTax").html(totalTax.toFixed(2));
      $("#netAmount").html(netamount.toFixed(2));
    }
    else
    {
      $("#net-amount-section").hide();
    }
 }

 $('.addMorefeature').click(function() {
    $('.blockFeature:last').after('<div class="blockFeature"><div class="form-group"> <div class="input-group"> <input id="features" class="form-control" placeholder="Feature" autocomplete="off" required="required" name="features[]" type="text" value=""> <span class="input-group-append"> <button class="btn btn-danger removeFeature" type="button" data-toggle="tooltip" data-placement="top" title="Remove this Feature"><i class="fa fa-minus"></i></button> </span> </div></div></div>'); 
});
$('.featureBox').on('click','.removeFeature',function() {
  $(this).parents(".blockFeature").remove();
});

/************ add to card ********/
$(document).on("click", "#buy-now-package", function () {
  var package_id = $(this).data('id');
  var uuid = $(this).data('uuid');
  var role = $(this).data('role');
  var type = $(this).data('type');
  $.ajax({
    url: appurl+"addtocart",
    type: 'POST',
    data:{package_id:package_id,uuid:uuid,role:role,type:type},  
    success:function(data){
      if(data['type']=='success')
      {
        window.location.href = appurl+"viewcart/"+data['uuid'];
      }
      else
      {
        toastr.error(data['message'], {timeOut: 5000})
      }
    }
  });
});

function submitTextReport(transactionid,type) {
   $.ajax({
    url: appurl+"export-report",
    type: 'POST',
    data:{transactionid:transactionid,type:type},  
    success:function(data){
      //console.log(data);
      if(data['type']=='success')
      {
       toastr.success(data['message'], {timeOut: 5000})
      }
      else
      {
        toastr.error(data['message'], {timeOut: 5000})
      }
    }
  });
}
$(document).on("change", "#dlr_code_master_id", function () {
  var id= $(this).val();
   $.ajax({
    url: appurl+"get-master-dlrcode-info",
    type: 'POST',
    data:{id:id},  
    success:function(data){
        $("#master-dlr-info").html(data);
    }
  });

});

$(document).on('click', '.backbtnschedule', function(){  
        $('#scheduleButton').show();   
        $('#scheduleDiv').hide();   
        $('#schedulebut').hide();
       
  }); 

// Add Request for Credit
$(document).on("click", "#creditRequestId", function () {
  $('#creditRequestForm').hide();
  $('.loading').show();
  var id = '';
  $.ajax({
    url: appurl+"credit-request-form",
    type: 'POST',
    data:{id:id}, 
    success:function(info){
      $('.loading').hide();
      $('#creditRequestForm').html(info);
      $('#creditRequestForm').show();
    }
  });
});


function calNetPayAmount()
 {
    var pay_amount = document.getElementById('pay_amount').value;
    var percentage = document.getElementById('apply_percentage').value;
    if(pay_amount!='')
    {
      $("#pay-amount-section").show();
      var totalTax = (parseFloat(parseFloat(pay_amount) * percentage) /100);
      var tamount = parseFloat(pay_amount);
      var netamount = tamount + totalTax;
      $("#totalAmountpay").html(tamount.toFixed(2));
      $("#totalTaxpay").html(totalTax.toFixed(2));
      $("#netAmountpay").html(netamount.toFixed(2));
      $("#finalamnt").html(netamount.toFixed(2));
      $("#final_amount").val(netamount.toFixed(2));
    }
    else
    {
      $("#pay-amount-section").hide();
    }
 }

// Puchasing List
$(document).on("click", "#myPurchasingId", function () {
  $('#my-purchasing-list').hide();
  $('.loading').show();
  var id = '';
  $.ajax({
    url: appurl+"my-purchasing-list",
    type: 'POST',
    data:{id:id}, 
    success:function(info){
      $('.loading').hide();
      $('#my-purchasing-list').html(info);
      $('#my-purchasing-list').show();
    }
  });
});


// Delivery Detail
$(document).on("click", "#deliveryDetailId", function () {
  $('#show-delivery-detail').hide();
  $('.loading').show();
  var id = $(this).data('id');
  $.ajax({
    url: appurl+"show-delivery-detail",
    type: 'POST',
    data:{id:id}, 
    success:function(info){
      $('.loading').hide();
      $('#show-delivery-detail').html(info);
      $('#show-delivery-detail').show();
    }
  });
});

function showdlrCode(id) {
$.ajax({
    type: 'POST',
    url: appurl+"showdlrCode",
    data:'id='+id,
    success:function(info){
      $('#showdlr').html(info);
      
    }
  });
}

// Swich Account
// Add Request for Credit
$(document).on("click", "#accountSwitchId", function () {
  $('#accountSwitchModel').hide();
  $('.loading').show();
  var id = '';
  $.ajax({
    url: appurl+"switch-account",
    type: 'POST',
    data:{id:id}, 
    success:function(info){
      $('.loading').hide();
      $('#accountSwitchModel').html(info);
      $('#accountSwitchModel').show();
    }
  });
});

// Add Request for Credit
$(document).on("click", "#getimagesId", function () {
  $('#imageListTable').hide();
  $('.loading').show();
  var id = '';
  $.ajax({
    url: appurl+"get-images-list",
    type: 'POST',
    data:{id:id}, 
    success:function(info){
      $('.loading').hide();
      $('#imageListTable').html(info);
      $('#imageListTable').show();
    }
  });
});





  
   

