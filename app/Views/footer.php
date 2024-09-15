<footer>

</footer>

</body>

</html>

<script>
    $(document).ready(function() {
        var company_frm = $("#company_frm");
        var company_btn = $("#company_btn");

        company_btn.click(function() {
            company_frm.ajaxForm({
                beforeSend: function() {
                    company_btn.prop('disabled', true);
                },
                success: function(data) {
                    company_btn.prop('disabled', false);
                    var resp = data.split('::');

                    if(resp[0]==200){
                        Swal.fire({
                            title: "Good job!",
                            text: resp[1],
                            icon: "success"
                        }).then(()=>{
                            window.location.reload();
                        })
                    }
                    else{
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: resp[1],
                        });
                    }
                },
                error: function(err) {
                    company_btn.prop('disabled', false);
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Something went wrong!",
                    });
                }
            })
        });
    });

    function validateNumberInput(input) {
        input.value = input.value.replace(/[^0-9]/g, '');
    }

    function validateAlphabetInput(input) {
        input.value = input.value.replace(/[^a-zA-Z\s]/g, '');
        input.value = input.value.replace(/\s{2,}/g, ' ');
    }
</script>