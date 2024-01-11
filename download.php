/<?php
    if (isset($_GET['videoId'])) {
        $videoId = $_GET['videoId'];

        $apiKey = 'AIzaSyB2fPyfhadl8SGXfaGHqmKcWul5uDkOpHY';

        $apiUrl = "https://www.googleapis.com/youtube/v3/videos?id=$videoId&part=snippet,contentDetails&key=$apiKey";
        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        if ($response !== false) {
            $data = json_decode($response, true);

            if (isset($data['items'][0])) {
                $videoTitle = $data['items'][0]['snippet']['title'];
                $videoUrl = "https://www.youtube.com/watch?v=$videoId";

                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="video.mp4"');

                readfile($videoUrl);

                exit();
            } else {
                echo 'Error fetching video details from YouTube API.';
            }
        } else {
            echo 'Error fetching data from YouTube API.';
        }

        curl_close($ch);
    } else {
        echo 'Invalid request. Video ID is missing.';
    }
