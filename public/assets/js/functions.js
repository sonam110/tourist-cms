$(function() {
  $.ajaxSetup({
    headers: {
      'X-CSRF-Token': $('meta[name="_token"]').attr('content')
    }
  });
});

$(function(){
    $('input[type=color]').change(function(){
       $(this).addClass('changed');
    })
})

function changeAccountStatus(app_key)
{
  if($('.custom-switch-input').is(":checked")) 
  {
    var status = 'Active';
  } 
  else
    {
      var status = 'Inactive';
    }
   $.ajax({
    type: "POST",
    url: appurl+"update-status",
    data:'cmbaction='+status+'&app_key='+app_key,
    success: function(data){
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

function changeAccountApi(app_key)
{
  
   $.ajax({
    type: "POST",
    url: appurl+"update-api",
    data:'cmbaction='+'&app_key='+app_key,
    success: function(data){
      if(data['type']=='success')
      {
        toastr.success(data['message'], {timeOut: 5000})
        location.reload();
      }
      else
      {
        toastr.error(data['message'], {timeOut: 5000})
        location.reload();
      }
    }
  });
}

function enableApiSec(uuid)
{
  if($("#is_enabled_api_ip_security").is(':checked'))
    var ipSec = 1;
  else
    var ipSec = 0;

  $.ajax({
    type: "POST",
    url: appurl+"update-user-ip_sec",
    data:'uuid='+uuid+'&ipSec='+ipSec,
    success: function(data){
      if(data['type']=='success')
      {
        toastr.success(data['message'], {timeOut: 5000})
        if(ipSec == 1)
        {
          $("#listIpSec").show();
          $("#formIPSec").show();
        }
        else
        {
          $("#listIpSec").hide();
          $("#formIPSec").hide();
        }
      }
      else
      {
        toastr.error(data['message'], {timeOut: 5000})
        //location.reload();
      }
    }
  });
}

$('.addMore').on('click', function(){
    var i = $('.cloneBox').length + 1;
    var $addmore = $(this).closest('.cloneBox').clone();
    $addmore.find('[id]').each(function(){this.id+=i});
    $addmore.find('.btn').removeClass('btn-success').addClass('btn-danger');
    $addmore.find("input:text").val("").end();
    $addmore.find('.btn').html('<i class="fa fa-minus"></i>');
    $addmore.find('.btn').attr('title', 'Remove this?');
    $addmore.find('.btn').attr('onClick', '$(this).tooltip("hide");$(this).closest(".cloneBox").remove();');
    $addmore.appendTo('.blockNumber');
});

function refreshStatus(status_type)
{
  if($('#custom-switch-'+status_type).is(":checked")) 
  {
    var status = '1';
  } 
  else
  {
    var status = '0';
  }
  $.ajax({
    type: "POST",
    url: appurl+"update-refresh-status",
    data:'status='+status+'&status_type='+status_type,
    success: function(data)
    {
      $("#is-active-reload-"+status_type).val(status);
      if(data['type']=='success')
      {
        toastr.success(data['message'], {timeOut: 5000});
      }
      else
      {
        toastr.error(data['message'], {timeOut: 5000});
      }
    }
  });
}

function addEvent(node, type, callback) {
  if (node.addEventListener) {
    node.addEventListener(
      type,
      function(e) {
        callback(e, e.target);
      },
      false
    );
  } else if (node.attachEvent) {
    node.attachEvent("on" + type, function(e) {
      callback(e, e.srcElement);
    });
  }
}

function shouldBeValidated(field) {
  return (
    !(field.getAttribute("readonly") || field.readonly) &&
    !(field.getAttribute("disabled") || field.disabled) &&
    (field.getAttribute("pattern") || field.getAttribute("required"))
  );
}

function instantValidation(field) {
  if (shouldBeValidated(field)) {
    var invalid =
      (field.getAttribute("required") && !field.value) ||
        //(field.getAttribute("max") < field.value) ||
        //(field.getAttribute("min") > field.value) ||
      (field.getAttribute("pattern") &&
        field.value &&
        !new RegExp(field.getAttribute("pattern")).test(field.value));
    if (!invalid && field.getAttribute("aria-invalid")) {
      field.removeAttribute("aria-invalid");
    } else if (invalid && !field.getAttribute("aria-invalid")) {
      field.setAttribute("aria-invalid", "true");
    }
  }
}

var fields = [
  document.getElementsByTagName("input"),
  document.getElementsByTagName("textarea"),
  document.getElementsByTagName("select")
];
for (var a = fields.length, i = 0; i < a; i++) {
  for (var b = fields[i].length, j = 0; j < b; j++) {
    addEvent(fields[i][j], "keyup", function(e, target) {
      instantValidation(target);
    });
  }
}

$('input[type=number]').change(function() {
    var min = $(this).attr("min");
    var max = $(this).attr("max");
    var val = $(this).val().length ? $(this).val() * 1 : NaN;
    if(min!=undefined && max!=undefined)
    {
      if (val >= min && val <= max) {
         $(this).css("border", ""); 
         $(this).css("box-shadow", ""); 
      } else {
         $(this).css("border", "1px solid #f00");
         $(this).css("box-shadow", "0 0 4px 0 #f00");
      }
    }
    else if(min==undefined && max!=undefined)
    {
      if (val <= max) {
         $(this).css("border", ""); 
         $(this).css("box-shadow", ""); 
      } else {
         $(this).css("border", "1px solid #f00");
         $(this).css("box-shadow", "0 0 4px 0 #f00");
      }
    }
    else if(min!=undefined && max==undefined)
    {
      if (val >= min) {
         $(this).css("border", ""); 
         $(this).css("box-shadow", ""); 
      } else {
         $(this).css("border", "1px solid #f00");
         $(this).css("box-shadow", "0 0 4px 0 #f00");
      }
    }
});

$(document).ready(function(){
    $("body").delegate('input[type=number]', 'focusout', function(){
        if($(this).val() < 0){
          $(this).val('');
          toastr.info('Info! Negative values not allowed.', {
            timeOut: 5000
          })
        }
    });
});

function updateBatchStatus(uuid,batch_no,status)
{
   $.ajax({
    type: "POST",
    url: appurl+"update-batchstatus",
    data:'uuid='+uuid+'&batch_no='+batch_no+'&status='+status,
    success: function(data){
      if(data['type']=='success')
      {
        toastr.success(data['message'], {timeOut: 5000})
        location.reload();
      }
      else
      {
        toastr.error(data['message'], {timeOut: 5000})
        //location.reload();
      }
    }
  });
}

function showFileContent(value)
{
  var docTypeArr = ['Image','Audio','Video','Youtube','Iframe'];
  if(value=='Iframe' || value=='Youtube') {
    $("#fileUploadDiv").hide();
    $("#pasteLinkDiv").show();
  } else {
    $("#fileUploadDiv").show();
    $("#pasteLinkDiv").hide();
    $("#chooseType").html(value);
  }
  for (i = 0; i < docTypeArr.length; i++) {
    if(docType!=docTypeArr[i])
    {
      $("#view"+docTypeArr[i]).hide();
    } else {
      $("#view"+docTypeArr[i]).show();
    }
  }
}

function removeReadonly(value)
{
  if(value=='') {
    $("#response_mob_num").attr('readonly', 'readonly');
  } else {
    $("#response_mob_num").attr('readonly', false);
  }
}

$('input[type=submit]').click(function() {
  var validate = true;
   $('input:required').each(function(){
    if($(this).val().trim() === ''){
      validate = false;
    }
   });
   $('textarea:required').each(function(){
    if($(this).val().trim() === ''){
      validate = false;
    }
   });
   $('select:required').each(function(){
    if($(this).val().trim() === ''){
      validate = false;
    }
   });
   if(validate) {
    $("#form-submit-loading").addClass('show');
    //$(this).val('Submitting. Please wait...');
    return true;
   }
});

$('button[type=submit]').click(function() {
  var validate = true;
   $('input:required').each(function(){
    if($(this).val().trim() === ''){
      validate = false;
    }
   });
   $('textarea:required').each(function(){
    if($(this).val().trim() === ''){
      validate = false;
    }
   });
   $('select:required').each(function(){
    if($(this).val().trim() === ''){
      validate = false;
    }
   });
   if(validate) {
    $("#form-submit-loading").addClass('show');
    //$(this).val('Submitting. Please wait...');
    return true;
   }
});

function reloadTemplate(uuid)
{
  $.ajax({
    type: "GET",
    url: appurl+"api/v1/reloadTemplate/"+uuid,
    success: function(data) {
      $('#dynamic_field').html(data);
    }
  });
}

$(document).on("click", "#show-send-otp", function () {
   $('.loading').show();
   $('#verify-otp').hide();
   $('#send-otp').show();
   $('.loading').hide();
   $("#title-tab").html('Send OTP');
});
$(document).on("click", "#show-verify-otp", function () {
   $('.loading').show();
   $('#verify-otp').show();
   $('#send-otp').hide();
   $('.loading').hide();
   $("#title-tab").html('Verify OTP');
});

$('.cloneDiv').on('click', function(){
    var i = $('.clone-div-section').length + 1;
    var $addmore = $(this).closest('tr').clone();
    $addmore.find('[id]').each(function(){this.id+=i});
    $addmore.find('.btn').removeClass('btn-success').addClass('btn-danger');
    $addmore.find("input:text").val("").end();
    $addmore.find("input:hidden").val("").end();
    $addmore.find('.btn').html('<i class="fa fa-minus"></i>');
    $addmore.find('.btn').attr('data-toggle', '');
    $addmore.find('.btn').attr('onClick', '$(this).closest("tr").remove();');
    $addmore.appendTo('.clone-div-section-append tbody');
});

function getSubCat(cat_id)
{
  $.ajax({
    type: "GET",
    url: appurl+"getSubcategory/"+cat_id,
    success: function(data) {
      $('#subcategory_id').html(data);
    }
  });
}