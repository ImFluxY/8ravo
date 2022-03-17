<?php
require_once('common.php');
require_once('./templates/begin.php');
?>
<title>Modules - 8ravo</title>
<link rel="stylesheet" href="./css/swiper-bundle.min.css">
<link rel="stylesheet" href="./css/select-module.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
</head>

<?php

$cnx = new Base(BASE, USERNAME, PASSWORD);

?>

<body>
    <?php require_once('./templates/menu.php'); ?>
    <main class="main modules">
        <div class="select-module-container">
            <div class="search-container">
                <div class="search-box">
                    <form id="form">
                        <input type="text" id="query" placeholder="Rechercher un module">
                        <button><svg viewBox="0 0 1024 1024">
                                <path class="path1" d="M848.471 928l-263.059-263.059c-48.941 36.706-110.118 55.059-177.412 55.059-171.294 0-312-140.706-312-312s140.706-312 312-312c171.294 0 312 140.706 312 312 0 67.294-24.471 128.471-55.059 177.412l263.059 263.059-79.529 79.529zM189.623 408.078c0 121.364 97.091 218.455 218.455 218.455s218.455-97.091 218.455-218.455c0-121.364-103.159-218.455-218.455-218.455-121.364 0-218.455 97.091-218.455 218.455z">
                                </path>
                            </svg></button>
                    </form>
                </div>
                <div class="filter-module">
                    <span class="filter-span active" data-category="all">Tout</span>
                    <?php

                    $categories = $cnx->query("SELECT * FROM moduleCategory");

                    foreach ($categories as $category) {
                    ?>
                        <span class="filter-span" data-category="<?php echo $category['idCategory']; ?>"><?php echo $category['categoryName']; ?></span>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="slider-container" id="main-slider">
                <div class="swiper mySwiper swiper-margin">
                    <div class="swiper-wrapper"></div>
                    <div class="slider-btns">
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="./js/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".mySwiper", {
            loopedSlides: 8,
            slidesPerView: "auto",
            freeMode: true,
            mousewheel: {
                releaseOnEdges: true,
            },
            slidesPerView: 1,
            spaceBetween: 10,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                640: {
                    slidesPerView: 1,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 40,
                },
                1088: {
                    slidesPerView: 3,
                    spaceBetween: 50,
                },
            },
        });
    </script>
    <script src="./js/search.js"></script>
    <?php
    require_once('./templates/end.php');
    ?>