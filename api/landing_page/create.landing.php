<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Include config dan class Template
include_once '../../config/config.php';        // <-- ini yang punya $connection
include_once 'template.landing.php';           // <-- class Template

// Ambil input JSON
$data = json_decode(file_get_contents("php://input"));

// Cek apakah slug dan title ada
if (empty($data->slug) || empty($data->title)) {
    http_response_code(400);
    echo json_encode([
        "message" => "Gagal: slug dan title wajib diisi."
    ]);
    exit;
}

// Buat objek Template
$template = new Template($connection);

// Isi semua field
$template->slug = $data->slug;
$template->status = $data->status ?? 1;
$template->title = $data->title;
$template->title_option = $data->title_option ?? '';
$template->description = $data->description ?? '';
$template->inject_keywords = $data->inject_keywords ?? '';
$template->description_option = $data->description_option ?? '';
$template->template_file = $data->template_file ?? '';
$template->template_name = $data->template_name ?? '';
$template->random_template_method = $data->random_template_method ?? '';
$template->random_template_file = $data->random_template_file ?? '';
$template->random_template_file_afs = $data->random_template_file_afs ?? '';
$template->post_urls = $data->post_urls ?? '';
$template->redirect_post_option = $data->redirect_post_option ?? '';
$template->timer_auto_refresh = $data->timer_auto_refresh ?? 0;
$template->auto_refresh_option = $data->auto_refresh_option ?? '';
$template->protect_elementor = $data->protect_elementor ?? '';
$template->referrer_option = $data->referrer_option ?? '';
$template->device_view = $data->device_view ?? '';
$template->videos_floating_option = $data->videos_floating_option ?? '';
$template->timer_auto_pause_video = $data->timer_auto_pause_video ?? 0;
$template->video_urls = $data->video_urls ?? '';
$template->universal_image_urls = $data->universal_image_urls ?? '';
$template->landing_image_urls = $data->landing_image_urls ?? '';
$template->number_images_displayed = $data->number_images_displayed ?? 0;
$template->custom_html = $data->custom_html ?? '';
$template->parameter_key = $data->parameter_key ?? '';
$template->parameter_value = $data->parameter_value ?? '';
$template->cloaking_url = $data->cloaking_url ?? '';
$template->custom_template_builder = $data->custom_template_builder ?? '';

// Coba simpan

if ($template->create()) {
    // Ganti ini dengan domain lo sendiri
    // $baseUrl = "https://yourdomain.com";
    $baseUrl = "http://ntbksenseapi.test";

    $adsUrl = "$baseUrl/redirect_ads.php?slug=" . urlencode($template->slug);
    $publicUrl = "$baseUrl/redirect_ads.php?slug=" . urlencode($template->slug);

    http_response_code(201);
    echo json_encode([
        "message" => "Template berhasil dibuat!",
        "ads_url" => $adsUrl,
        "public_url" => $publicUrl
    ]);
} else {
    http_response_code(503);
    echo json_encode([
        "message" => "Gagal membuat template. Cek log atau struktur database."
    ]);
}
?>