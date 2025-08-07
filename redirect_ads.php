<?php
include_once 'config/config.php';
include_once 'api/landing_page/template.landing.php';

// $slug = $_GET['slug'] ?? null;

// if (!$slug) {
//     http_response_code(400);
//     echo "Slug tidak ditemukan.";
//     exit;
// }

// $template = new Template($connection);
// $templateData = $template->findBySlug($slug); // Method baru di bawah

// if (!$templateData) {
//     http_response_code(404);
//     echo "Template tidak ditemukan.";
//     exit;
// }

// // Validasi referrer: dari ads (facebook, google, dll)
// $referer = $_SERVER['HTTP_REFERER'] ?? '';
// $isFromAds = preg_match('/facebook\.com|t\.co|googleadservices\.com|doubleclick\.net/', $referer);

// // Pecah post_urls (formatnya string dengan \r\n)
// $post_urls = preg_split("/\r\n|\n|\r/", $templateData['post_urls']);
// $video_urls = json_decode($templateData['video_urls'], true);
// $img_urls = json_decode($templateData['universal_image_urls'], true);

// if ($isFromAds) {
//     echo "<!DOCTYPE html><html><head><title>{$templateData['title']}</title></head><body style='text-align:center;padding:20px;'>";

//     echo "<h2>{$templateData['title']}</h2>";

//     // Video (ambil yang pertama)
//     if (!empty($video_urls[0])) {
//         echo "<video width='640' controls autoplay>
//                 <source src='{$video_urls[0]}' type='video/webm'>
//                 Browser tidak support video.
//               </video><br><br>";
//     }

//     // Gambar (ambil yang pertama)
//     if (!empty($img_urls[0])) {
//         echo "<img src='{$img_urls[0]}' alt='Gambar' width='640'><br>";
//     }

//     echo "</body></html>";
// } else {
//     // Redirect ke salah satu post_url secara random
//     $redirectTo = $post_urls[array_rand($post_urls)];
//     header("Location: $redirectTo");
//     exit;
// }




// include_once '../../config/config.php';
// include_once 'template.landing.php';

$slug = $_GET['slug'] ?? null;
$mode = $_GET['mode'] ?? null;

if (!$slug) {
    http_response_code(400);
    echo "Slug tidak ditemukan.";
    exit;
}

$template = new Template($connection);
$templateData = $template->findBySlug($slug);

if (!$templateData) {
    http_response_code(404);
    echo "Template tidak ditemukan.";
    exit;
}

// Simulasi: kalau pakai mode manual, kita pakai itu
if ($mode === 'ads') {
    $isFromAds = true;
} elseif ($mode === 'public') {
    $isFromAds = false;
} else {
    // Kalau nggak pakai mode, baru cek dari HTTP_REFERER
    $referer = $_SERVER['HTTP_REFERER'] ?? '';
    $isFromAds = preg_match('/facebook\.com|t\.co|googleadservices\.com|doubleclick\.net/', $referer);
}

$post_urls = preg_split("/\r\n|\n|\r/", $templateData['post_urls']);
$video_urls = json_decode($templateData['video_urls'], true);
$img_urls = json_decode($templateData['universal_image_urls'], true);

if ($isFromAds) {
    echo "<!DOCTYPE html><html><head><title>{$templateData['title']}</title></head><body style='text-align:center;padding:20px;'>";
    echo "<h2>{$templateData['title']}</h2>";

    if (!empty($video_urls[0])) {
        echo "<video width='640' controls autoplay>
                <source src='{$video_urls[0]}' type='video/webm'>
                Browser tidak support video.
              </video><br><br>";
    }

    if (!empty($img_urls[0])) {
        echo "<img src='{$img_urls[0]}' alt='Gambar' width='640'><br>";
    }

    echo "</body></html>";
} else {
    $redirectTo = $post_urls[array_rand($post_urls)];
    // $redirectTo = $templateData['cloaking_url'];
    header("Location: $redirectTo");
    exit;
}
