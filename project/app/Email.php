<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 05/10/2017
 * Time: 1:56 PM
 */

namespace App;


class Email
{
    private $stylesheet;
    private $header;
    private $footer;
    private $base_url;

    public function __construct()
    {
        $this->stylesheet = "<style type='text/css'>
			#yiv8778867732 body, #yiv8778867732 .yiv8778867732wrapper, #yiv8778867732 .yiv8778867732emb-editor-canvas{background-color:#fbfbfb;}#yiv8778867732 .yiv8778867732border{background-color:#ffffff;}#yiv8778867732 h1{color:#565656;}#yiv8778867732 .yiv8778867732wrapper h1{}#yiv8778867732 .yiv8778867732wrapper h1{font-family:sans-serif;}@media screen and (min-width:0){#yiv8778867732 .yiv8778867732wrapper h1{font-family:'Raleway', Arial, sans-serif !important;}}#yiv8778867732 h1{}#yiv8778867732 .yiv8778867732one-col h1{line-height:42px;}#yiv8778867732 .yiv8778867732two-col h1{line-height:32px;}#yiv8778867732 .yiv8778867732three-col h1{line-height:26px;}#yiv8778867732 .yiv8778867732wrapper .yiv8778867732one-col-feature h1{line-height:58px;}@media screen and (max-width:650px){#yiv8778867732 h1{line-height:42px !important;}}#yiv8778867732 h2{color:#555;}#yiv8778867732 .yiv8778867732wrapper h2{}#yiv8778867732 .yiv8778867732wrapper h2{font-family:'Raleway', Arial, sans-serif;}#yiv8778867732 h2{}#yiv8778867732 .yiv8778867732one-col h2{line-height:32px;}#yiv8778867732 .yiv8778867732two-col h2{line-height:26px;}#yiv8778867732 .yiv8778867732three-col h2{line-height:22px;}#yiv8778867732 .yiv8778867732wrapper .yiv8778867732one-col-feature h2{line-height:52px;}@media screen and (max-width:650px){#yiv8778867732 h2{line-height:32px !important;}}#yiv8778867732 h3{color:#555;}#yiv8778867732 .yiv8778867732wrapper h3{}#yiv8778867732 .yiv8778867732wrapper h3{font-family:Raleway, sans-serif;}#yiv8778867732 h3{}#yiv8778867732 .yiv8778867732one-col h3{line-height:26px;}#yiv8778867732 .yiv8778867732two-col h3{line-height:22px;}#yiv8778867732 .yiv8778867732three-col 
			h3{line-height:20px;}#yiv8778867732 .yiv8778867732wrapper .yiv8778867732one-col-feature h3{line-height:42px;}@media screen and (max-width:650px){#yiv8778867732 h3{line-height:26px !important;}}#yiv8778867732 p, #yiv8778867732 ol, #yiv8778867732 ul{color:#565656;}#yiv8778867732 .yiv8778867732wrapper p, #yiv8778867732 .yiv8778867732wrapper ol, #yiv8778867732 .yiv8778867732wrapper ul{}#yiv8778867732 .yiv8778867732wrapper p, #yiv8778867732 .yiv8778867732wrapper ol, #yiv8778867732 .yiv8778867732wrapper ul{font-family:'Helvetica Neue', Arial, sans-serif;}#yiv8778867732 p, #yiv8778867732 ol, #yiv8778867732 ul{}#yiv8778867732 .yiv8778867732one-col p, #yiv8778867732 .yiv8778867732one-col ol, #yiv8778867732 .yiv8778867732one-col ul{line-height:25px;Margin-bottom:25px;}#yiv8778867732 .yiv8778867732two-col p, #yiv8778867732 .yiv8778867732two-col ol, #yiv8778867732 .yiv8778867732two-col ul{line-height:23px;Margin-bottom:23px;}#yiv8778867732 .yiv8778867732three-col p, #yiv8778867732 .yiv8778867732three-col ol, #yiv8778867732 .yiv8778867732three-col ul{line-height:21px;Margin-bottom:21px;}#yiv8778867732 .yiv8778867732wrapper .yiv8778867732one-col-feature p, #yiv8778867732 .yiv8778867732wrapper .yiv8778867732one-col-feature ol, #yiv8778867732 .yiv8778867732wrapper .yiv8778867732one-col-feature ul{line-height:32px;}#yiv8778867732 .yiv8778867732one-col-feature blockquote p, #yiv8778867732 .yiv8778867732one-col-feature blockquote ol, #yiv8778867732 .yiv8778867732one-col-feature blockquote ul{line-height:50px;}@media screen and (max-width:650px){#yiv8778867732 p, #yiv8778867732 ol, #yiv8778867732 ul{line-height:25px !important;Margin-bottom:25px !important;}}#yiv8778867732 .yiv8778867732image{color:#565656;}#yiv8778867732 .yiv8778867732image{font-family:'Helvetica Neue', Arial, sans-serif;}#yiv8778867732 .yiv8778867732wrapper a{color:#41637e;}#yiv8778867732 .yiv8778867732wrapper 
			.yiv8778867732title, #yiv8778867732 .yiv8778867732preheader .yiv8778867732webversion, #yiv8778867732 .yiv8778867732footer .yiv8778867732padded{color:#999;}#yiv8778867732 .yiv8778867732preheader .yiv8778867732title, #yiv8778867732 .yiv8778867732preheader .yiv8778867732webversion, #yiv8778867732 .yiv8778867732footer .yiv8778867732padded{font-family:'Helvetica Neue', Arial, sans-serif;}#yiv8778867732 .yiv8778867732preheader .yiv8778867732title a, #yiv8778867732 .yiv8778867732preheader .yiv8778867732webversion a, #yiv8778867732 .yiv8778867732footer .yiv8778867732padded a{color:#999;}#yiv8778867732 .yiv8778867732preheader .yiv8778867732title a:hover, #yiv8778867732 .yiv8778867732preheader .yiv8778867732webversion a:hover, #yiv8778867732 .yiv8778867732footer .yiv8778867732padded a:hover{color:#737373;}#yiv8778867732 .yiv8778867732footer .yiv8778867732social .yiv8778867732divider{color:#e9e9e9;}#yiv8778867732 .yiv8778867732footer .yiv8778867732social .yiv8778867732social-text, #yiv8778867732 .yiv8778867732footer .yiv8778867732social a{color:#999;}#yiv8778867732 .yiv8778867732wrapper .yiv8778867732footer .yiv8778867732social .yiv8778867732social-text, #yiv8778867732 .yiv8778867732wrapper .yiv8778867732footer .yiv8778867732social a{}#yiv8778867732 .yiv8778867732wrapper .yiv8778867732footer .yiv8778867732social .yiv8778867732social-text, #yiv8778867732 .yiv8778867732wrapper .yiv8778867732footer .yiv8778867732social a{font-family:'Helvetica Neue', Arial, sans-serif;}#yiv8778867732 .yiv8778867732footer .yiv8778867732social .yiv8778867732social-text, #yiv8778867732 .yiv8778867732footer .yiv8778867732social a{}#yiv8778867732 .yiv8778867732footer .yiv8778867732social .yiv8778867732social-text, #yiv8778867732 .yiv8778867732footer .yiv8778867732social a{letter-spacing:0.05em;}#yiv8778867732 .yiv8778867732footer .yiv8778867732social .yiv8778867732social-text:hover, #yiv8778867732 .yiv8778867732footer .yiv8778867732social a:hover{color:#737373;}#yiv8778867732 .yiv8778867732image .yiv8778867732border{background-color:#c8c8c8;}#yiv8778867732 .yiv8778867732image-frame{background-color:#dadada;}#yiv8778867732 .yiv8778867732image-background{background-color:#f7f7f7;}
		</style>";

        $this->header = "<center id='yui_3_16_0_1_1456745957551_19650' class='yiv8778867732wrapper' style='display:table;table-layout:fixed;width:100%;min-width:650px;background:#0a3254;'>
			<table id='yui_3_16_0_1_1456745957551_19666' class='yiv8778867732preheader yiv8778867732centered' style='border-collapse:collapse;border-spacing:0;Margin-left:auto;Margin-right:auto;'>
				<tbody id='yui_3_16_0_1_1456745957551_19665'>
					<tr id='yui_3_16_0_1_1456745957551_19664'>
						<td id='yui_3_16_0_1_1456745957551_19663' style='padding:10px 0px 10px;vertical-align:top;'>
							<table id='yui_3_16_0_1_1456745957551_19662' style='width:400px;margin:20px auto 0px;border-spacing:0px;line-height:0px;'>
								<tbody id='yui_3_16_0_1_1456745957551_19661'>
									<tr id='yui_3_16_0_1_1456745957551_19660'>
										<td id='yui_3_16_0_1_1456745957551_19659' rowspan='2' style='vertical-align:middle;white-space:nowrap;width:80%;text-align:center;font-weight:bold;font-size:11px;color:#1fbad6;padding:0 10px;' align='center' valign='middle'>
											<div class='yiv8778867732logo-center' style='color:rgb(65, 99, 126);font-family:sans-serif;' id='yiv8778867732emb-email-header' align='center'>
												<img style='width:180px;min-height:51px;display:inline-block;' src='https://www.theteller.net/models/images/logo.png' alt='theteller-logo' height='51' width='180'>
											</div>
											<p style='text-align:center;font-size:10px;font-weight:400;line-height:22px;Margin-bottom:32px;font-family:HelveticaNeue, 'Helvetica Neue', HelveticaNeueRoman, HelveticaNeue-Roman, 'Helvetica Neue Roman', TeXGyreHerosRegular, Helvetica, Tahoma, Geneva, Arial, sans-serif;margin-top:10px;'></p>
										</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
	";

        $this->footer = "<table id='yui_3_16_0_1_1456745957551_19750' class='yiv8778867732centered' style='border-collapse:collapse;border-spacing:0;Margin-left:auto;Margin-right:auto;'>
				<tbody id='yui_3_16_0_1_1456745957551_19749'>
					<tr id='yui_3_16_0_1_1456745957551_19748'>
						<td id='yui_3_16_0_1_1456745957551_19747' style='padding:0;vertical-align:top;'>
							<table id='yui_3_16_0_1_1456745957551_19746' class='yiv8778867732two-col' style='border-collapse:collapse;border-spacing:0;Margin-left:auto;Margin-right:auto;width:600px;background-color:#ffffff;font-size:16px;table-layout:fixed;'>
								<tbody id='yui_3_16_0_1_1456745957551_19745'>
									<tr id='yui_3_16_0_1_1456745957551_19744'>
										
										<td class='yiv8778867732column yiv8778867732first' style='padding:0;vertical-align:bottom;text-align:left;width:300px;'>
											<table class='yiv8778867732contents' style='border-collapse:collapse;border-spacing:0;table-layout:fixed;width:100%;'>
												<tbody>
													<tr>
														<td class='yiv8778867732padded' style='padding:0;vertical-align:top;padding-left:32px;padding-right:32px;word-wrap:break-word;'>
															<p style='Margin-top:3px;font-style:normal;font-size:14px;font-weight:400;line-height:24px;Margin-bottom:32px;font-family:'Helvetica Neue', Arial, sans-serif;color:#073648;'>
																Powered by <font face=''Raleway', Helvetica Neue, Arial, sans-serif'><strong>PaySwitch</strong></font>
															</p>
														</td>
													</tr>
												</tbody>
											</table>
										</td>
		                
										<td id='yui_3_16_0_1_1456745957551_19743' class='yiv8778867732column yiv8778867732second' style='padding:0;vertical-align:top;text-align:left;width:300px;'>
											<table id='yui_3_16_0_1_1456745957551_19742' class='yiv8778867732contents' style='border-collapse:collapse;border-spacing:0;table-layout:fixed;width:100%;'>
												<tbody id='yui_3_16_0_1_1456745957551_19741'>
													<tr id='yui_3_16_0_1_1456745957551_19740'>
														
														<td id='yui_3_16_0_1_1456745957551_19739' class='yiv8778867732padded' style='padding:0;vertical-align:bottom;padding-left:50px;padding-right:20px;word-wrap:break-word;'>
															<p id='yui_3_16_0_1_1456745957551_19738' style='text-align:right;'>
																<a rel='nofollow' style='font-weight:bold;text-decoration:none;color:#999;' target='_blank' href='https://twitter.com/tellerghana'>
																	<img style='border:0;margin:3px;' src='http://www.freepngimg.com/thumb/twitter/2-2-twitter-png-file-thumb.png' height='30'>
																</a>
																<a rel='nofollow' style='font-weight:bold;text-decoration:none;color:#999;' target='_blank' href='https://www.facebook.com/tellerghana'>
																	<img style='border:0;margin:3px;' src='http://www.iconcraze.com/wp-content/uploads/2016/11/ICONCRAZE-COM-Facebook-Icon-PNG.png' height='30'>
																</a>
																<a rel='nofollow' style='font-weight:bold;text-decoration:none;color:#999;' target='_blank' href='https://www.instagram.com/tellerghana/'>
																	<img style='border:0;margin:3px;' src='https://images.vexels.com/media/users/3/137198/isolated/preview/07f0d7b69ef071571e4ada2f4d6a053a-instagram--cone-de-fundo-by-vexels.png' height='30'>
																</a>
															</p>
														</td>
													
													</tr>
												</tbody>
											</table>
										</td>
		                
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		
			<table class='yiv8778867732footer yiv8778867732centered' style='border-collapse:collapse;border-spacing:0;Margin-left:auto;Margin-right:auto;width:602px;'>
				<tbody>
					<tr>
						<td style='padding:0;vertical-align:top;padding-top:10px;padding-bottom:10px;font-family:Helvetica, serif;border-bottom:1px solid #ffffff;' align='center'>
							<table border='0' cellpadding='8' cellspacing='0'>
								<tbody>
									<tr>
										<td style='border-collapse:collapse;' valign='top'>
											<div style='text-align:center;line-height:15px;font-size:12px;color:#f8f7f7;font-family:Arial;'>
												Copyright © 2016 PaySwitch, All Rights Reserved.
												<br>
												<em style='text-align:center;line-height:15px;font-size:12px;color:#f8f7f7;font-family:Arial;'>You are receiving this email because you registered on <a rel='nofollow' style='font-weight:bold;' target='_blank' href=".$this->base_url.">theteller</a> online transaction platform. <br>We love to have you on board!</em>
												<br>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
							<div class='yiv8778867732spacer' style='font-size:1px;line-height:32px;width:100%;'><br></div>
						</td>
					</tr>
				</tbody>
			</table>
		</center>
	";
    }

    public function sendEmail( $userEmail, $from, $subject, $messageBody )
    {
        $headers = "From: " . $from . "\r\n";
        $headers .= "Reply-To: ". $from . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        //send email
        if( mail( $userEmail, $subject, $messageBody, $headers ) == TRUE ){ return TRUE; } else{ return FALSE; }
    }

    public function emailTemplate( $templateName, $userEmail = "", $firstName = "", $lastName = "", $code = "" )
    {
        // Prepare the message body for the account verification email
        if ( $templateName == "Account Verification" )
        {
            $message = "
				{$this->stylesheet}
				{$this->header}
						<table id='yui_3_16_0_1_1456745957551_19704' class='yiv8778867732centered' style='border-collapse:collapse;border-spacing:0;Margin-left:auto;Margin-right:auto;'>
							<tbody id='yui_3_16_0_1_1456745957551_19703'>
								<tr id='yui_3_16_0_1_1456745957551_19702'>
									<td id='yui_3_16_0_1_1456745957551_19701' style='padding:0;vertical-align:top;'>
										
										<table id='yui_3_16_0_1_1456745957551_19700' class='yiv8778867732one-col' style='border-collapse:collapse;border-spacing:0;Margin-left:auto;Margin-right:auto;width:600px;background-color:#ffffff;font-size:14px;table-layout:fixed;'>
											<tbody id='yui_3_16_0_1_1456745957551_19699'>
												<tr id='yui_3_16_0_1_1456745957551_19698'>
													<td id='yui_3_16_0_1_1456745957551_19697' class='yiv8778867732column' style='padding:0;vertical-align:top;text-align:left;'>
														<table id='yui_3_16_0_1_1456745957551_19696' class='yiv8778867732contents' style='border-collapse:collapse;border-spacing:0;table-layout:fixed;width:100%;'>
															<tbody id='yui_3_16_0_1_1456745957551_19695'>
																<tr id='yui_3_16_0_1_1456745957551_19694'>
																	<td id='yui_3_16_0_1_1456745957551_19693' class='yiv8778867732padded' style='padding:0;vertical-align:top;padding:40px 40px 5px;word-wrap:break-word;margin-bottom:40px;'>
																		<table id='yui_3_16_0_1_1456745957551_19692' style='margin-top:-20px;margin-bottom:20px;' border='0' width='100%'>
																			<tbody id='yui_3_16_0_1_1456745957551_19691'>
																				<tr id='yui_3_16_0_1_1456745957551_19690'>
																					
																					<td style='text-align:left;font-size:11px;margin:0;' width='60%'>
																						<span style='color:#999;'>Get in touch +233 (0) 303 979 146</span>
																					</td>
					
																					<td id='yui_3_16_0_1_1456745957551_19689' style='font-size:11px;margin:0px;text-align:right;'>
																						<a id='yui_3_16_0_1_1456745957551_19688' rel='nofollow' target='_blank' href='".$this->base_url."' style='text-decoration:none;'><span id='yui_3_16_0_1_1456745957551_19687' style='text-decoration:underline;color:#08C;'>visit theteller</span></a>
																					</td>
					                              								
																				</tr>
																			</tbody>
																		</table>
																		
																		<div class='yiv8778867732image' style='font-size:0;font-style:normal;font-weight:400;margin-bottom:10px;font-family:Arial, serif;color:#565656;' align='center'>
																			<a rel='nofollow' target='_blank' href=''>
																				<img class='yiv8778867732gnd-corner-image yiv8778867732gnd-corner-image-center yiv8778867732gnd-corner-image-top' style='display:block;width:100%;min-height:auto;' src='https://www.theteller.net/models/others/emailbanner.jpg' alt='PaySwitch: The Payment Hub'>
																			</a>
																		</div>
																		
																		<p style='Margin-top:0;font-style:normal;font-weight:400;font-weight:bold;line-height:24px;margin-bottom:20px;font-family:HelveticaNeue, 'Helvetica Neue', HelveticaNeueRoman, HelveticaNeue-Roman, 'Helvetica Neue Roman', TeXGyreHerosRegular, Helvetica, Tahoma, Geneva, Arial, sans-serif;color:#606060;font-size:20px;'>
																			{$templateName}
																		</p>
																		
																		<p style='Margin-top:0;font-style:normal;font-weight:400;line-height:22px;Margin-bottom:10px;font-family:HelveticaNeue, 'Helvetica Neue', HelveticaNeueRoman, HelveticaNeue-Roman, 'Helvetica Neue Roman', TeXGyreHerosRegular, Helvetica, Tahoma, Geneva, Arial, sans-serif;color:#606060;font-size:16px;text-align:justify;'>
																			<p>Dear {$firstName} {$lastName},</p>
																			Welcome to the <a href='".$this->base_url."'>theteller.</a> 
																			Ghana's leading online payment system! For security reasons, please verify your email to complete your registration.
																		</p> 
																		
																		<p style='Margin-top:0;font-style:normal;font-weight:400;line-height:22px;Margin-bottom:10px;font-family:HelveticaNeue, 'Helvetica Neue', HelveticaNeueRoman, HelveticaNeue-Roman, 'Helvetica Neue Roman', TeXGyreHerosRegular, Helvetica, Tahoma, Geneva, Arial, sans-serif;color:#606060;font-size:16px;text-align:justify;'>
																			<strong>To verify, please click the button below.</strong>
																		</p>
																		
																		<p style='Margin-top:0;font-style:normal;font-weight:400;line-height:22px;Margin-bottom:10px;font-family:HelveticaNeue, 'Helvetica Neue', HelveticaNeueRoman, HelveticaNeue-Roman, 'Helvetica Neue Roman', TeXGyreHerosRegular, Helvetica, Tahoma, Geneva, Arial, sans-serif;color:#606060;font-size:16px;text-align:center;'>
																			<a rel='nofollow' target='_blank' href='".$this->base_url."activation-{$userEmail}-{$code}' style='margin:0;padding:9px 20px 9px;font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;background:#3e90ca;display:inline-block;line-height:1.5;color:#fff;text-decoration:none;font-weight:bold;border-radius:4px;'>
																				Activate your account now
																			</a>
																		</p>
																		
																		<p style='Margin-top:0;font-style:normal;font-weight:400;font-weight:bold;line-height:22px;margin-bottom:10px;font-family:Raleway, HelveticaNeue, 'Helvetica Neue', HelveticaNeueRoman, HelveticaNeue-Roman, 'Helvetica Neue Roman', TeXGyreHerosRegular, Helvetica, Tahoma, Geneva, Arial, sans-serif;color:#606060;font-size:20px;'>
																			Or copy and paste the link below in to your web browser:
																		</p>
																		<a href=".$this->base_url."activation-{$userEmail}-{$code}>".$this->base_url."activation-{$userEmail}-{$code}</a>
																		
																		<p style='Margin-top:20px;font-style:normal;font-weight:400;font-weight:bold;line-height:22px;margin-bottom:10px;font-family:Raleway, HelveticaNeue, 'Helvetica Neue', HelveticaNeueRoman, HelveticaNeue-Roman, 'Helvetica Neue Roman', TeXGyreHerosRegular, Helvetica, Tahoma, Geneva, Arial, sans-serif;color:#606060;font-size:20px;'><font face=''Raleway', Helvetica Neue, Arial, sans-serif'>
																			Note: Please do not reply to this email message. The message was sent from a notification-only address that cannot accept incoming email</font>
																		</p>
																	</td>
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
							</tbody>
						</table>
				{$this->footer}";
            return $message;
        }

        // Prepaer the message body for the password reset request email
        else if ( $templateName == "Reset Password" )
        {
            // template asking the user to activate their account.
            $message = "
				{$this->stylesheet}
				{$this->header}
						<table id='yui_3_16_0_1_1456745957551_19704' class='yiv8778867732centered' style='border-collapse:collapse;border-spacing:0;Margin-left:auto;Margin-right:auto;'>
							<tbody id='yui_3_16_0_1_1456745957551_19703'>
								<tr id='yui_3_16_0_1_1456745957551_19702'>
									<td id='yui_3_16_0_1_1456745957551_19701' style='padding:0;vertical-align:top;'>
										
										<table id='yui_3_16_0_1_1456745957551_19700' class='yiv8778867732one-col' style='border-collapse:collapse;border-spacing:0;Margin-left:auto;Margin-right:auto;width:600px;background-color:#ffffff;font-size:14px;table-layout:fixed;'>
											<tbody id='yui_3_16_0_1_1456745957551_19699'>
												<tr id='yui_3_16_0_1_1456745957551_19698'>
													<td id='yui_3_16_0_1_1456745957551_19697' class='yiv8778867732column' style='padding:0;vertical-align:top;text-align:left;'>
														<table id='yui_3_16_0_1_1456745957551_19696' class='yiv8778867732contents' style='border-collapse:collapse;border-spacing:0;table-layout:fixed;width:100%;'>
															<tbody id='yui_3_16_0_1_1456745957551_19695'>
																<tr id='yui_3_16_0_1_1456745957551_19694'>
																	<td id='yui_3_16_0_1_1456745957551_19693' class='yiv8778867732padded' style='padding:0;vertical-align:top;padding:40px 40px 5px;word-wrap:break-word;margin-bottom:40px;'>
																		<table id='yui_3_16_0_1_1456745957551_19692' style='margin-top:-20px;margin-bottom:20px;' border='0' width='100%'>
																			<tbody id='yui_3_16_0_1_1456745957551_19691'>
																				<tr id='yui_3_16_0_1_1456745957551_19690'>
																					
																					<td style='text-align:left;font-size:11px;margin:0;' width='60%'>
																						<span style='color:#999;'>Get in touch +233 (0) 303 979 146</span>
																					</td>
					
																					<td id='yui_3_16_0_1_1456745957551_19689' style='font-size:11px;margin:0px;text-align:right;'>
																						<a id='yui_3_16_0_1_1456745957551_19688' rel='nofollow' target='_blank' href='".$this->base_url."' style='text-decoration:none;'><span id='yui_3_16_0_1_1456745957551_19687' style='text-decoration:underline;color:#08C;'>visit theteller</span></a>
																					</td>
					                              								
																				</tr>
																			</tbody>
																		</table>
																		
																		<div class='yiv8778867732image' style='font-size:0;font-style:normal;font-weight:400;margin-bottom:10px;font-family:Arial, serif;color:#565656;' align='center'>
																			<a rel='nofollow' target='_blank' href=''>
																				<img class='yiv8778867732gnd-corner-image yiv8778867732gnd-corner-image-center yiv8778867732gnd-corner-image-top' style='display:block;width:100%;min-height:auto;' src='https://www.theteller.net/models/others/emailbanner.jpg' alt='PaySwitch: The Payment Hub'>
																			</a>
																		</div>
																		
																		<p style='Margin-top:0;font-style:normal;font-weight:400;font-weight:bold;line-height:24px;margin-bottom:20px;font-family:HelveticaNeue, 'Helvetica Neue', HelveticaNeueRoman, HelveticaNeue-Roman, 'Helvetica Neue Roman', TeXGyreHerosRegular, Helvetica, Tahoma, Geneva, Arial, sans-serif;color:#606060;font-size:20px;'>
																			{$templateName}
																		</p>
																		
																		<p style='Margin-top:0;font-style:normal;font-weight:400;line-height:22px;Margin-bottom:10px;font-family:HelveticaNeue, 'Helvetica Neue', HelveticaNeueRoman, HelveticaNeue-Roman, 'Helvetica Neue Roman', TeXGyreHerosRegular, Helvetica, Tahoma, Geneva, Arial, sans-serif;color:#606060;font-size:16px;text-align:justify;'>
																			<p>Dear {$firstName} {$lastName},</p>
																			You have recently requested to reset your password for your account at <a href='".$this->base_url."'>theteller</a>.
																		</p> 
																		
																		<p style='Margin-top:0;font-style:normal;font-weight:400;line-height:22px;Margin-bottom:10px;font-family:HelveticaNeue, 'Helvetica Neue', HelveticaNeueRoman, HelveticaNeue-Roman, 'Helvetica Neue Roman', TeXGyreHerosRegular, Helvetica, Tahoma, Geneva, Arial, sans-serif;color:#606060;font-size:16px;text-align:justify;'>
																			Click the button below to reset your password:
																		</p>
																		
																		<p style='Margin-top:0;font-style:normal;font-weight:400;line-height:22px;Margin-bottom:10px;font-family:HelveticaNeue, 'Helvetica Neue', HelveticaNeueRoman, HelveticaNeue-Roman, 'Helvetica Neue Roman', TeXGyreHerosRegular, Helvetica, Tahoma, Geneva, Arial, sans-serif;color:#606060;font-size:16px;text-align:center;'>
																			<a rel='nofollow' target='_blank' href='".$this->base_url."reset-password-{$userEmail}-{$code}' style='margin:0;padding:9px 20px 9px;font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;background:#3e90ca;display:inline-block;line-height:1.5;color:#fff;text-decoration:none;font-weight:bold;border-radius:4px;'>
																				Reset Your Password Now
																			</a>
																		</p>
																		
																		<p style='Margin-top:0;font-style:normal;font-weight:400;font-weight:bold;line-height:22px;margin-bottom:10px;font-family:Raleway, HelveticaNeue, 'Helvetica Neue', HelveticaNeueRoman, HelveticaNeue-Roman, 'Helvetica Neue Roman', TeXGyreHerosRegular, Helvetica, Tahoma, Geneva, Arial, sans-serif;color:#606060;font-size:20px;'>
																			Or copy and paste the link below in to your web browser:
																		</p>
																		<a href='".$this->base_url."reset-password-{$userEmail}-{$code}'>href='".$this->base_url."reset-password-{$userEmail}-{$code}'</a>
																		
																		<p style='Margin-top:0;font-style:normal;font-weight:400;font-weight:bold;line-height:22px;margin-bottom:10px;font-family:Raleway, HelveticaNeue, 'Helvetica Neue', HelveticaNeueRoman, HelveticaNeue-Roman, 'Helvetica Neue Roman', TeXGyreHerosRegular, Helvetica, Tahoma, Geneva, Arial, sans-serif;color:#606060;font-size:20px;'>
																			If you did not request a password reset, please ignore this email or reply to let us know. This password link is only valid for the next 30 minutes.
																		</p>
																		
																		<p style='Margin-top:20px;font-style:normal;font-weight:400;font-weight:bold;line-height:22px;margin-bottom:10px;font-family:Raleway, HelveticaNeue, 'Helvetica Neue', HelveticaNeueRoman, HelveticaNeue-Roman, 'Helvetica Neue Roman', TeXGyreHerosRegular, Helvetica, Tahoma, Geneva, Arial, sans-serif;color:#606060;font-size:20px;'><font face=''Raleway', Helvetica Neue, Arial, sans-serif'>
																			Note: Please do not reply to this email message. The message was sent from a notification-only address that cannot accept incoming email</font>
																		</p>
																	</td>
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
							</tbody>
						</table>
				{$this->footer}";
            return $message;
        }
    }
    // Email_Template end.
}