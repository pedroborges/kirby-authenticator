<div class="modal-content">
    <?= $form ?>
</div>

<script>

(function() {

  $('head').append('<link rel="stylesheet" href="<?= purl('login.css') ?>">');

  $('.message').message();

  $('.form').on('submit', function() {
    $(this).addClass('loading');
  });

  $('.modal-content').center(48);

})();

</script>
