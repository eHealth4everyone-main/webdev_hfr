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
           //if lga change fill wards
           $('#lga').change(function(){
            if($(this).val() != '')
            {
                var lgaID= $('#lga').val();
                var stateID= $('#state').val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"{{route('sign.fetchWards')}}",
                    method:"POST",
                    data:{lgaId:lgaID,stateId:stateID, _token:_token},
                    success:function(result)
                    {
                        $('#ward').html(result);
                    }         
                })
            }
        });
         
        
        // $('#state').change(function(){
        //     $('#lga').val('');
        //     $('#lga')
        //     .find('option')
        //     .remove()
        //     .end();
        //     $('#ward')
        //     .find('option')
        //     .remove()
        //     .end();
        // });
        
        // $('#lga').change(function(){
        //     $('#ward')
        //     .find('option')
        //     .remove()
        //     .end();
        // });
        
       


    });
</script>