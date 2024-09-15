<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Signup</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://malsup.github.io/jquery.form.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<style>
    @import url('https://fonts.googleapis.com/css?family=Raleway:400,700');

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: Raleway, sans-serif;
    }

    body {
        background: linear-gradient(90deg, #C7C5F4, #776BCC);
    }

    .container {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
    }

    .screen {
        background: linear-gradient(90deg, #5D54A4, #7C78B8);
        position: relative;
        height: 600px;
        width: 360px;
        box-shadow: 0px 0px 24px #5C5696;
    }

    .screen__content {
        z-index: 1;
        position: relative;
        height: 100%;
    }

    .screen__background {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 0;
        -webkit-clip-path: inset(0 0 0 0);
        clip-path: inset(0 0 0 0);
    }

    .screen__background__shape {
        transform: rotate(45deg);
        position: absolute;
    }

    .screen__background__shape1 {
        height: 520px;
        width: 520px;
        background: #FFF;
        top: -50px;
        right: 120px;
        border-radius: 0 72px 0 0;
    }

    .screen__background__shape2 {
        height: 220px;
        width: 220px;
        background: #6C63AC;
        top: -172px;
        right: 0;
        border-radius: 32px;
    }

    .screen__background__shape3 {
        height: 540px;
        width: 190px;
        background: linear-gradient(270deg, #5D54A4, #6A679E);
        top: -24px;
        right: 0;
        border-radius: 32px;
    }

    .screen__background__shape4 {
        height: 400px;
        width: 200px;
        background: #7E7BB9;
        top: 420px;
        right: 50px;
        border-radius: 60px;
    }

    .signup {
        width: 320px;
        padding: 30px;
        padding-top: 156px;
    }

    .signup__field {
        padding: 20px 0px;
        position: relative;
    }

    .signup__icon {
        position: absolute;
        top: 30px;
        color: #7875B5;
    }

    .signup__input {
        border: none;
        border-bottom: 2px solid #D1D1D4;
        background: none;
        padding: 10px;
        padding-left: 24px;
        font-weight: 700;
        width: 75%;
        transition: .2s;
    }

    .signup__input:active,
    .signup__input:focus,
    .signup__input:hover {
        outline: none;
        border-bottom-color: #6A679E;
    }

    .signup__submit {
        background: #fff;
        font-size: 14px;
        margin-top: 30px;
        padding: 16px 20px;
        border-radius: 26px;
        border: 1px solid #D4D3E8;
        text-transform: uppercase;
        font-weight: 700;
        display: flex;
        align-items: center;
        width: 100%;
        color: #4C489D;
        box-shadow: 0px 2px 2px #5C5696;
        cursor: pointer;
        transition: .2s;
    }

    .signup__submit:active,
    .signup__submit:focus,
    .signup__submit:hover {
        border-color: #6A679E;
        outline: none;
    }

    .button__icon {
        font-size: 24px;
        margin-left: auto;
        color: #7875B5;
    }

</style>

<body>
    <div class="container">
        <div class="screen">
            <div class="screen__content">
                <form class="signup" id="signup_frm" action="<?php echo base_url(); ?>home/loginSubmit" method="POST" enctype="multipart/form-data">
                    <div class="signup__field">
                        <i class="signup__icon fas fa-user"></i>
                        <input type="text" name="username" class="signup__input" placeholder="Username" required>
                    </div>
                    <div class="signup__field">
                        <i class="signup__icon fas fa-lock"></i>
                        <input type="password" name="password" class="signup__input" placeholder="Password" required>
                    </div>
                    <input type="hidden" name="mode" value="S" />
                    <button type="submit" id="btn" class="button signup__submit">
                        <span class="button__text">Sign Up</span>
                        <i class="button__icon fas fa-chevron-right"></i>
                    </button>
                    <a href="<?php echo base_url(); ?>home/login" class="button signup__submit">
                        <span class="button__text">Go To Login</span>
                    </a>
                </form>
                
            </div>
            <div class="screen__background">
                <span class="screen__background__shape screen__background__shape4"></span>
                <span class="screen__background__shape screen__background__shape3"></span>
                <span class="screen__background__shape screen__background__shape2"></span>
                <span class="screen__background__shape screen__background__shape1"></span>
            </div>
        </div>
    </div>
</body>

<script>
    $(document).ready(function(){
        var frm = $("#signup_frm");
        var btn = $("#btn");

        btn.click(function(){
            frm.ajaxForm({
                beforeSend:function(){
                    btn.prop('disabled',true);
                },
                success:function(data){
                    btn.prop('disabled',false);
                    var resp = data.split('::');

                    if(resp[0]==200){
                        Swal.fire({
                            title: "Good job!",
                            text: resp[1],
                            icon: "success"
                        }).then(()=>{
                            window.location = 'dashboard';
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
                error:function(err){
                    btn.prop('disabled',false);
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Something went wrong!",
                    });
                }
            })
        })
    });
</script>

</html>