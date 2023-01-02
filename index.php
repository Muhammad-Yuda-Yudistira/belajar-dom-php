<?php 

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Asia Drama</title>
        </head>
        <body>
        <form action="" method="post">
            <label for="page">URL: </label>
            <input type="text" id="page" name="page">
            <input type="submit" id="button">
        </form>
            <?php 
            if(isset($_POST["page"]))
            {
                $url = $_POST["page"];
                // Inisialisasi library SimpleHTMLDOM
                include('vendor/simple_html_dom/simple_html_dom.php');
    
                // Ambil detail url
                $html = file_get_html($url);
    
                // ambil semua film
                foreach($html->find('h6.title') as $title)
                {
                    $link = $title->find('a', 0)->href;
                    $subhtml = "https://mydramalist.com" . $link;
                    $detail = file_get_html($subhtml);
                    // Ambil data spesifik
                    $title = $detail->find('.film-title', 0)->find('a', 0)->plaintext;
                    $genre = $detail->find('.show-genres', 0)->plaintext;
                    $country = $detail->find('li.list-item', 1)->plaintext;
                    $episode = $detail->find('li.list-item', 2)->plaintext;
                    $aired = $detail->find('li.list-item', 3)->plaintext;
                    $urlImg = $detail->find('a.block', 0)->href;
                    $htmlPhoto = file_get_html('https://mydramalist.com' . $urlImg);
                    $img = $htmlPhoto->find('.photo', 0)->find('.img-responsive', 0)->src;
                    $synopsis = $detail->find('.show-synopsis p span', 0)->plaintext;
                    
                    echo '<div width="500px">
                            <h2>' . $title . '</h2>
                            <img src="https://mydramalist.com' . $img . '" width="200px" >
                            <h4>' . $genre . '</h4>
                            <h4>' . $country . '</h4>
                            <h4>' . $episode . '</h4>
                            <h4>' . $aired . '</h4>
                            <p>' . $synopsis . '</p>
                        </div>';
                }  
            } else {
                echo "<h2>Maukan url mydramalist newest disini</h2><br>
                <P>contoh: https://mydramalist.com/search?adv=titles&ty=68,77&co=3,2&so=newest&or=desc</p>";
            }
            ?>
        </body>
</html>