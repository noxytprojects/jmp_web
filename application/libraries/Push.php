<?php

/**
 * @author Ravi Tamada
 * @link URL Tutorial link
 */
class Push {

    // push message title
    private $title;
    private $message;
    private $image;
    // push message payload
    private $data;
    // flag indicating whether to show the push
    // notification or not
    // this flag will be useful when perform some opertation
    // in background when push is recevied
    private $is_background;
    
    private $to;
                function __construct() {
        
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setMessage($message) {
        $this->message = $message;
    }

    public function setImage($imageUrl) {
        $this->image = $imageUrl;
    }

    public function setPayload($data) {
        $this->data = $data;
    }

    public function setIsBackground($is_background) {
        $this->is_background = $is_background;
    }
    
    public function setReceiver($to) {
        $this->to = $to;
    }

    public function getPush() {
        $res = array();

        $res = [
            'notification' => [
                "title" => $this->title,
                "body" => $this->message,
                "sound" => "default",
                "click_action" => "FCM_PLUGIN_ACTIVITY",
                "icon" => $this->image
            ],
            'data' => $this->data,
            //"to" => $this->to,
            "registration_ids" => $this->to,
            "priority" => "high",
            "restricted_package_name" => ""
        ];
        return $res;
    }

}
