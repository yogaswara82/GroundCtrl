<script src="assets/js/jquery.min.js"></script>
<script>
  $.ajax({ 
    type: 'GET', 
    url: 'http://localhost/AzureLane/areaCode.php?lat=-10.104036&lon=113.073914', 
    data: { get_param: 'value' }, 
    dataType: 'json',
    success: function (data) { 
        $.each(data, function(index, element) {
            $('body').append($('<div>', {
                text: element.name
            }));
        });
    }
});  
</script>
    