function stopMatch(tableID)
{
    var _title = "Ви дійсно бажаєте зупинити матч?";
    var _content = "Всі введені дані матчу буде видалено";

    var form = $('<form action="tableLobby.php" method="POST">' + 
	'<input type="hidden" name="id" value="' + tableID + '"/>' +
	'<input type="hidden" name="reset"/>' +
	'</form>');


    $.confirm({
	title: _title,
	type: 'red',
	boxWidth: '30%',
	useBootstrap: false,
	theme: 'dark',
	content: _content,
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


function stopSparring(tableID)
{
    var _title = "Ви дійсно бажаєте зупинити спаринг?";
    var _content = "Всі введені дані матчу буде видалено";

    var form = $('<form action="tableLobby.php" method="POST">' + 
	'<input type="hidden" name="id" value="' + tableID + '"/>' +
	'<input type="hidden" name="sparringReset"/>' +
	'</form>');


    $.confirm({
	title: _title,
	type: 'red',
	boxWidth: '30%',
	useBootstrap: false,
	theme: 'dark',
	content: _content,
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
