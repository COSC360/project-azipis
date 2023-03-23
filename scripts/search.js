$('#searchbar').keyup(function(event) {
    if (event.which === 13)
    {
        event.preventDefault();
        $('#searchForm').submit();
    }
});