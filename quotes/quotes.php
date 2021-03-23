<?php
include 'includes/Validator.php';
include 'includes/simple_html_dom.php';
include 'includes/class.phpmailer.php';

$messages = array(
	'required' => 'This field is required',
	'email'=> "Please enter a valid email address.",
	'url'=> "Please enter a valid URL.",
	'date'=> "Please enter a valid date.",
	'time'=> "Please enter a valid time, between 00:00 and 23:59",
	'digits'=> "Please enter only digits.",
	'creditcard'=> "Please enter a valid credit card number.",
	'maxlength'=> "Please enter no more than %d characters.",
	'minlength'=>"Please enter at least %d characters.",
	'maxWords'=> "Please enter no more than %d words.",
	'minWords'=>"Please enter at least %d words.",
	'max'=>"Please enter a value less than or equal to %d.",
	'min'=>"Please enter a value greater than or equal to %d.",
	'phone'=>'Please enter a valid phone number'
);

function addError($html,$divId,$msg,$errors){
	if(!array_key_exists($divId, $errors)){
		$errors[$divId] = $msg;
		$ret = $html->find('#'.$divId,0);
		$ret->outertext = $ret->outertext.'<label for="'.$divId.'" generated="true" class="error">'.$msg.'</label>';
	}
	return $errors;
}

function addValue($html,$divId,$val){
	$ret = $html->find('#'.$divId,0);
	$tag = $ret->tag;
	
	switch ($tag) {
		case 'textarea':
				$ret->innertext = $val;
			break;
		
		case 'span':
			$children = $ret->children();
				foreach($children as $child)
					if($child->children(0)->type == 'checkbox'){
						if(array_key_exists($child->children(0)->value, array_flip($val)))
							$child->children(0)->checked = 'checked';
					}elseif($child->children(0)->type == 'radio'){
						if($child->children(0)->value == $val)	
							$child->children(0)->checked = 'checked';
					}
						
			break;
		case 'select':
			$children = $ret->children();
				foreach($children as $child)
					if($child->value == $val)
						$child->selected = true;
			break;

		
		default:
			$ret->value = $val;		
			break;
	}
	
}

if (get_magic_quotes_gpc()) {
    function stripslashes_gpc(&$value)
    {
        $value = stripslashes($value);
    }
	array_walk_recursive($_GET, 'stripslashes_gpc');
	array_walk_recursive($_POST, 'stripslashes_gpc');
	array_walk_recursive($_COOKIE, 'stripslashes_gpc');
	array_walk_recursive($_REQUEST, 'stripslashes_gpc');
}


function send_form_email($to,$cc='',$subject,$postData,$host='localhost',$username='',$password='')
{
    
    $emailBody = '';
    
    foreach($postData as $field=>$value){
        $val = is_array($value) ? implode(", ",$value) : $value ;
        $emailBody .= "<b>$field: </b> $val<br><br>";
    }
    
    if(ini_get("sendmail_path")){
        
        $mail = new PHPMailer();
        
        if(is_array($to)){
            foreach($to as $addr){
                $mail->AddAddress($addr);
            }
        }else if($to != null && $to != ''){
            $mail->AddAddress($to);
        }
        
        if(is_array($cc)){
            foreach($cc as $addr){
                $mail->AddAddress($addr);
            }
        }else if($cc != null && $cc != ''){
            $mail->AddAddress($cc);
        }
        
        $mail->Subject = $subject;
        $mail->MsgHTML($emailBody);
        $mail->Send();
        
    }else{
        
        $mail = new PHPMailer(); // the true param means it will throw exceptions on errors, which we need to catch
        
        $mail->IsSMTP(); // telling the class to use SMTP
        
        $mail->Host       = $host; // SMTP server
        
        if($username != '' && $password != ''){
              $mail->SMTPAuth   = true;
              $mail->Username   = $username;
              $mail->Password   = $password;
        }
        
        if(is_array($to)){
            foreach($to as $addr){
                $mail->AddAddress($addr);
            }
        }else if($to != null && $to != ''){
            $mail->AddAddress($to);
        }
        
        if(is_array($cc)){
            foreach($cc as $addr){
                $mail->AddAddress($addr);
            }
        }else if($cc != null && $cc != ''){
            $mail->AddAddress($cc);
        }
        
        $mail->Subject = $subject;
        $mail->MsgHTML($emailBody);
        $mail->Send();

        
    }
}
$email = json_decode('{"to":"quotes@webfurious.com","cc":"tony.aubuchon@webfurious.com","subject":"Quote Request Received"}',true);
$validationRules = json_decode('{"your_name:":{"validate":{"required":true,"messages":{"required":"This field is required"},"maxlength":"50","minlength":"8"}},"your_email:":{"validate":{"required":true,"email":true,"messages":{"required":"This field is required"}}},"your_phone:":{"validate":{"required":true,"phone":true,"messages":{"required":"This field is required"}}},"company_name:":{"validate":{"required":false,"messages":[]}},"website_url:":{"validate":{"required":false,"url":true,"messages":[]}},"services_required:":{"validate":{"required":true,"messages":{"required":"This field is required"}}},"will_you_be_supplying_any_files":{"validate":{"required":true,"messages":{"required":"This field is required"}}},"your_budget:":{"validate":{"required":true,"messages":{"required":"This field is required"}}},"project_timeframe:":{"validate":{"required":true,"messages":{"required":"This field is required"}}},"project_details:":{"validate":{"required":true,"messages":{"required":"This field is required"}}}}',true);
$s = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Webfurious Designs - Project Quote Request Form</title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />

<link type="text/css" href="css/form.css" rel="stylesheet" />

<link type="text/css" href="css/style1.css" rel="stylesheet" />

<link type="text/css" href="css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery-1.8.0.min.js"></script>

<script type="text/javascript" src="js/jquery-ui-1.8.23.custom.min.js"></script>
<script type="text/javascript" src="js/jquery.metadata.js"></script>
<script type="text/javascript" src="js/jquery.validate.min.js"></script>


</head>
<body><div id="form-container">
 
        <h1 id="form-name">Project Quote Request Form</h1>
		<form class="ui-sortable" id="dynamic-form" action="" method="post">
            
		<div style="display: block;" class="row"><label class="field" for="your_name:">Your Name:<div class="rqrd">*</div></label><span class="textField"><input data="{&quot;validate&quot;:{&quot;required&quot;:true,&quot;messages&quot;:{&quot;required&quot;:&quot;This field is required&quot;},&quot;maxlength&quot;:&quot;50&quot;,&quot;minlength&quot;:&quot;8&quot;}}" id="your_name:" name="your_name:" type="text"></span></div><div style="display: block;" class="row"><label class="field" for="your_email:">Your Email:<div class="rqrd">*</div></label><span class="email"><input data="{&quot;validate&quot;:{&quot;required&quot;:true,&quot;email&quot;:true,&quot;messages&quot;:{&quot;required&quot;:&quot;This field is required&quot;}}}" id="your_email:" name="your_email:" type="text"></span></div><div style="display: block;" class="row"><label class="field" for="your_phone:">Your Phone:<div class="rqrd">*</div></label><span class="phone"><input data="{&quot;validate&quot;:{&quot;required&quot;:true,&quot;phone&quot;:true,&quot;messages&quot;:{&quot;required&quot;:&quot;This field is required&quot;}}}" id="your_phone:" name="your_phone:" type="text"></span></div><div style="display: block;" class="row"><label class="field" for="company_name:">Company Name:</label><span class="textField"><input data="{&quot;validate&quot;:{&quot;required&quot;:false,&quot;messages&quot;:{}}}" id="company_name:" name="company_name:" type="text"></span></div><div style="display: block;" class="row"><label class="field" for="website_url:">Website URL:</label><span class="url"><input data="{&quot;validate&quot;:{&quot;required&quot;:false,&quot;url&quot;:true,&quot;messages&quot;:{}}}" id="website_url:" name="website_url:" type="text"></span></div><div style="display: block; position: relative; top: 0px; left: 0px;" class="row"><label class="field" for="services_required:">Services Required:<div class="rqrd">*</div></label><span class="radioButton" id="services_required:"><label class="option" for="services_required:_print_design"><input data="{&quot;validate&quot;:{&quot;required&quot;:true,&quot;messages&quot;:{&quot;required&quot;:&quot;This field is required&quot;}}}" class="radio" name="services_required:" id="services_required:_print_design" value="Print Design" type="radio">Print Design</label><label class="option" for="services_required:_website_design"><input class="radio" name="services_required:" id="services_required:_website_design" value="Website Design" type="radio">Website Design</label><label class="option" for="services_required:_identity_&amp;_branding"><input class="radio" name="services_required:" id="services_required:_identity_&amp;_branding" value="Identity &amp; Branding" type="radio">Identity &amp; Branding</label></span></div><div style="display: block; position: relative; top: 0px; left: 0px;" class="row"><label class="field" for="will_you_be_supplying_any_files">Will you be supplying any files<div class="rqrd">*</div></label><span class="radioButton" id="will_you_be_supplying_any_files"><label class="option" for="will_you_be_supplying_any_files_yes"><input data="{&quot;validate&quot;:{&quot;required&quot;:true,&quot;messages&quot;:{&quot;required&quot;:&quot;This field is required&quot;}}}" class="radio" name="will_you_be_supplying_any_files" id="will_you_be_supplying_any_files_yes" value="Yes" type="radio">Yes</label><label class="option" for="will_you_be_supplying_any_files_no"><input class="radio" name="will_you_be_supplying_any_files" id="will_you_be_supplying_any_files_no" value="No" type="radio">No</label></span></div><div style="display: block;" class="row"><label class="field" for="your_budget:">Your Budget:<div class="rqrd">*</div></label><span class="dropDown"><select data="{&quot;validate&quot;:{&quot;required&quot;:true,&quot;messages&quot;:{&quot;required&quot;:&quot;This field is required&quot;}}}" id="your_budget:" name="your_budget:"><option value="Under $100">Under $100</option><option value="$100 - $500">$100 - $500</option><option value="$500 - $1000">$500 - $1000</option><option value="$1000 - $5000">$1000 - $5000</option><option value="$5000 +">$5000 +</option></select></span></div><div style="display: block;" class="row"><label class="field" for="project_timeframe:">Project Timeframe:<div class="rqrd">*</div></label><span class="dropDown"><select data="{&quot;validate&quot;:{&quot;required&quot;:true,&quot;messages&quot;:{&quot;required&quot;:&quot;This field is required&quot;}}}" id="project_timeframe:" name="project_timeframe:"><option value="1 - 2 Weeks">1 - 2 Weeks</option><option value="2 - 4 Weeks">2 - 4 Weeks</option><option value="1 - 2 Months">1 - 2 Months</option><option value="2 - 4 Months">2 - 4 Months</option><option value="4 + Months">4 + Months</option></select></span></div><div style="display: block;" class="row"><label class="field" for="project_details:">Project Details:<div class="rqrd">*</div></label><span class="textArea"><textarea data="{&quot;validate&quot;:{&quot;required&quot;:true,&quot;messages&quot;:{&quot;required&quot;:&quot;This field is required&quot;}}}" id="project_details:" name="project_details:"></textarea></span></div><input class="button blue" value="Submit" id="submit-form" type="submit"></form>
	 
</div>
<script type="text/javascript">

$(function(){
jQuery.validator.addMethod("minWords", function(value, element, params) {
return !$(element).val() || $(element).val().split(/[\s\.\?]+/).length >= params;
}, "Please enter at least {0} words.");
jQuery.validator.addMethod("maxWords", function(value, element, params) {
return !$(element).val() || $(element).val().split(/[\s\.\?]+/).length <= params;
}, "Please enter no more than {0} words.");
jQuery.validator.addMethod("phone", function(phone_number, element) {
return this.optional(element) || phone_number.length > 9 &&
phone_number.match(/^(?:\+?1[-. ]?)?\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/);
}, "Please enter a valid phone number");
jQuery.validator.addMethod("time", function(value, element) {
return this.optional(element) || /^([01]\d|2[0-3])(:[0-5]\d){0,2}$/.test(value);
}, "Please enter a valid time, between 00:00 and 23:59");
$.metadata.setType("attr", "data");
$("form").validate({
meta: "validate",
errorPlacement: function(error, element) {
if (element.attr("type") == "checkbox" || element.attr("type") == "radio"){
element.parent().parent().append(error);
}else{
error.insertAfter(element);
}
}
});
});

$(function(){});
</script>

<script type="text/javascript" src="js/jquery.ui.timepicker.js"></script>
<link rel="stylesheet" href="css/jquery.ui.timepicker.css" type="text/css" media="all" />

</body>
</html>';
$html = str_get_html($s);
		
	
if($_SERVER['REQUEST_METHOD'] === 'POST'){

	$errors = array();
	$allFields = array();

	$validator = new Validator();
	foreach($_POST as $field => $value){

		addValue($html,$field,$value);
		array_push($allFields, $field);
		
		if(array_key_exists($field, $validationRules)){
			$rules = $validationRules[$field]['validate'];
			if($rules['required'] == 1){
				if($validator->isEmpty($value)){
					$err = $rules['messages']['required'] == '' ? $messages['required'] : $rules['messages']['required'];
					$errors = addError($html,$field,$err,$errors);
				}
			}
			
			if(count($rules) > 2 && !$validator->isEmpty($value)){
				foreach($rules as $rule=>$val){
					switch ($rule) {
					
						case 'digits':
							
							if(!$validator->isNumber($value))
								$errors = addError($html,$field,$messages['digits'],$errors);
							elseif(array_key_exists('min', $rules))
								if(!$validator->minValue($value,$rules['min']))
									$errors = addError($html,$field,sprintf($messages['min'],$rules['min']),$errors);
							elseif(array_key_exists('max', $rules))
								if(!$validator->maxValue($value,$rules['max']))
									$errors = addError($html,$field,sprintf($messages['max'],$rules['max']),$errors);
							
							break;
							
						case 'email':
							
							if(!$validator->isEmail($value))
								$errors = addError($html,$field,$messages['email'],$errors);
							elseif(array_key_exists('minlength', $rules))
								if(!$validator->minLength($value,$rules['minlength']))
									$errors = addError($html,$field,sprintf($messages['minlength'],$rules['minlength']),$errors);
							elseif(array_key_exists('maxlength', $rules))
								if(!$validator->maxLength($value,$rules['maxlength']))
									$errors = addError($html,$field,sprintf($messages['maxlength'],$rules['maxlength']),$errors);
							
							break;
							
						case 'url':
							
							if(!$validator->isUrl($value))
								$errors = addError($html,$field,$messages['url'],$errors);
							elseif(array_key_exists('minlength', $rules))
								if(!$validator->minValue($value,$rules['minlength']))
									$errors = addError($html,$field,sprintf($messages['minlength'],$rules['minlength']),$errors);
							elseif(array_key_exists('maxlength', $rules))
								if(!$validator->maxValue($value,$rules['maxlength']))
									$errors = addError($html,$field,sprintf($messages['maxlength'],$rules['maxlength']),$errors);
							
							break;
							
						case 'date':
							if(!$validator->isDate($value))
								$errors = addError($html,$field,$messages['date'],$errors);
							
							break;
							
						case 'time':
							
							if(!$validator->isTime($value))
								$errors = addError($html,$field,$messages['time'],$errors);
							
							break;
							
						case 'phone':
							
							if(!$validator->isPhoneNumber($value))
								$errors = addError($html,$field,$messages['phone'],$errors);
								
							break;
							
						case 'creditcard':
							
							if(!$validator->isCreditCard($value))
								$errors = addError($html,$field,$messages['creditcard'],$errors);
							
							break;
					
					}

				}
			}
			
			if(count($rules) > 2 && !$validator->isEmpty($value) 
				&& (
				array_key_exists('minWords', $rules) || array_key_exists('maxWords', $rules)
				|| array_key_exists('minlength', $rules) || array_key_exists('maxlength', $rules)
				))
			{
				if(array_key_exists('minlength', $rules)){
					if(is_array($value)){
						if(count($value) < $rules['minlength'])
							$errors = addError($html,$field,sprintf($messages['minlength'],$rules['minlength']),$errors);
					}else{
						if(!$validator->minLength($value,$rules['minlength']))
							$errors = addError($html,$field,sprintf($messages['minlength'],$rules['minlength']),$errors);
					}
				}
				
				if(array_key_exists('maxlength', $rules)){
					if(is_array($value)){
						if(count($value) > $rules['maxlength'])
							$errors = addError($html,$field,sprintf($messages['maxlength'],$rules['maxlength']),$errors);
					}else{
						if(!$validator->maxlength($value,$rules['maxlength']))
							$errors = addError($html,$field,sprintf($messages['maxlength'],$rules['maxlength']),$errors);
					}
				}

				if(array_key_exists('minWords', $rules)){
					if(!$validator->minWords($value,$rules['minWords']))
						$errors = addError($html,$field,sprintf($messages['minWords'],$rules['minWords']),$errors);
				}
				
				if(array_key_exists('maxWords', $rules)){
					if(!$validator->maxWords($value,$rules['maxWords']))
						$errors = addError($html,$field,sprintf($messages['maxWords'],$rules['maxWords']),$errors);
				}

			}
			
		}
	}

	foreach($validationRules as $field => $rule){
		if(!in_array($field, $allFields)){
			$rules = $validationRules[$field]['validate'];
			if($rules['required'] == 1){
				if($validator->isEmpty($value)){
					$err = $rules['messages']['required'] == '' ? $messages['required'] : $rules['messages']['required'];
					$errors = addError($html,$field,$err,$errors);
				}
			}
		}
	}

	if(empty($errors)){

        if(isset($email) && isset($email['smtp']) && isset($email['smtp']['username']) && isset($email['smtp']['password'])) {
            send_form_email(explode(';',$email['to']),explode(';',$email['cc']),$email['subject'],$_POST,$email['smtp']['host'],$email['smtp']['username'],$email['smtp']['password']);
        }else if(isset($email) && isset($email['smtp'])){
            send_form_email(explode(';',$email['to']),explode(';',$email['cc']),$email['subject'],$_POST,$email['smtp']['host']);            
        }else if(isset($email)){
            send_form_email(explode(';',$email['to']),explode(';',$email['cc']),$email['subject'],$_POST);
        }

        if(isset($database)){
        	SaveData($_POST,$fields,$database['host'],$database['username'],$database['password'],$database['dbname'],$database['tablename']);
        }

	    $ret = $html->find('#form-container',0);
	    $ret->innertext = 'Thank you for submitting the form, Please allow 24 - 48 hours for a response!';
	    echo $html;
	}else{
	    echo $html;
	}
	
}else{
	echo $s;
}
	
?>