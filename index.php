<!DOCTYPE html>
<?php get_header(); ?>

<body>
<main>
    <?php echo 'hello world!' ?>
    <div id="event-redeemer">
        <input id="event-code" type="text">
        <button id="event-code-submit">Click Me!</button>
        <div class="event-code-error"></div>
    </div>

    <?php while(have_posts()): the_post();?>
        <?php the_content(); ?>
    <?php endwhile; ?>

</main>

<?php get_footer(); ?>
</body>
</html>