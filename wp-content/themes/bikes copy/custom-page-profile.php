<?php /* Template Name: Profile */ ?>

<!DOCTYPE html>
<head></head>
<body>

<main>
    <?php $user = get_user_meta(get_current_user_id()); ?>
    <?php print_r($user); ?>
    <h1><?php echo $user['first_name'][0]; ?>'s Events</h1>

    <select>
        <?php foreach($events as $year): ?>
            <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
        <?php endforeach; ?>
    </select>



    <?php $events = json_decode($user['events_redeemed'][0], true); ?>
    <?php print_r($events); ?>
    <?php foreach($events[2016] as $id): ?>
        <?php // Get badge ?>
        <?php echo get_the_title($id); ?>
    <?php endforeach; ?>











</main>

</body>
</html>