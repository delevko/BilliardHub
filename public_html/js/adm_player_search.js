function player_search()
{
    var input, filter, table, tr, td, i, txtValue, ul, li, a;
    input = document.getElementById("player_input");
    filter = input.value.toUpperCase();

    ul = document.getElementById("table_bars");
    li = ul.getElementsByTagName('li');

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

