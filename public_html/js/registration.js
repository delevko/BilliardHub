function unregister(tournamentID, playerID)
{
    var name = $("#"+playerID).html();

    var msg1 = "Відмінити реєстрацію гравця ";
    var msg2 = " в турнірі?";

    var form = $('<form action="playerUnregister.php" method="POST">' + 
	'<input type="hidden" name="tournament" value="' + tournamentID + '"/>' +
	'<input type="hidden" name="player" value="' + playerID + '"/>' +
	'</form>');


    $.confirm({
	title: "Відміна реєстрації",
	type: 'red',
	boxWidth: '30%',
	useBootstrap: false,
	theme: 'dark',
	content: msg1+name+msg2,
	buttons: {
	    confirm: {
		btnClass: 'btn-green',
		text: 'TAK',
		keys: ['enter'],
		action: function() {
		    $('body').append(form);
		    form.submit();
	        }
	    },
	    cancel: {
		text: 'НІ',
		keys: ['esc'],
		function() { }
	    }
	}
    });
}
