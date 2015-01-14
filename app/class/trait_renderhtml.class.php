<?php
trait Trait_renderhtml {
    
    public function renderHtml($html) {
        ob_start();
        echo $html;
        ob_flush();
        ob_clean();
    }
}
?>