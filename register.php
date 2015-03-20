<?php
require_once 'core/init.php';

if(Input::exists()){
    //if(Token::check(Input::get('token'))) {
    if(true){
        $validate = new Validation();
        $validation = $validate->check($_POST, array(
            'username' => array(
                'required' => true,
                'min' => 2,
                'max' => 20,
                'unique' => 'users'
            ),
            'password' => array(
                'required' => true,
                'min' => 6
            ),
            'password_again' => array(
                'required' => true,
                'matches' => 'password'
            ),
            'name' => array(
                'required' => true,
                'min' => 3,
                'max' => 50
            )
        ));

        if ($validation->passed()) {

            $user = new User();
            $salt = Hash::salt(32);

            try{
                $user->create(array(
                    'username'  => Input::get('username'),
                    'password'  => Hash::make(Input::get('password'), $salt),
                    'salt'      => $salt,
                    'name'      => Input::get('name'),
                    'groups'    => 1
                ));
            }catch (Exception $e){
                die($e->getMessage());
            }

            Session::flash('success', 'You have successfully registered.');
            Redirect::to('index.php');
        } else {
            pre($validation->errors());
        }
    }
}

?>
<form action="" method="post">
    <div class="field">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" value="<?php echo escape(Input::get('username')); ?>" autocomplete="off"/>
    </div>

    <div class="field">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" value="" autocomplete="off"/>
    </div>

    <div class="field">
        <label for="password_again">Retype Password</label>
        <input type="password" name="password_again" id="password_again" value="" autocomplete="off"/>
    </div>

    <div class="field">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="<?php echo escape(Input::get('name')); ?>" autocomplete="off"/>
    </div>

    <input type="text" name="token" value="<?php echo Token::generate(); ?>"/>

    <input type="submit" value="Register"/>
</form>