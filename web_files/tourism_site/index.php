<?php
// DO NOT REMOVE!
include("includes/init.php");
// DO NOT REMOVE!
$landingimagesrc = "images/volta.jpg";
$imagedescrip ="Seaside Huts";
$home= "activepage";
?>


<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Home</title>

    <link rel="stylesheet" type="text/css" href="styles/stylesheet.css" media="all" />
  </head>


  <body>
    <?php include("includes/header.php"); ?>

    <div class="content-wrap">
      <article class="content">
        <section class="welcomesect">
          <h1> Visit Ghana </h1>

          <figure>
            <!-- Source: https://www.director.co.uk/doing-business-in-ghana-21468-2/-->
            <img src="images/GHinfrastructure.jpg" id="topimage" alt="Ghana Infrastructure">
            <figcaption>
                  Source: <cite><a href="https://www.director.co.uk/doing-business-in-ghana-21468-2/">https://www.director.co.uk/doing-business-in-ghana-21468-2/</a></cite>
            </figcaption>
          </figure>

          <p> Visit Ghana aims at promoting tourism in the West African nation, Ghana. Ghana is known for its bustling nightlife, serene resorts and diverse wildlife. Visit Ghana showcases a bevy of different experiences and adventures, one can be a part of. Ghana has something for everyone and the visit ghana team honestly believes that if you give Ghana a chance you'll find another place you can really call home, seeing that Ghanaians are known for their hospitality. So, welcome to our site and get ready to VISIT GHANA! </p>
        </section>

        <section class="imageNtext">
          <figure>

            <!-- Source: https://thewrap.life/pages/ghana-ghana -->
            <img src="images/Ghanawomen.jpg" class="showcaseimageright" alt="Ghanaian Women">

          </figure>

          <article class="imageDescrip">
            <h3> What is Ghana? </h3>

            <!-- Text Source: https://en.wikipedia.org/wiki/Ghana-->
            <p > Ghana (/ˈɡɑːnə/), officially the Republic of Ghana, is a country located along the Gulf of Guinea and Atlantic Ocean, in the subregion of West Africa. Spanning a land mass of 238,535 km2 (92,099 sq mi), Ghana is bordered by the Ivory Coast in the west, Burkina Faso in the north, Togo in the east and the Gulf of Guinea and Atlantic Ocean in the south. Ghana means "Warrior King" in the Soninke language.[Ghana's growing economic prosperity and democratic political system have made it a regional power in West Africa. </p>


            <p class="refer">
              Image Source: <cite><a href="https://thewrap.life/pages/ghana-ghana ">https://thewrap.life/pages/ghana-ghana </a></cite>
            </p>

            <p class="refer">
              Text Source: <cite><a href="https://en.wikipedia.org/wiki/Ghana">https://en.wikipedia.org/wiki/Ghana</a></cite>
            </p>

          </article>
        </section>

        <section class="imageNtext">
          <figure>
            <!-- Source: https://adventure.com/ghana-cape-coast-west-africa/ -->
            <img src="images/sea_chairs.jpg" class="showcaseimageleft" alt="Sea and Chairs">
          </figure>

          <article class="imageDescrip">
            <h3> Why Visit Ghana? </h3>

            <p > Ghana is a country on the rise. Known as a shining star among West African countries, Ghana is going through a period of massive growth and development as well as unprecedented levels of peace for an African country. Apart from this, Ghana has the most diverse population of butterflies as well as a host of other attractions including Kakum National Park, Busua Beach Resort and Kwame Nkrumah National Mausoleum. There are a lot of things to do in Ghana as you shall soon see which will hppefully convince you to Visit Ghana. </p>

            <p class="refer">
              Image Source: <cite><a href="https://adventure.com/ghana-cape-coast-west-africa/">https://adventure.com/ghana-cape-coast-west-africa/</a></cite>
            </p>

          </article>
        </section>

      </article>
    </div>

    <?php include("includes/footer.php"); ?>
  </body>

</html>
