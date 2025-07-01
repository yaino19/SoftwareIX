<?php
class LoggerService {
    public static function log($filename, $message) {
        $date = date('Y-m-d H:i:s');
        $entry = "[$date] $message" . PHP_EOL;
        $filePath = __DIR__ . '/../../logs/' . $filename;
        file_put_contents($filePath, $entry, FILE_APPEND | LOCK_EX);
    }
}
