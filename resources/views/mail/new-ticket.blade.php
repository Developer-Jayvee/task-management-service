<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="color-scheme" content="light">
	<title>New ticket assigned</title>
	<style>
		body {
			margin: 0;
			padding: 0;
			background-color: #f3f6fb;
			color: #172033;
			font-family: Arial, Helvetica, sans-serif;
			-webkit-text-size-adjust: 100%;
		}

		table {
			border-collapse: collapse;
		}

		@media only screen and (max-width: 620px) {
			.email-shell {
				width: 100% !important;
			}

			.content-cell {
				padding: 28px 22px !important;
			}

			.ticket-title {
				font-size: 23px !important;
			}
		}
	</style>
</head>
<body style="margin:0; padding:0; background-color:#f3f6fb;">
	<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f3f6fb;">
		<tr>
			<td align="center" style="padding:36px 14px;">
				<table role="presentation" class="email-shell" width="600" cellpadding="0" cellspacing="0" border="0" style="width:600px; max-width:600px; background-color:#ffffff; border:1px solid #e5eaf2; border-radius:14px; overflow:hidden;">
					<tr>
						<td style="height:6px; background-color:#4f46e5; font-size:0; line-height:0;">&nbsp;</td>
					</tr>
					<tr>
						<td style="padding:26px 36px 18px;">
							<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
								<tr>
									<td style="font-size:13px; font-weight:bold; letter-spacing:1.2px; color:#4f46e5; text-transform:uppercase;">
										Task Management
									</td>
									<td align="right" style="font-size:12px; color:#8290a5;">
										Ticket notification
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td class="content-cell" style="padding:20px 36px 36px;">
							<div style="display:inline-block; margin-bottom:18px; padding:7px 11px; border-radius:20px; background-color:#eef2ff; color:#4338ca; font-size:12px; font-weight:bold;">
								NEW TICKET ASSIGNED
							</div>

							<h1 class="ticket-title" style="margin:0 0 12px; color:#172033; font-size:28px; line-height:1.3;">
								{{ $ticket->title ?? 'A new ticket is waiting for you' }}
							</h1>

							<p style="margin:0 0 24px; color:#5d687b; font-size:15px; line-height:1.7;">
								Hello {{ $user->name ?? 'there' }}, a new ticket has been assigned to you. Review the details below and take the next step when you’re ready.
							</p>

							<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:24px; border:1px solid #e8edf5; border-radius:10px;">
								<tr>
									<td colspan="2" style="padding:16px 18px; background-color:#f8faff; border-bottom:1px solid #e8edf5; color:#27334a; font-size:14px; font-weight:bold;">
										Ticket details
									</td>
								</tr>
								<tr>
									<td width="34%" style="padding:13px 18px; border-bottom:1px solid #edf0f5; color:#8290a5; font-size:13px;">Ticket ID</td>
									<td style="padding:13px 18px; border-bottom:1px solid #edf0f5; color:#27334a; font-size:13px; font-weight:bold;">#{{ $ticket->id ?? '—' }}</td>
								</tr>
								<tr>
									<td style="padding:13px 18px; border-bottom:1px solid #edf0f5; color:#8290a5; font-size:13px;">Status</td>
									<td style="padding:13px 18px; border-bottom:1px solid #edf0f5; color:#27334a; font-size:13px;">{{ $ticket->status ?? 'Open' }}</td>
								</tr>
								<tr>
									<td style="padding:13px 18px; border-bottom:1px solid #edf0f5; color:#8290a5; font-size:13px;">Priority</td>
									<td style="padding:13px 18px; border-bottom:1px solid #edf0f5; color:#27334a; font-size:13px;">{{ $ticket->priority ?? 'Not set' }}</td>
								</tr>
								<tr>
									<td style="padding:13px 18px; color:#8290a5; font-size:13px;">Due date</td>
									<td style="padding:13px 18px; color:#27334a; font-size:13px;">{{ $ticket->due_date ?? 'Not set' }}</td>
								</tr>
							</table>

							@if(!empty($ticket->description))
								<div style="margin-bottom:26px; padding:16px 18px; border-left:3px solid #c7d2fe; background-color:#f8faff;">
									<p style="margin:0 0 7px; color:#8290a5; font-size:12px; font-weight:bold; letter-spacing:.5px; text-transform:uppercase;">Description</p>
									<p style="margin:0; color:#4d596d; font-size:14px; line-height:1.7;">{{ $ticket->description }}</p>
								</div>
							@endif

							<table role="presentation" cellpadding="0" cellspacing="0" border="0">
								<tr>
									<td align="center" style="border-radius:8px; background-color:#4f46e5;">
										<a href="{{ $ticketUrl ?? url('/') }}" style="display:inline-block; padding:13px 21px; color:#ffffff; font-size:14px; font-weight:bold; text-decoration:none;">View ticket</a>
									</td>
								</tr>
							</table>

							<p style="margin:24px 0 0; color:#8290a5; font-size:13px; line-height:1.6;">
								If the button doesn’t work, sign in to your task workspace to view this ticket.
							</p>
						</td>
					</tr>
					<tr>
						<td style="padding:20px 36px; border-top:1px solid #edf0f5; background-color:#fbfcfe; color:#98a2b3; font-size:12px; line-height:1.6; text-align:center;">
							This is an automated notification. Please do not reply to this email.<br>
							&copy; {{ date('Y') }} Task Management
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>
