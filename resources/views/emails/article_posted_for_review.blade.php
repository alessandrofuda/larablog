<!DOCTYPE html>

<html>

<head>
	<title>Notifica da Larablog: un articolo è stato inviato per la revisione</title>
</head>


<body>
	<p>
		<div>
			L'utente <strong>{{ $userSenderFirstName }} {{ $userSenderLastName }}</strong> ha inviato un nuovo articolo per la revisione/pubblicazione.
		</div>
	</p>

	<p>
		<div>- Id utente: {{ $userSenderId }}</div>
		<div>- Titolo articolo: {{ $articleTitle }}</div>
		<div>- Inviato per la revisione il: <strong>{{ $articleDate }}</strong> alle <strong>{{ $articleHours }}</strong></div>
	</p>

	<p>
		<div>
			<a href="{{ url('backend/articles/edit/' . $articleId ) }}">Vai al link per la revisione e pubblicazione</a>
		</div>
	</p>
</body>
</html>



