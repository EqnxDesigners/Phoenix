<?php $page=$_SERVER[ 'REQUEST_URI']; ?>
<nav class="wide-row row nav">
    <ul id="myEqnx-menu">
        <?php 
            if (strpos($page, 'documents') !==false OR strpos($page, 'videos') ==false) { 
                echo '<li class="active">'; 
            }else{
                echo '<li>'; 
            } 
        ?>
        <a href="fr/documents">Documents</a>
        </li>
        <?php 
            if (strpos($page, 'videos') !==false) {
                echo '<li class="active">'; 
            }else{
                echo '<li>'; 
            } 
        ?>
        <a href="fr/videos">Vidéos</a>
        </li>
    </ul>
</nav>