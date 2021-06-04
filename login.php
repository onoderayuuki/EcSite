<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
  <link rel="stylesheet" href="css/reset.css" />
  <link rel="stylesheet" href="css/style.css" />
<style>
div{ 
    padding: 10px;
    font-size:16px;
    display:flex;
    justify-content:center;
    }
    input{
      margin-top:15px;
      border : none;
      border-bottom :solid 1px #0b2d5d;

    }
</style>
<title>Login</title>
</head>
<body>

<!-- Head[Start] -->
<header class="header">
      <h1 class="site-title"><a href="#">Moonlight 🌒</a></h1>      
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div>
<form method="post" action="login_act.php">
   <fieldset>
     <label>ID  ：<input type="text" name="lid"></label><br>
     <label>PW：<input type="password" name="lpw"></label><br>
     <input type="submit" value="ログイン">
    </fieldset>
</form>
</div>
<!-- Main[End] -->

</body>
</html>
