<div class="col-sm-8 blog-main">
    <?php foreach ($posts as $post) { ?>

        <div class="blog-post">
            <h2 class="blog-post-title"><a href="/posts/<?php echo $post->id ?>"> <?php echo $post->title ?></a></h2>

            <p class="blog-post-meta"><?php echo date('F j, Y', strtotime($post->date)) ?> by <a
                    href="/profile"><?php echo 'JuraZubach' ?></a>
            </p>

            <?php echo htmlspecialchars_decode($post->content) ?>
        </div>

    <?php } ?>

</div>

