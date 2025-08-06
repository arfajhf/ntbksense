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

    public function findBySlug($slug)
    {
        $query = "SELECT * FROM wp_acp_landings WHERE slug = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $slug);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
