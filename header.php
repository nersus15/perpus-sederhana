<?php  
  $user = $_SESSION["datauser"];
  $queryuser = mysqli_query($conn, "SELECT * FROM tbluser WHERE username = '$user'");
  $datauser = mysqli_fetch_array($queryuser);
?>


<header class="header">
  <nav class="navbar">
    <div class="container-fluid">
      <div class="navbar-holder d-flex align-items-center justify-content-between">
        <div class="navbar-header"><a id="toggle-btn" href="#" class="menu-btn"><i class="icon-bars"> </i></a><a href="index.html" class="navbar-brand">
		<img src="sma.png" width="50" height="50" style="border-radius:50%;">
            <div class="brand-text d-none d-md-inline-block"><strong class="text-primary">PERPUSTAKAAN SMAN 1 SAKRA</strong></div></a></div>
        <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
          <!-- Log out-->
          <li class="nav-item">
            <a href="logout.php" class="nav-link logout"> 
              <span class="d-none d-sm-inline-block">Keluar</span><i class="fa fa-sign-out"></i></a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</header>