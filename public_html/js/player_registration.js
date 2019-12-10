
function unregister(tournID) {
	var _title = "Відмінити реєстрацію в турнірі?";
	var _content = "";
	$.confirm({
	    title: _title,
	    boxWidth: '70%',
	    useBootstrap: false,
	    theme: 'supervan',
	    content: _content,
	    buttons: {
		confirm: {
		    text: 'TAK - ENTER',
		    keys: ['enter'],
		    action: function() {
			window.location.href = ("http://billiardhub.net/player/unregister.php?id="+tournID);
		    }
		},
		cancel: {
		    text: 'НІ - ESC',
		    keys: ['esc'],
		    action: function() { }
		}
	    }
	});
}

function register(tournID) {
	var _title = "Зареєструватись в турнірі?";
	var _content = "";
	$.confirm({
	    title: _title,
	    boxWidth: '70%',
	    useBootstrap: false,
	    theme: 'supervan',
	    content: _content,
	    buttons: {
		confirm: {
		    text: 'TAK - ENTER',
		    keys: ['enter'],
		    action: function() {
			window.location.href = ("http://billiardhub.net/player/register.php?id="+tournID);
		    }
		},
		cancel: {
		    text: 'НІ - ESC',
		    keys: ['esc'],
		    action: function() { }
		}
	    }
	});
}
