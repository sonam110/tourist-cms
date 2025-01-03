<html>
<head>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<style type="text/css">
		@import url('https://fonts.googleapis.com/css?family=Roboto+Condensed&display=swap');

		body {
			font-family: 'Roboto Condensed', sans-serif;
			color: #000;
		}

		.table table {
			border-collapse: collapse;
			width: 100%;
			color: #000;
		}

		.table th, .table td {
			text-align: left;
			padding: 8px;
			border-top: 1px solid #428b9f;
			color: #000;
		}

		.table tr:nth-child(even) {
			background-color: #2d4046;
		}
	</style>
</head>
<body>
	<table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#fff">
		<tr>
			<td>
				<table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#632ca6" style="padding-bottom: 30px;padding: 1px; font-family: 'Roboto Condensed', sans-serif;">
					<tr>
						<td>
							<table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#fff" style="padding: 15px 15px 0px 15px; font-family: 'Roboto Condensed', sans-serif;">
								<tr>
									<td>
										<table cellspacing="0" border="0" cellpadding="0" width="100%">
											<tr>
												<td>
													<div style="padding: 22px; font-family: 'Roboto Condensed', sans-serif;">
														<center style="color: #000; font-size: 18px; font-family: 'Roboto Condensed', sans-serif;">

															<!-- Head section -->
															{!! $mailObj['mail_subject'] !!}  for TI-MUNDO - Ramta Yogi
														</center>
													</div>
												</td>
											</tr>
										</table>
										<br>
										<div style="border-bottom: 1px solid #632ca6;width: 96%; text-align: center; margin-left: 15px; margin-bottom: 15px;"></div>

										<table cellspacing="0" border="0" cellpadding="0" width="100%" style="padding: 15px 15px 0px 15px; font-family: 'Roboto Condensed', sans-serif;">

											<tr>
												<td colspan="2" style="color: #000; font-family: 'Roboto Condensed', sans-serif;">

													<!-- Body section -->
													{!! $mailObj['mail_body'] !!}
													<br/>

													@if((array_key_exists('image_path', $mailObj)) && (!empty($mailObj['image_path'])))
													<?php $path = env('APP_URL').'/'.$mailObj['image_path'] ?>
													<img src="{{ $path }}"  width="100%">
													@endif


												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

</body>
</html>