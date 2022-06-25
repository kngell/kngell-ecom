<?php declare(strict_types=1);
$this->start('head'); ?>
<!-------Costum-------->
<link href="<?= $this->asset('css/brand/clothes/pages/home', 'css') ?? ''?>" rel="stylesheet" type="text/css">
<?php $this->end(); ?>
<?php $this->start('body'); ?>
<main id="main-site">
    <!-- Content -->
    <nav class="navbar-primary text-white mb-4">
        <div class="container">
            <div class="site-title">K'nGELL Framework</div>
            <p>Lightweight librairy for dev ninjas</p>
        </div>
    </nav>
    <div class="container">
        <!-- Colors -->
        <h2>Colors</h2>
        <span class="text-primary">Primary Text</span>&nbsp;&verbar;
        <span class="text-secondary">Secondary Text</span>&nbsp;&verbar;
        <span class="text-error">Error Text</span>&nbsp;&verbar;
        <span class="text-info">Info Text</span>&nbsp;&verbar;
        <span class="text-red">red Text</span>&nbsp;&verbar;
        <span class="text-blue">blue Text</span>&nbsp;&verbar;
        <span class="text-orange">orange Text</span>&nbsp;&verbar;
        <span class="text-purple">purple Text</span>&nbsp;&verbar;
        <span class="text-gray">gray Text</span>&nbsp;&verbar;
        <span class="text-black">black Text</span>&nbsp;&verbar;
        <br><br>
        <span class="bg-primary">Primary bg</span>&nbsp;&verbar;
        <span class="bg-secondary">Secondarybg</span>&nbsp;&verbar;
        <span class="bg-error">Error bg</span>&nbsp;&verbar;
        <span class="bg-info">Info bg</span>&nbsp;&verbar;
        <span class="bg-red">red bg</span>&nbsp;&verbar;
        <span class="bg-blue">blue bg</span>&nbsp;&verbar;
        <span class="bg-orange">orange bg</span>&nbsp;&verbar;
        <span class="bg-purple">purple bg</span>&nbsp;&verbar;
        <span class="bg-gray">gray bg</span>&nbsp;&verbar;
        <span class="bg-black">black bg</span>&nbsp;&verbar;
        <br><br>
        <span class="bg-primary-dark-8 text-white">Primary dark 8</span>&nbsp;&verbar;
        <span class="bg-primary-dark-6 text-white">Primary dark 6</span>&nbsp;&verbar;
        <span class="bg-primary-dark-4 text-white">Primary dark 4</span>&nbsp;&verbar;
        <span class="bg-primary-dark-2 text-white">Primary dark 2</span>&nbsp;&verbar;
        <span class="bg-primary text-white">Primary</span>&nbsp;&verbar;
        <span class="bg-primary-light-2 text-white">Primary light 2</span>&nbsp;&verbar;
        <span class="bg-primary-light-4 text-white">Primary light 4</span>&nbsp;&verbar;
        <span class="bg-primary-light-6 text-white">Primary light 6</span>&nbsp;&verbar;
        <span class="bg-primary-light-8 text-white">Primary light 8</span>&nbsp;&verbar;
        <br><br>
        <a href="#" class="text-primary text-hover-orange-light-1">hover Me</a>
        <hr class="mt-4 mb-4">
        <!-- font-size -->
        <h2 class="mb-2">Font Size</h2>
        <div class="font-sm">this is small font</div>
        <div class="font-md">this is medium font</div>
        <div class="font-lg">this is large font</div>
        <div class="font-xl">this is xtra large font</div>
        <div class="font-xxl">this is extra, extra large font</div>
        <hr class="mt-4 mb-4">
        <!-- buttons -->
        <h2>Button</h2>
        <a href="#" class="btn">Default Btn</a>
        <a href="#" class="btn-primary text-white">Click Me!</a>
        <a href="#" class="btn-secondary text-white">Click Me!</a>
        <a href="#" class="btn-error text-white">Click Me!</a>
        <a href="#" class="btn-info">Click Me!</a>
        <a href="#" class="btn-outlined-purple text-purple text-hover-white">Click Me!</a>
        <a href="#" class="btn-outlined-orange text-orange text-hover-white">Click Me!</a>
        <a href="#" class="btn-complement-purple">Click Me!</a>
        <a href="#" class="btn-complement-primary">Click Me!</a>
        <hr class="mt-4 mb-4">
        <!-- cards -->
        <h2>Card</h2>
        <div class="card">
            <h1 class="card-title">
                This is a card title
            </h1>
            <div class="card-body">
                Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quisquam illum distinctio possimus sapiente
                placeat <a href="#">incidunt animi </a> deserunt eius eos. Possimus.
            </div>
        </div>
        <hr class="mt-4 mb-4">
        <!-- grid system -->
        <h2 class="mb-2">Grid System</h2>
        <div class="row gap-2 justify-center">
            <div class="col-xs-12 col-sm-5 col-xl-3">
                <div class="card">
                    <h3 class="card-title">Hello Ninja</h3>
                    <p class="card-body">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                </div>
            </div>
            <div class="col-xs-12 col-sm-5 col-xl-3">
                <div class="card">
                    <h3 class="card-title">Hello Ninja</h3>
                    <p class="card-body">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                </div>
            </div>
            <div class="col-xs-12 col-sm-5 col-xl-3">
                <div class="card">
                    <h3 class="card-title">Hello Ninja</h3>
                    <p class="card-body">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                </div>
            </div>
            <div class="col-xs-12 col-sm-5 col-xl-3">
                <div class="card">
                    <h3 class="card-title">Hello Ninja</h3>
                    <p class="card-body">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                </div>
            </div>
        </div>
        <hr class="mt-4 mb-4">
        <!-- utilities -->

        <hr class="mt-4 mb-4">
    </div>
    <!-- Fin Content -->

</main>
<?php $this->end(); ?>
<?php $this->start('footer') ?>
<!----------custom--------->
<script type="text/javascript" src="<?= $this->asset('pathjs', 'js') ?? ''?>">
</script>
<?php $this->end();