
<script>
    $(document).ready(function(){
        //if state change fill lga
        $('#state').change(function(){
            if($(this).val() != '')
            {
                var stateID= $('#state').val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"{{route('sign.fetchLga')}}",
                    method:"POST",
                    data:{id:stateID, _token:_token},
                    success:function(result)
                    {
                        $('#lga').html(result);
                    }         
                })
            }
        });
           


    });
</script>