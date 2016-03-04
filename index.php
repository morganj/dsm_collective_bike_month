<!DOCTYPE html>
<?php get_header(); ?>

<body>
<main>
    <?php echo 'hello world!' ?>
    <button id="click-button">Click Me</button>
    
    <?php while(have_posts()): the_post();?>
        <?php the_content(); ?>
    <?php endwhile; ?>

</main>

<?php get_footer(); ?>
</body>
</html>