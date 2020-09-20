<?php

class ViewBuilder {

    private $title;
    private $file;
    private $data;

    public function __construct($file, $data) {
        $this->file = $file;
        $this->data = $data;
    }

    public function generateView() {
        $body = self::readFile($this->file, $this->data);
        echo self::readFile("template.php", array("title" => $this->title, "body" => $body));
    }

    private function readFile(string $file, array $data): string {
        extract($data);
        ob_start();
        require $file;
        return ob_get_clean();
    }
}
