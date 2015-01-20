<?php require_once(dirname(__FILE__).'/functions.php'); ?>

<section class="row" id="module-wrapper">
    <h1>Documents</h1>
    <nav class="row">
        <div class="small-12 columns" id="mnu-gest">
            <i class="fa fa-plus btn" role="add"></i>
            &nbsp;   
        </div>
        <div class="small-12 columns masked" id="return-to-gest">
            <i class="fa fa-arrow-left btn" role="back-to-gest"></i>
        </div>
    </nav>
    <section class="row">
        <?php display_alert(); ?>
        <div class="small-12 columns listing" id="wrapper-gestion">
            <?php the_Listing(); ?>
        </div>
        
        <div class="small-12 columns masked" id="wrapper-adding">
            <form name="form_add" action="modules/documents/ajax.php" method="post" enctype="multipart/form-data">
               <div class="row">
                   <div class="small-6 columns">
                       <div class="row">
                           <div class="small-12 columns">
                               <input type="text" name="titre" placeholder="Titre">
                           </div>
                           <div class="small-12 columns">
                               <textarea name="descriptif" placeholder="Descriptif" rows="6"></textarea>
                           </div>
                       </div>
                   </div>
                   <div class="small-6 columns">
                       <div class="row">
                            <div class="small-12 columns">
                                <?php selectCategories(); ?>
                            </div>
                            <div id="file-uploader">
                                <div class="small-12 columns">
                                    <div class="row">
                                        <div class="small-12 columns">
                                            <label style="margin-top:1rem;">Glissez – déposez votre fichier (max 20 Mo)</label>
                                        </div>
                                        <div class="small-12 columns upload_form_cont">
                                            <div id="dropArea" class="text-center">Zone de drop</div>
                                        </div>
                                        <div class="small-12 columns">
                                            <input type="checkbox" name="private" value="1">&nbsp;Cette images est privée ?
                                        </div>
                                        <div class="small-12 columns">
                                            <div class="info">
                                                <div><input type="hidden" id="script_url" value="modules/documents/upload.php"/></div>
                                                <div><input type="hidden" id="url" value="modules/documents/upload.php"/></div>
                                                <div class="progress-bar" id="progress-bar"></div>
                                                <div id="result"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="small-12 columns text-center">
                                    ou
                                </div>
                               <div class="small-12 columns">
                                    <input type="file" name="media">
                               </div>
                           </div>
                       </div>
                   </div>
                   <div class="small-12 columns text-right">
                        <input type="hidden" name="file_name" value="">
                        <input type="reset" class="button alert" name="clear-forms" value="Annuler">
                        <input type="submit" class="button success" name="publish" value="Ajouter">
                   </div>
               </div>
            </form>
        </div>
        
        <div class="small-12 columns masked" id="wrapper-editing">
        
        </div>
        
        <div class="small-12 columns overlayed-panel" id="wrapper-sharing">
            <div class="row">
                <div class="small-12 columns lst-header">
                    Attribution des autorisations
                </div>
            </div>
        </div>
        
    </section>
</section>

<script src="modules/documents/module.js"></script>
