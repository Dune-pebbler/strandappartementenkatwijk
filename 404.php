<?php get_header(); ?>
<main>
    <section class="page-content">
        <div class="container">
            <h1 style="margin: 0; padding: 15px 0;"><?= __('Pagina niet gevonden', 'strandappartement'); ?></h1>

            <p><?= __('We hebben de pagina die u zocht niet kunnen vinden.', 'strandappartement'); ?></p>

            <div class="buttons">
                <a href="<?= site_url(); ?>" class="btn"><?= __('Terug naar homepagina', 'strandappartement'); ?></a>
            </div>
        </div>
    </section>
</main>
<?php get_footer(); ?>