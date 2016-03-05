<?php

get_header();
get_template_part('inc/wrapper','start');
get_template_part('loop/loop', get_option('blog_layout','blog') );
get_template_part('inc/wrapper','end');
get_footer();