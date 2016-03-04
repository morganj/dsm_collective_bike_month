<!DOCTYPE html>
<?php get_header(); ?>

<body>
<main>
    <?php while(have_posts()): the_post();?>
        <?php the_content(); ?>
    <?php endwhile; ?>

</main>

<?php get_footer(); ?>
</body>
</html>
