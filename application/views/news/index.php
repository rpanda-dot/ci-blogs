<h2>
    <?php echo $title; ?>
</h2>
<?php
foreach ($news as $news_item) {
?>
    <h3>
        <?php echo $news_item['title']; ?>
        <div class="main">
            <?php echo $news_item['text']; ?>
        </div>
        <p><a href="<?php echo site_url('news/' . $news_item['slug']); ?>">View Article</a></p>
        <?php
        //  echo $this->benchmark->elapsed_time();

        // echo $this->benchmark->memory_usage();
        ?>
    </h3>
<?php
}
