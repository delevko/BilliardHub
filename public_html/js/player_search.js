function player_search()
{
    var input, filter, table, tr, td, i, txtValue, ul, li, a;
    input = document.getElementById("player_input");
    filter = input.value.toUpperCase();

    table = document.getElementById("table_list");
    tr = table.getElementsByTagName("tr");
    
	ul = document.getElementById("table_bars");
    li = ul.getElementsByTagName('li');

    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1];
        
        if(td) {
            txtValue = td.textContent || td.innerText;
            
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        } 
    }

    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("h4")[0];
        txtValue = a.textContent || a.innerText;
        
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "flex";
        } else {
            li[i].style.display = "none";
        }
    }
}

function openTab(evt, tabName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(tabName).style.display = "flex";
    evt.currentTarget.className += " active";
}

