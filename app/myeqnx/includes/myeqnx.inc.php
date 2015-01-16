<!-- CONTENT -->
<div class="main-content">
    <nav class="wide-row row nav">
        <ul class="tabs" id="myTabs" data-tab>
            <li class="active">
                <a href="#panel1">Documents</a>
            </li>
            <li>
                <a href="#panel2">Vidéos</a>
            </li>
        </ul>
    </nav>

    <div class="tabs-content row wide-row">
        <div class="content active small-12 columns" id="panel1">
            <?php include_once 'includes/documents.inc.php'; ?>
        </div>
        <div class="content small-12 columns" id="panel2">
            <?php include_once 'includes/videos.inc.php'; ?>
        </div>
    </div>
</div>

<script> $(document).foundation(); </script>


<!-- END CONTENT -->