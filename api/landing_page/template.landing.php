<?php
class Template
{
    private $conn;
    public $slug;
    public $status;
    public $title;
    public $title_option;
    public $description;
    public $inject_keywords;
    public $description_option;
    public $template_file;
    public $template_name;
    public $random_template_method;
    public $random_template_file;
    public $random_template_file_afs;
    public $post_urls;
    public $redirect_post_option;
    public $timer_auto_refresh;
    public $auto_refresh_option;
    public $protect_elementor;
    public $referrer_option;
    public $device_view;
    public $videos_floating_option;
    public $timer_auto_pause_video;
    public $video_urls;
    public $universal_image_urls;
    public $landing_image_urls;
    public $number_images_displayed;
    public $custom_html;
    public $parameter_key;
    public $parameter_value;
    public $cloaking_url;
    // public $cloaking_option;
    public $custom_template_builder;
    public $id; // Tambahkan properti id untuk update

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create()
    {
        $query = "INSERT INTO wp_acp_landings SET
                    slug = ?,
                    status = ?,
                    title = ?,
                    title_option = ?,
                    description = ?,
                    inject_keywords = ?,
                    description_option = ?,
                    template_file = ?,
                    template_name = ?,
                    random_template_method = ?,
                    random_template_file = ?,
                    random_template_file_afs = ?,
                    post_urls = ?,
                    redirect_post_option = ?,
                    timer_auto_refresh = ?,
                    auto_refresh_option = ?,
                    protect_elementor = ?,
                    referrer_option = ?,
                    device_view = ?,
                    videos_floating_option = ?,
                    timer_auto_pause_video = ?,
                    video_urls = ?,
                    universal_image_urls = ?,
                    landing_image_urls = ?,
                    number_images_displayed = ?,
                    custom_html = ?,
                    parameter_key = ?,
                    parameter_value = ?,
                    cloaking_url = ?,
                    -- cloaking_option = ?,
                    custom_template_builder = ?";

        $stmt = mysqli_prepare($this->conn, $query);

        if (!$stmt) {
            return false;
        }

        // Bind semua parameter
        mysqli_stmt_bind_param(
            $stmt,
            "ssssssssssssssssssssssssssssss",
            $this->slug,
            $this->status,
            $this->title,
            $this->title_option,
            $this->description,
            $this->inject_keywords,
            $this->description_option,
            $this->template_file,
            $this->template_name,
            $this->random_template_method,
            $this->random_template_file,
            $this->random_template_file_afs,
            $this->post_urls,
            $this->redirect_post_option,
            $this->timer_auto_refresh,
            $this->auto_refresh_option,
            $this->protect_elementor,
            $this->referrer_option,
            $this->device_view,
            $this->videos_floating_option,
            $this->timer_auto_pause_video,
            $this->video_urls,
            $this->universal_image_urls,
            $this->landing_image_urls,
            $this->number_images_displayed,
            $this->custom_html,
            $this->parameter_key,
            $this->parameter_value,
            $this->cloaking_url,
            // $this->cloaking_option,
            $this->custom_template_builder
        );

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            return true;
        } else {
            error_log("MySQL Error: " . mysqli_error($this->conn));
            mysqli_stmt_close($stmt);
            return false;
        }
    }

    public function isSlugExists($slug)
    {
        $query = "SELECT id FROM wp_acp_landings WHERE slug = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $slug);
        $stmt->execute();
        $stmt->store_result();
        $isExists = $stmt->num_rows > 0;
        $stmt->close();
        return $isExists;
    }

    public function findBySlug($slug)
    {
        $query = "SELECT * FROM wp_acp_landings WHERE slug = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $slug);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function update()
    {
        $query = "UPDATE wp_acp_landings SET
                slug = ?, status = ?, title = ?, title_option = ?,
                description = ?, inject_keywords = ?, description_option = ?,
                template_file = ?, template_name = ?, random_template_method = ?,
                random_template_file = ?, random_template_file_afs = ?, post_urls = ?,
                redirect_post_option = ?, timer_auto_refresh = ?, auto_refresh_option = ?,
                protect_elementor = ?, referrer_option = ?, device_view = ?,
                videos_floating_option = ?, timer_auto_pause_video = ?, video_urls = ?,
                universal_image_urls = ?, landing_image_urls = ?, number_images_displayed = ?,
                custom_html = ?, parameter_key = ?, parameter_value = ?,
                cloaking_url = ?, custom_template_builder = ?
            WHERE id = ?";

        $stmt = mysqli_prepare($this->conn, $query);

        if (!$stmt) {
            // Untuk debugging jika prepare gagal
            error_log("MySQLi Prepare Error: " . mysqli_error($this->conn));
            return false;
        }

        // Langkah 1: Tampung semua properti ke variabel lokal
        $slug = $this->slug;
        $status = $this->status;
        $title = $this->title;
        $title_option = $this->title_option;
        $description = $this->description;
        $inject_keywords = $this->inject_keywords;
        $description_option = $this->description_option;
        $template_file = $this->template_file;
        $template_name = $this->template_name;
        $random_template_method = $this->random_template_method;
        $random_template_file = $this->random_template_file;
        $random_template_file_afs = $this->random_template_file_afs;
        $post_urls = $this->post_urls;
        $redirect_post_option = $this->redirect_post_option;
        $timer_auto_refresh = $this->timer_auto_refresh;
        $auto_refresh_option = $this->auto_refresh_option;
        $protect_elementor = $this->protect_elementor;
        $referrer_option = $this->referrer_option;
        $device_view = $this->device_view;
        $videos_floating_option = $this->videos_floating_option;
        $timer_auto_pause_video = $this->timer_auto_pause_video;
        $video_urls = $this->video_urls;
        $universal_image_urls = $this->universal_image_urls;
        $landing_image_urls = $this->landing_image_urls;
        $number_images_displayed = $this->number_images_displayed;
        $custom_html = $this->custom_html;
        $parameter_key = $this->parameter_key;
        $parameter_value = $this->parameter_value;
        $cloaking_url = $this->cloaking_url;
        $custom_template_builder = $this->custom_template_builder;
        $id = $this->id;

        // Langkah 2: Gunakan variabel lokal untuk binding (INI BAGIAN PENTINGNYA)
        // Pastikan bagian ini TIDAK ADA TANDA KOMENTAR (// atau /* */)
        mysqli_stmt_bind_param(
            $stmt,
            "ssssssssssssssssssssssssssssssi",
            $slug,
            $status,
            $title,
            $title_option,
            $description,
            $inject_keywords,
            $description_option,
            $template_file,
            $template_name,
            $random_template_method,
            $random_template_file,
            $random_template_file_afs,
            $post_urls,
            $redirect_post_option,
            $timer_auto_refresh,
            $auto_refresh_option,
            $protect_elementor,
            $referrer_option,
            $device_view,
            $videos_floating_option,
            $timer_auto_pause_video,
            $video_urls,
            $universal_image_urls,
            $landing_image_urls,
            $number_images_displayed,
            $custom_html,
            $parameter_key,
            $parameter_value,
            $cloaking_url,
            $custom_template_builder,
            $id
        );

        $result = mysqli_stmt_execute($stmt);

        if (!$result) {
            // Untuk debugging jika eksekusi gagal
            error_log("MySQLi Execute Error: " . mysqli_stmt_error($stmt));
        }

        mysqli_stmt_close($stmt);
        return $result;
    }

    public function isSlugTakenByAnother($slug, $currentId)
    {
        // Query untuk mencari slug yang sama, TAPI bukan pada ID yang sedang diedit
        $query = "SELECT id FROM wp_acp_landings WHERE slug = ? AND id != ?";

        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->conn->error);
            return true; // Anggap saja terpakai untuk mencegah error
        }

        // "si" artinya parameter pertama string (slug), kedua integer (id)
        $stmt->bind_param("si", $slug, $currentId);

        $stmt->execute();
        $stmt->store_result();

        // Jika jumlah baris yang ditemukan lebih dari 0, berarti slug sudah dipakai
        $isTaken = $stmt->num_rows > 0;

        $stmt->close();

        return $isTaken;
    }
}
