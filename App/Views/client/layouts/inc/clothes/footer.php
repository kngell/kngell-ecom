  <!-- Start footer -->
  <!-- Comments -->

  <!-- End Comments -->
  <footer id="footer" class="mt-5 pt-5 pb-3">

  </footer>
  <!-- End footer -->
  <!-- Librairies -->
  <script type="text/javascript" src="<?= $this->asset('js/librairies/frontlib', 'js') ?? '' ?>">
  </script>
  <!-- Common vendor -->
  <script type="text/javascript" src="<?= $this->asset('commons/frontend/commonVendor', 'js') ?? '' ?>">
  </script>
  <!-- Custom Common Modules  -->
  <script type="text/javascript" src="<?= $this->asset('commons/frontend/commonCustomModules', 'js') ?? '' ?>">
  </script>
  <!-- Plugins -->
  <script type="text/javascript" src="<?= $this->asset('js/plugins/homeplugins', 'js') ?? '' ?>">
  </script>
  <!-- Mainjs -->
  <script type="text/javascript" src="<?= $this->asset('js/main/frontend/main', 'js') ?? '' ?>">
  </script>
  <?= $this->content('footer'); ?>
  </body>

  </html>