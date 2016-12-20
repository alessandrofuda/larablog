<!doctype html> 


<html>

	<head>
		<title>Notifica da Larablog: registrazione nuovo utente avvenuta con successo</title>
	</head>

	<body>
		<p>
			<div>
				Un nuovo utente si è registrato a Larablog.
			</div>
		</p>

		<p>
			<div>- Nome utente: {{ $user['first_name'] }}</div>
			<div>- Cognome utente: {{ $user['last_name'] }}</div>
			<div>- Email: {{ $user['email'] }}</div>

			<div>- Data di registrazione: {{ $data }}</div>
			<div>- Indirizzo IP: {{ $ip }}</div>
		</p>

		<p>
			<div>
				<a href="{{ url('backend/users') }}">Vai all'elenco di tutti gli utenti iscritti</a>
			</div>
		</p>
	</body>

</html>