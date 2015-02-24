<?php
require_once 'core/init.php';

$user = new User();

if(!$user->isLoggedIn()){
    Redirect::to('index.php');
}

if(Input::exists()){
    if(Token::check(Input::get('token'))){
        $validation = new Validation();

        $validation = $validation->check($_POST, array(
            'name'  => array(
                'required' => true,
                'min'      => 2,
                'max'      => 50
            )
        ));

        if($validation->passed()){
            try{
                $user->update(array(
                    'name'  => Input::get('name')
                ));

                Session::flash('success', 'Information Updated Successfully');
                Redirect::to('index.php');

            }catch (Exception $e){
                die($e->getMessage());
            }
        }else{
            pre($validation->errors());
        }
    }
}

?>

<form action="" method="post">
    <div class="field">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="<?php echo $user->data()->name;?>"/>

        <input type="submit" value="Update"/>
        <input type="hidden" name="token" value="<?php echo Token::generate();?>"/>
    </div>
</form>