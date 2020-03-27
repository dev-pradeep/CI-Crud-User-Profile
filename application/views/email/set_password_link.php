<!DOCTYPE html>
<html lang="en">
<head>
<title>JVJumpStart</title>
<style>
body {-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; margin: 0; padding: 0;}
img { outline: none; text-decoration: none; border: none; }
a img { border: none; }
a { text-decoration: none !important; }
h3{ margin:0px !important; padding: 0px !important; font-weight: normal;  }
table, table td { border-collapse: collapse; }
</style>
</head>
<body>
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #EFEFEF;">
    <tbody>
        <tr>
            <td>
				<table width="650" cellpadding="0" cellspacing="0" border="0" align="center">
					<tbody>
						<!-- Spacing -->
						<tr>
							<td width="100%" height="20"></td>
						</tr>
						<!-- Spacing -->
						<tr>
							<td>
								<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
									<tbody>
										<tr>
											<td align="center" valign="middle"><a href="" target="_blank" style=""><img src="<?php echo $logo; ?>" width="200px"/></a></td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<!-- Spacing -->
						<tr>
							<td width="100%" height="20"></td>
						</tr>
						<!-- Spacing -->
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #EFEFEF;">
    <tbody>
        <tr>
            <td>
				<table width="650" cellpadding="0" cellspacing="0" border="0" align="center" bgcolor="#FFFFFF" style="border: 1px solid #E7E7E7 ;border-radius: 5px;">
					<tbody>
						<!-- Spacing -->
						<tr height="40px">
							<td width="100%" colspan="3"></td>
						</tr>
						<!-- Spacing -->
						<tr>
							<td width="7%">&nbsp;</td>
							<td width="86%">
								<h3 style="color: #9B9B9B !important; font-family: helvetica,sans-serif,arial; ">Hello&nbsp;<em><?php echo (@$usersname)? $usersname:''; ?>,</em></h3>
							</td>
							<td width="7%"></td>
						</tr>
						<!-- Spacing -->
						<tr height="10px">
							<td width="100%" colspan="3"></td>
						</tr>
						<!-- Spacing -->
						<tr>
							<td width="7%"></td>
							<td width="86%">
							<p style="margin: 10px 0; color: #9B9B9B; font-family: helvetica,sans-serif,arial; font-size:14px;">
									Congratulations! We'd like to welcome you as the newest member of the .
								</p>								
								<p style="margin: 0px 0; color: #9B9B9B; font-family: helvetica,sans-serif,arial; font-size:14px;">
									Click here to set password:
								</p><br>
								<p><a href="<?php echo( ($SetPasswordUrl ? $SetPasswordUrl :''));?>" style="background: #209420;padding: 11px 20px 13px 30px;border: 2px;color: white;text-decoration: none;"> Set Password</a></p><br>
								<p style="margin: 2px 0; color: #9B9B9B; font-family: helvetica,sans-serif,arial; font-size:14px;">
									<b>URL : </b> <?php echo( ($SetPasswordUrl ? $SetPasswordUrl :''));?>
								</p>
								<p style="margin: 10px 0; color: #9B9B9B; font-family: helvetica,sans-serif,arial; font-size:14px;">
									<b>Login ID:</b> <?php echo( ($user_email ? $user_email :''));?>
								</p>								
							</td>
							<td width="7%"></td>
						</tr>
						<!-- Spacing -->
						<tr height="5px">
							<td width="100%" colspan="3"></td>
						</tr>
						<!-- Spacing -->
						<tr>
							<td width="7%"></td>
							<td width="86%">
								<p style="color: #9B9B9B !important;font-family: helvetica,sans-serif,arial; font-size:14px;">Thanks,</p>
								<p style="color: #9B9B9B !important;font-family: helvetica,sans-serif,arial; font-size:14px;">The <?php echo $appname; ?> team</p>
							</td>
							<td width="7%"></td>
						</tr>
						<!-- Spacing -->
						<tr height="40px">
							<td width="100%" colspan="3"></td>
						</tr>
						<!-- Spacing -->
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>
<table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#EFEFEF">
    <tbody>
        <tr height="50px">
			<td width="100%"></td>
		</tr>
	</tbody>
</table>
</body>
</html>