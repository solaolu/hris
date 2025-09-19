
            $('.delete-item').click(function(){
                var resp = confirm("Are you sure you want to delete this item?");
                if (!resp){
                    event.preventDefault();
                }
            });