<!DOCTYPE html>
<html lang="en">
<head>
<title>Forgot Password Link</title>
<style>
	 body {-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; margin: 0; padding: 0; }
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
				<table width="600" cellpadding="0" cellspacing="0" border="0" align="center">
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
							<td width="100%" height="10"></td>
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
				<table width="600" cellpadding="0" cellspacing="0" border="0" align="center" bgcolor="#FFFFFF" style="border: 1px solid #E7E7E7 ;border-radius: 5px;">
					<tbody>
						<!-- Spacing -->
						<tr height="40px">
							<td width="100%" colspan="3"></td>
						</tr>
						<!-- Spacing -->
						<tr>
							<td width="7%"></td>
							<td width="86%">
								<h3 style="color: #9B9B9B !important;font-family: helvetica,sans-serif,arial;"><strong>Hello </strong><em><?php echo (@$user_email)?$user_email:''; ?>,</em></h3>
							</td>
							<td width="7%"></td>
						</tr>
						<!-- Spacing -->
						<tr height="20px">
							<td width="100%" colspan="3"></td>
						</tr>
						<!-- Spacing -->
						<tr>
							<td width="7%"></td>
							<td width="86%">
								<p style="color: #9B9B9B;font-family: helvetica,sans-serif,arial; font-size:14px;">
									Click on the following link to recover your password. <a href="<?php echo (@$recovery_key)?$recovery_key:'';?>" style="color: #1E71C5 !important;"><strong>Password Recovery Link</strong></a>
								</p>
								<p style="color: #9B9B9B;font-family: helvetica,sans-serif,arial; font-size:14px;">
									<span style="color: #9B9B9B !important; font-family: helvetica,sans-serif,arial; font-size:14px;">If the above link is not working then copy and paste the below URL into your browser to activate your account.<br><br></span>
									<span><?php echo (@$recovery_key)?$recovery_key:''; ?></span>
								</p>
							</td>
							<td width="7%"></td>
						</tr>
						<!-- Spacing -->
						<tr height="20px">
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
						<tr height="50px">
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