<?php

namespace App\Classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Classe responsável por tratar e enviar informações por e-mail
 * @class Mail
 * @author Oseas Moreto
 */
class Mail{

    public $host       = null;
    public $username   = null;
    public $password   = null;
    public $from       = null;
    public $fromname   = null;
    public $recipient  = [];
    public $replyto    = [];
    public $addcc      = [];
    public $addbcc     = [];
    public $attachment = [];
    public $subject    = null;
    public $body       = null;
    public $altbody    = null;
    public $port       = null;
    public $ssl        = 'tsl';
    public $debug      = false;

    public $estruturaemail = '';

    public function __construct($user, $pass, $host, $port, $color, $title, $image,$ssl = 'tsl',$debug = false){
        $this->username = $user;
        $this->password = $pass;
        $this->host     = $host;
        $this->from     = $user;
        $this->port     = $port;
        $this->color    = $color;
        $this->title    = $title;
        $this->image    = $image;
        $this->ssl      = $ssl;
        $this->debug    = $debug;

        $this->estruturaemail = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>'.$this->title.'</title>
</head>

<body>
<table width="80%" border="0" cellspacing="0" style="border-top:1px solid #ccc; border-left: 1px solid #ccc; border-bottom:1px solid #ccc; border-right: 1px solid #ccc;" align="center" cellpadding="0">
  <tr>
    <td style="width:100%; background-color:#fff; padding: 10px" align="center"></td>
  </tr>
  <tr>
    <td style="width:100%; background-color:'.$this->color.'; padding:25px; font-family: Arial, Helvetica, sans-serif; font-size: 24px; color: #fff;line-height:22px; margin-top:5px; font-weight: bold" align="center"><img style="height: 100px" src="'.$this->image.'" alt="Clique em CARREGAR IMAGENS para visualizar este e-mail." style="margin: 20px"></td>
  </tr>
  <tr>
    <td style="width:100%; padding:25px;line-height:22px;">
    	<table width="95%" cellpadding="4" align="center" style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; color: #071c2c;line-height:22px; text-align:left;" cellspacing="0">
            %%CORPO%%
        </table>
    </td>
  </tr>
<tr>
<td style="text-align:center; vertical-align:top; direction:ltr; font-size:0px; padding:20px 0px; padding-bottom:0px; border-collapse:collapse">
<div class="x_mj-column-per-100 x_outlook-group-fix" style="vertical-align:top; display:inline-block; direction:ltr; font-size:13px; text-align:left; width:100%">
<table style="border-collapse:collapse" width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody>
<tr>
<td style="word-wrap:break-word; font-size:0px; padding:0px; border-collapse:collapse" align="center">
<div style="color: rgb(85, 85, 85); font-family: sans-serif, serif, EmojiFont; font-size: 16px; line-height: 1.5; text-align: center; margin-bottom:20px">
Abra&ccedil;os, <br>
Equipe '.$this->title.'</div>
</td>
</tr>
  <tr>
    <td style="width:100%; background-color:'.$this->color.'; padding:5px; margin-top:5px" align="center">&nbsp;</td>
  </tr>

</table>

</body>
</html>';
    }

    public function send(){
        $mail = new PHPMailer(true);                         
        try {
            $mail->SMTPDebug  = !$this->debug ? 0 : 2;              
            $mail->isSMTP();                          
            $mail->Host       = $this->host; 
            $mail->SMTPAuth   = true;            
            $mail->Username   = $this->username;      
            $mail->Password   = $this->password;  
            $mail->SMTPSecure = $this->ssl;  
            $mail->Port       = $this->port;

            //Recipients
            $mail->setFrom($this->from, $this->fromname);

            if(count($this->recipient)>0){
                for($i=0; $i<count($this->recipient); $i++){
                    $mail->addAddress($this->recipient[$i]['email'], $this->recipient[$i]['name']);     // Add a recipient
                }
            }

            if(count($this->replyto)>0) {
                for ($i = 0; $i < count($this->replyto); $i++) {
                    $mail->addReplyTo($this->replyto[$i]['email'], $this->replyto[$i]['name']);     // Add a recipient
                }
            }

            if(count($this->addcc)>0) {
                for ($i = 0; $i < count($this->addcc); $i++) {
                    $mail->addCC($this->addcc[0]);     // Add a recipient
                }
            }

            if(count($this->addbcc)>0) {
                for ($i = 0; $i < count($this->addbcc); $i++) {
                    $mail->addBCC($this->addbcc[$i]);     // Add a recipient
                }
            }


            //Attachments
            if(count($this->attachment)>0) {
                for ($i = 0; $i < count($this->attachment); $i++) {
                    $mail->addAttachment($this->attachment[$i]['path'], $this->attachment[$i]['name']);    // Optional name
                }
            }

            //Content
            $mail->isHTML(true);                          
            $mail->Subject = $this->subject;
            $mail->Body    = str_replace('%%CORPO%%', $this->body, $this->estruturaemail);
            $mail->AltBody = $this->altbody;
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
