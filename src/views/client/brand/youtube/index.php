<?php declare(strict_types=1);
$this->start('head'); ?>
<!-------Costum-------->
<link href="<?= $this->asset('css/brand/clothes/pages/home', 'css') ?? ''?>" rel="stylesheet" type="text/css">
<?php $this->end(); ?>
<?php $this->start('body'); ?>
<main id="main-site">
    <!-- Content -->
    <!-- Navbar -->
    <nav class="k-navbar-secondary">
        <div class="k-container">
            <h1>K'nGELL Framework</h1>
            <ul class="k-d-f">
                <li class="k-ml-1 k-text-hover-secondary"><a href="#work" class="">Our Work</a></li>
                <li class="k-ml-1 k-text-hover-secondary"><a href="#about" class="">About Us</a></li>
            </ul>
        </div>
    </nav>
    <!-- Intro -->
    <div class="k-container k-mt-5">
        <div class="k-row k-justify-center">
            <div class="k-col-xs-12 k-col-md-5">
                <h2>
                    <div class="k-font-xxl">Black Belt</div>
                    <div class="k-font-xxl k-text-secondary">your Website</div>
                </h2>
                <p class="k-text-gray k-mt-2 k-mb-3">Lorem ipsum dolor, sit amet consectetur adipisicing elit.</p>
                <a href="#work" class="k-btn-outlined-secondary k-text-secondary k-text-hover-white">View your Work</a>
            </div>
            <div class="k-col-xs-12 k-col-md-5"><img src="../../../../../assets/img/accessories-collection.png" alt="">
            </div>
        </div>
    </div>
    <!-- About sSection -->
    <section id="about" class="k-bg-secondary-light-9 k-mt-5 k-pb-4">
        <div class="container">
            <h2 class="mb-2">About K'nGELL Framework</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Cupiditate inventore deserunt dolorum officia
                voluptatem quisquam cum rerum quidem! Incidunt id illum veniam esse, doloremque dolor dicta accusamus
                hic dolorum nobis est at, neque modi aliquam debitis vel voluptatum deleniti odit!</p>
            <p class="mt-1">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Possimus accusamus doloribus
                dolores quaerat tenetur error architecto accusantium atque at? Deserunt hic fugit, voluptate corrupti
                eos rem. Consectetur, impedit, vero ratione voluptate perferendis porro blanditiis soluta optio harum
                magni qui doloremque!</p>
        </div>
    </section>
    <!-- Work Section -->
    <section id="work" class="mt-5">
        <div class="k-container">
            <h2 class="k-mb-2">Some of our work</h2>
            <div class="k-row k-gap-2">
                <div class="k-col-xs-12 k-col-md-6 k-col-lg-3">
                    <div class="k-card k-p-0">
                        <h3 class="k-card-title k-m-1">
                            Mario Club <span class="k-badge-orange k-text-white k-ml-1">New</span>
                        </h3>
                        <img src="../../../../../assets/img/dark-logo.png" alt="">
                        <p class="k-mt-1">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    </div>
                </div>
                <div class="k-col-xs-12 k-col-md-6 k-col-lg-3">
                    <div class="k-card k-p-0">
                        <h3 class="k-card-title k-m-1">
                            Paris Club
                        </h3>
                        <img src="../../../../../assets/img/header.png" alt="">
                        <p class="k-mt-1">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    </div>
                </div>
                <div class="k-col-xs-12 k-col-md-6 k-col-lg-3">
                    <div class="k-card k-p-0">
                        <h3 class="k-card-title k-m-1">
                            Taounde Club
                        </h3>
                        <img src="../../../../../assets/img/header.png" alt="">
                        <p class="k-mt-1">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    </div>
                </div>
                <div class="k-col-xs-12 k-col-md-6 k-col-lg-3">
                    <div class="k-card k-p-0">
                        <h3 class="k-card-title k-m-1">
                            Pitchichi Club
                        </h3>
                        <img src="../../../../../assets/img/header.png" alt="">
                        <p class="k-mt-1">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    </div>
                </div>
            </div>
            <div class="k-row kjustify-center k-mt-2">
                <button class="k-btn-secondary k-text-white k-font-md">Show All</button>
            </div>
        </div>
    </section>
    <!-- Fin Content -->
    <footer class="k-bg-gray-light-7 k-pt-3 k-pb-3 k-mt-3">
        <div class="k-container">CopyRight 2021 K'nGELL design</div>
    </footer>
    <input type="hidden" id="ip_address" style="display:none" value="<?=H_visitors::getIP()?>">
</main>
<?php $this->end(); ?>
<?php $this->start('footer') ?>
<!----------custom--------->
<script type="text/javascript" src="<?= $this->asset('pathjs', 'js') ?? ''?>">
</script>
<?php $this->end();
