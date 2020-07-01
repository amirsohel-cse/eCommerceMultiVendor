<?php
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Byan Pay</title>
    <!-- this meta viewport is required for BOLT //-->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" >

</head>
<style type="text/css">
    body {
  margin: 0;
  padding: 0;
  font-family: verdana;
}
.center {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}
.ring {
  width: 250px;
  height: 250px;
  border-radius: 50%;
  box-shadow: 0 4px 0 #262626;
  background: transparent;
  animation: animate 1s infinite linear;
}
.text {
  width: 250px;
  height: 250px;
  border-radius: 50%;
  color: #262626;
  position: absolute;
  top: 0;
  left: 0;
  text-align: center;
  line-height: 300px;
  font-size: 2em;
  background: transparent;
  box-shadow: 0 0 5px rgba(0, 0, 0, .2);
}
@keyframes animate {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
</style>
<div class="center">
    <div class="text">
      <img src="{{asset('/frontend/images/icons/cards/bplogo.png')}}" alt="" style="margin: 25%">
    </div>
    <div class="ring"></div>
  </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript">

    $.post("{{route('byanpay.post_payment')}}",{ _token: '{{csrf_token()}}', data:null })
        .done(function(data){
            var json = JSON.parse(data);
            var fr = '<form action=\"'+json.action+'\" method=\"post\">' +
                        '<input type=\"hidden\" name=\"MerchantID\" value=\"'+json.MerchantID+'\" />' +
                        '<input type=\"hidden\" name=\"CollaboratorID\" value=\"'+json.CollaboratorID+'\" />' +
                        '<input type=\"hidden\" name=\"requestParameter\" value=\"'+json.MerchantID +'||'+json.CollaboratorID+'||'+json.requestParameter+'\" />' +
                        '</form>';
                    //console.log(fr);
                    var form = jQuery(fr);
                    jQuery('body').append(form);
                    form.submit();
        })
        .fail(function(xhr, status, error) {
            $('#mobile_verfication').html("<p class='helper'> "+xhr.responseJSON.message+" </p>");
        });
</script>
</html>
