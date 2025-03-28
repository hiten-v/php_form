<?php
    session_start();
    $loginEmailErr=$loginPassErr=$registerEmailErr=$registerPassErr=$registerNameErr="";
    $hasErr=false;
    $loginOutput=$registerOutput="";
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if (isset($_POST['login'])) 
        {
            $email=$_POST["email"];
            $pass=$_POST["pass"];
            if(empty($email))
            {
                $loginEmailErr="email cannot be empty";
                $hasErr=true;
            }
            else
            {
                $email=filter_input(INPUT_POST,"email",FILTER_VALIDATE_EMAIL);
                if(empty($email))
                {
                    $loginEmailErr="email format is wrong";
                    $hasErr=true;
                }
            }
            if(empty($pass))
            {
                $loginPassErr="password cannot be empty";
                $hasErr=true;
            }
            else
            {
                if(strlen($pass)<6)
                {
                    $loginPassErr="password length must be > 6";
                    $hasErr=true;
                }
            }
            if($hasErr==false)
            {
                $cookie_email=$email;
                $cookie_pass=$pass;
                setcookie("email",$cookie_email,time()+(86400*30),"/");
                setcookie("pass",$cookie_pass,time()+(86400*30),"/");
                $loginOutput="Logged in successfully";
            }
            
        }
        if (isset($_POST['register'])) 
        {
            $name=$_POST["name"];
            $email=$_POST["email"];
            $pass=$_POST["pass"];
            if(empty($name))
            {
                $registerNameErr="name cannot be empty";
                $hasErr=true;
            }
            if(empty($email))
            {
                $registerEmailErr="email cannot be empty";
                $hasErr=true;
            }
            else
            {
                $email=filter_input(INPUT_POST,"email",FILTER_VALIDATE_EMAIL);
                if(empty($email))
                {
                    $registerEmailErr="email cannot be like this";
                    $hasErr=true;
                }
            }
            if(empty($pass))
            {
                $registerPassErr="password cannot be empty";
                $hasErr=true;
            }
            else
            {
                if(strlen($pass)<6)
                {
                    $registerPassErr="password length must be > 6";
                    $hasErr=true;
                }
            }
            if($hasErr==false)
            {
                $registerOutput="Registered in successfully";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login_register</title>
    <link rel="stylesheet" href="../src/output.css?v=<?php echo time(); ?>">
    <style>
        .form_box
        {
            display: none;
        }
        .form_box.active
        {
            display: flex;
        }
    </style>
</head>
<body>
    <section class="bg-linear-to-r from-slate-400 to-slate-800 h-screen flex flex-col justify-center items-center">
        <div id="login" class="form_box active flex-col justify-center items-center gap-10 ring-3 ring-amber-300 p-10 rounded-xl m-5 w-3/8 shadow-2xl shadow-white">
            <h1 class="text-5xl font-bold text-amber-300">Login</h1>
            <form method="post" action="login_form_validations.php" class="flex flex-col justify-center items-center gap-5 text-white ">
                <input type="text" placeholder="Enter registered email id" name="email" class="rounded-xl p-2 ring-2 ring-amber-300 placeholder-white focus:outline-none focus:shadow-inner focus:shadow-white">
                <span class="inline-block mx-5 text-red-400">
                    <?= $loginEmailErr ?>
                </span>
                <input type="password" placeholder="Enter registered password" name="pass" class="rounded-xl p-2 ring-2 ring-amber-300 placeholder-white focus:outline-none focus:shadow-inner focus:shadow-white">
                <span class="inline-block mx-5 text-red-400">
                    <?= $loginPassErr ?>
                </span>
                <div class="flex gap-2">
                    <input type="checkbox" name="remember">
                    <span class="text-amber-300">Remember Me</span>
                </div>
                <button type="submit" name="login" class="p-3 text-[#DCD7C9] rounded-xl bg-[#3F4F44] hover:bg-[#505c54] focus:ring-2 focus:ring-[#3F4F44] focus:ring-offset-2 focus:ring-offset-[#DCD7C9]">Login</button>
            </form>
            <span class="text-amber-300">
                New User?
                <a href="#" onclick="display('register','login');" class="text-white">Register</a>
            </span>
            <div class="text-green-300 text-xl font-bold"><?= $loginOutput ?></div>
        </div>
        <div id="register" class="form_box flex-col justify-center items-center gap-10 ring-3 ring-amber-300 p-10 rounded-xl m-5 w-3/8 shadow-2xl shadow-white">
            <h1 class="text-5xl font-bold text-amber-300">Register</h1>
            <form method="post" action="login_form_validations.php" class="flex flex-col justify-center items-center gap-5">
                <input type="text" placeholder="Enter name" name="name" class="rounded-xl p-2 ring-2 ring-amber-300 placeholder-white focus:outline-none focus:shadow-inner focus:shadow-white">
                <span class="inline-block mx-5 text-red-400">
                    <?= $registerNameErr ?>
                </span>
                <input type="text" placeholder="Enter email id" name="email" class="rounded-xl p-2 ring-2 ring-amber-300 placeholder-white focus:outline-none focus:shadow-inner focus:shadow-white">
                <span class="inline-block mx-5 text-red-400">
                    <?= $registerEmailErr ?>
                </span>
                <input type="password" placeholder="create password" name="pass" class="rounded-xl p-2 ring-2 ring-amber-300 placeholder-white focus:outline-none focus:shadow-inner focus:shadow-white">
                <span class="inline-block mx-5 text-red-400">
                    <?= $registerPassErr ?>
                </span>
                <button type="submit" name="register" class="p-3 text-[#DCD7C9] rounded-xl bg-[#3F4F44] hover:bg-[#505c54] focus:ring-2 focus:ring-[#3F4F44] focus:ring-offset-2 focus:ring-offset-[#DCD7C9]">Register</button>
            </form>
            <span class="text-amber-300">
                Existing User?
                <a href="#" onclick="display('login','register');" class="text-white">Login</a>
            </span>
            <div class="text-green-300 text-xl font-bold"><?= $registerOutput ?></div>
        </div>
    </section>
    <script>
        function display(form1,form2)
        {
            let f1=document.getElementById(form1);
            let f2=document.getElementById(form2);
            f1.classList.add('active');
            f2.classList.remove('active');
        }
    </script>
</body>
</html>