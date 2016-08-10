<?php echo $this->element('Email/head');?>
<html>
<body>
<?php echo $this->element('Email/header');?>
<table width="100%" bgcolor="#f6f4f5" cellpadding="0" cellspacing="0" border="0">
	<tbody>
		<tr>
			<td>
				<div class="innerbg">
				</div>
				<table bgcolor="#ffffff" width="580" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
					<tbody>
						<!-- Spacing -->

						<tr>
							<td width="100%" height="30">
							</td>
						</tr>
						<!-- Spacing -->

						<tr>
							<td>
								<table width="540" align="center" cellpadding="0" cellspacing="0" border="0" class="devicewidthinner">
									<tbody>
										<!-- Title -->

										<tr>
											<td style="font-family: Helvetica, arial, sans-serif; font-size: 18px; color: #333333; text-align:center;line-height: 20px;">
												<p>
													Welcome, <?php echo $user->full_name;?>!
												</p>
											</td>
										</tr>
										<!-- End of Title -->

										<!-- spacing -->

										<tr>
											<td height="5">
											</td>
										</tr>
										<!-- End of spacing -->

										<!-- content -->

										<tr>
											<td style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #95a5a6; text-align:center;line-height: 30px;">
												<p>
													Please activate your account by clicking on the button below.
												</p>
											</td>
										</tr>
										<!-- End of content -->

										<!-- Spacing -->

										<tr>
											<td width="100%" height="10">
											</td>
										</tr>
										<!-- Spacing -->

										<!-- button -->

										<tr>
											<td>
												<div class="buttonbg">
												</div>
												<table height="36" align="center" valign="middle" border="0" cellpadding="0" cellspacing="0" class="tablet-button" style=" background-color:#0db9ea; border-top-left-radius:4px; border-bottom-left-radius:4px;border-top-right-radius:4px; border-bottom-right-radius:4px; background-clip: padding-box;font-size:13px; font-family:Helvetica, arial, sans-serif; text-align:center;  color:#ffffff; font-weight: 300; padding-left:25px; padding-right:25px;">
													<tbody>
														<tr>
															<td style="padding-left:18px; padding-right:18px;font-family:Helvetica, arial, sans-serif; text-align:center;  color:#ffffff; font-weight: 300;" width="auto" align="center" valign="middle" height="36">
																<a target="_blank" href="<?= $appHome .  'users/activate/' . $user->id . '/'. $activation_id; ?>"> <span style="color: #ffffff; font-weight: 300;">Activate now! <p></p></span></a>
															</td>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
										<!-- /button -->

										<!-- Spacing -->

										<tr>
											<td width="100%" height="30">
											</td>
										</tr>
										<!-- Spacing -->

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
<?php echo $this->element('Email/disclaimer');?>
<?php echo $this->element('Email/footer');?>
</body>
</html>