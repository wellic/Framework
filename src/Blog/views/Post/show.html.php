<?php
$date = new \DateTime();
$date->setTimestamp(strtotime($post->date));
?>

<div class="row">
    <h1><?php echo $post->title ?></h1>

    <p class="small"><?php echo $date->format('F j, Y H:i:s') ?></p>
    <?php echo htmlspecialchars_decode($post->content) ?>


</div>

<?php
if (!is_null($user))
    {
        if (is_object($user)) {
            $user_role = get_object_vars($user);
            if(!empty($user_role['role'] == 'ROLE_ADMIN'))
            { ?>
                <div class="btn-group pull-left media">
                    <?php echo '<a class="btn btn-primary btn-sm mr-5" type="button" href="'.$getRoute('edit_post',
                            array('id'=>$post->id)).'">Edit</a>' ?>
                    <?php echo '<a class="btn btn-danger btn-sm" type="button" href="'.$getRoute('delete_post',
                            array('id'=>$post->id)).'">Delete</a>' ?>
                </div>
            <?php } ?>
                <?php
            }
        } ?>