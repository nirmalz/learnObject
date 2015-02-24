<?php

require_once 'core/init.php';

if(Session::exists('success')){
    echo Session::flash('success');
}

$user = new User();

if($user->isLoggedIn()){
    ?>

    <p>Hello, <a href="profile.php?user=<?php echo escape($user->data()->username);?>"><?php echo escape($user->data()->username);?></a></p>

    <ul>
        <li><a href="logout.php">Log Out</a></li>
        <li><a href="update.php">Update Detail</a></li>
        <li><a href="changePassword.php">Change Password</a></li>
    </ul>

    <?php

    if($user->hasPermission('admin')){
        echo '<p>You are an administratior.</p>';
    }

}else{
    ?>
    <p>You need to log in.</p>
    <p><a href="register.php">Register</a></p>
    <p><a href="login.php">Login</a></p>
    <?php
}

?>
