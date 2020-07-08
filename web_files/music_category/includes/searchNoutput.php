<?php $db = open_sqlite_db("secure/data.sqlite");
$imageinfo = array(
  array('Colourful Head', 'http://www.flat-e.com/work/jamie-lidell-album-art/', 'colorfulhead.jpg'),
  array('Palm Tree', 'https://www.flickr.com/photos/mboprtr/16588372183', 'palmtree.jpg'),
  array('Boy with Eyes Slashed out', 'https://cdn8.openculture.com/2018/02/26214611/Arlo-safe-e1519715317729.jpg', 'darkboy.jpg'),
  array('EverGlow Circles', 'http://thesampler.net/coldplay-previews-everyglow-from-upcoming-album/', 'everglow.jpg'));
// Palm Image Source https://www.flickr.com/photos/mboprtr/16588372183 -->
// EverGlow Circles Souce http://thesampler.net/coldplay-previews-everyglow-from-upcoming-album/ -->
// Boys with Eyes Slashed out Source  https://cdn8.openculture.com/2018/02/26214611/Arlo-safe-e1519715317729.jpg-->
// ColourFul Head Source http://www.flat-e.com/work/jamie-lidell-album-art/ -->

function fetch_values($sql, $db, $params){
  $output= exec_sql_query($db, $sql, $params);
  $records =$output->fetchAll();
  return $records;
}

if (!(isset($_GET['search']))){
  $sql="SELECT * FROM songs;";
  $params = array();
  $records = fetch_values($sql, $db, $params);

} else {
  $searchvalue= filter_input(INPUT_GET, "searchvalue", FILTER_SANITIZE_STRING);
  $params = array(
    ':searchvalue' => $searchvalue,
  );
  $sql="SELECT * FROM songs
  WHERE artist LIKE '%' || :searchvalue || '%'
  UNION
  SELECT * FROM songs
  WHERE song_title LIKE '%' || :searchvalue || '%'
  UNION
  SELECT * FROM songs
  WHERE genre LIKE '%' || :searchvalue || '%'
  UNION
  SELECT * FROM songs
  WHERE year_released LIKE '%' || :searchvalue || '%'";
  $records = fetch_values($sql, $db, $params);

}

function song_details($record){
    //random picture selected as image of song, assosciated information also outputted, code below
    global $imageinfo;
    $image_number= rand(0,3);
    ?>

    <section class="musicrecord">
        <?php echo "<!-- Source:".$imageinfo[$image_number][1]."-->"?>
        <img src="images/<?php echo $imageinfo[$image_number][2];?>" class="musicImage" alt="<?php echo $imageinfo[$image_number][0];?>">
        <div class="MusicDets">
        <h1 class="SongTtl"><?php echo htmlspecialchars($record["song_title"]); ?></h1>
        <p>Artist: <?php echo htmlspecialchars($record["artist"]); ?></p>
        <p>Released:<?php echo htmlspecialchars($record["year_released"]); ?></p>
        <p> Genre: <?php echo htmlspecialchars($record["genre"]); ?></p>
        <cite><a href="<?php echo $imageinfo[$image_number][1];?>">Image Source: <?php  echo $imageinfo[$image_number][1];?>  </a></cite>
        </div>
    </section>

    <?php
}


if (isset($_POST['submit'])){

  $artist = filter_input(INPUT_POST, "artist", FILTER_SANITIZE_STRING);
  $relyear = filter_input(INPUT_POST, "relyear", FILTER_SANITIZE_NUMBER_INT);
  $genre = filter_input(INPUT_POST, "genre", FILTER_SANITIZE_STRING);
  $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_STRING);

  if ($relyear<0 ||  $relyear> 2019){
    $relyear= Null;
  }

  if ($title==""){
    $title="Not Available";
  }

  if (is_null($title)){
    $title="Not Available";
  }


  $sql = "INSERT INTO songs(artist, song_title, genre, year_released)
  VALUES (:artist, :title, :genre, :relyear)";
  $params = array(
    ':artist' => $artist,
    ':relyear' => $relyear,
    ':genre' => $genre,
    ':title' => $title
  );

  $result = exec_sql_query($db, $sql, $params);

}
?>
