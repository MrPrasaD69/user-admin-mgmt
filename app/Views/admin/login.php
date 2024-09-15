<!DOCTYPE html>
<html>

<head>
    <title>Admin Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://malsup.github.io/jquery.form.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<style>
    body {
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        font-family: 'Jost', sans-serif;
        background: linear-gradient(to bottom, #0f0c29, #19191c, #24243e);
    }

    .main {
        width: 350px;
        height: 500px;
        background: red;
        overflow: hidden;
        background: url("https://doc-08-2c-docs.googleusercontent.com/docs/securesc/68c90smiglihng9534mvqmq1946dmis5/fo0picsp1nhiucmc0l25s29respgpr4j/1631524275000/03522360960922298374/03522360960922298374/1Sx0jhdpEpnNIydS4rnN4kHSJtU1EyWka?e=view&authuser=0&nonce=gcrocepgbb17m&user=03522360960922298374&hash=tfhgbs86ka6divo3llbvp93mg4csvb38") no-repeat center/ cover;
        border-radius: 10px;
        box-shadow: 5px 20px 50px #000;
    }

    #chk {
        display: none;
    }

    .signup {
        position: relative;
        width: 100%;
        height: 100%;
    }

    label {
        color: #fff;
        font-size: 2.3em;
        justify-content: center;
        display: flex;
        margin: 50px;
        font-weight: bold;
        cursor: pointer;
        transition: .5s ease-in-out;
    }

    input {
        width: 60%;
        height: 10px;
        background: #e0dede;
        justify-content: center;
        display: flex;
        margin: 20px auto;
        padding: 12px;
        border: none;
        outline: none;
        border-radius: 5px;
    }

    button {
        width: 80%;
        height: 40px;
        margin: 10px auto;
        justify-content: center;
        display: block;
        color: #fff;
        background: #573b8a;
        font-size: 1em;
        font-weight: bold;
        margin-top: 30px;
        outline: none;
        border: none;
        border-radius: 5px;
        transition: .2s ease-in;
        cursor: pointer;
    }

    button:hover {
        background: #6d44b8;
    }

    .login {
        height: 460px;
        background: #eee;
        border-radius: 60% / 10%;
        transform: translateY(-180px);
        transition: .8s ease-in-out;
    }

    .login label {
        color: #573b8a;
        transform: scale(.6);
    }

    #chk:checked~.login {
        transform: translateY(-500px);
    }

    #chk:checked~.login label {
        transform: scale(1);
    }

    #chk:checked~.signup label {
        transform: scale(.6);
    }   
</style>

<body>
    <div class="main">
        <input type="checkbox" id="chk" aria-hidden="true">

        <div class="signup">
            <form id="signup_frm" action="<?php echo base_url(); ?>admin/loginSubmit" method="POST">
                <label for="chk" aria-hidden="true">Sign up</label>
                <input type="hidden" name="mode" value="S" />
                <input type="text" name="signup_username" placeholder="Username" required="">
                <input type="password" name="signup_password" placeholder="Password" required="">
                <button type="submit" id="signup_btn">Sign up</button>
            </form>
        </div>

        <div class="login">
            <form id="login_frm" action="<?php echo base_url(); ?>admin/loginSubmit" method="POST">
                <label for="chk" aria-hidden="true">Login</label>
                <input type="hidden" name="mode" value="L" />
                <input type="text" name="login_username" placeholder="Username" required="">
                <input type="password" name="login_password" placeholder="Password" required="">
                <button type="submit" id="login_btn">Login</button>
            </form>
        </div>
    </div>
</body>
<script>
    $(document).ready(function(){
        var login_frm = $("#login_frm");
        var login_btn = $("#login_btn");

        login_btn.click(function(){
            login_frm.ajaxForm({
                beforeSend:function(){
                    login_btn.prop('disabled',true);
                },
                success:function(data){
                    login_btn.prop('disabled',false);
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
                    login_btn.prop('disabled',false);
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Something went wrong!",
                    });
                }
            })
        });

        var signup_frm = $("#signup_frm");
        var signup_btn = $("#signup_btn");

        signup_btn.click(function(){
            signup_frm.ajaxForm({
                beforeSend:function(){
                    signup_btn.prop('disabled',true);
                },
                success:function(data){
                    signup_btn.prop('disabled',false);
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
                error:function(err){
                    signup_btn.prop('disabled',false);
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Something went wrong!",
                    });
                }
            })
        });
    });
</script>

</html>