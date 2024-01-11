<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Tìm kiếm</title>
    <link rel="stylesheet" href="search.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body>
    <div class="container my-5">
        <form method="get" class="search d-flex" action="search.php">
            <input class="form-control" type="search" placeholder="Enter keyword..." name="query" id="searchInput" value="<?php echo $_GET['query'] ?>">
            <button class="btn btn-primary btn-search" name="btn">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </form>

    </div>
    <div class="search-result container">
        <?php

        $apiKey = 'AIzaSyB2fPyfhadl8SGXfaGHqmKcWul5uDkOpHY';
        $query = isset($_GET['query']) ? $_GET['query'] : '';

        $apiUrl = "https://www.googleapis.com/youtube/v3/search?part=snippet&q=" . urlencode($query) . "&type=video&key=$apiKey";
        $ch = curl_init($apiUrl);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        if ($response !== false) {
            $data = json_decode($response, true);
            // Xử lý dữ liệu
            foreach ($data['items'] as $item) {
                $videoId = $item['id']['videoId'];
                $videoTitle = $item['snippet']['title'];
                $authors = $item['snippet']['channelTitle'];
                $publishedAt = $item['snippet']['publishedAt'];

                //format time 
                $publishedDateTime = new DateTime($publishedAt);
                $formattedPublishedAt = $publishedDateTime->format('d.m.Y');
        ?>
                <div class="result d-flex  my-4">
                    <div class="left">
                        <?php echo "<iframe width='300' height='225' src='https://www.youtube.com/embed/$videoId' frameborder='0' allowfullscreen></iframe>"; ?>
                    </div>
                    <div class="right">
                        <p class="video_title"><?php echo $videoTitle ?></p>
                        <p class="video_date"><?php echo $formattedPublishedAt ?></p>
                        <p class="video_channel"><?php echo $authors ?></p>
                        <a class="btn btn-danger" href="download.php?videoId=<?php echo $videoId ?>" onclick="downloadVideo(this.href.split('?')[1])">Download Video</a>
                    </div>
                </div>
                <!-- echo "<h3>$videoTitle</h3>";
                    echo "<iframe width='560' height='315' src='https://www.youtube.com/embed/$videoId' frameborder='0' allowfullscreen></iframe>"; -->
        <?php
            }
        } else {
            echo "Error fetching data from YouTube API.";
        }

        curl_close($ch);
        ?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>