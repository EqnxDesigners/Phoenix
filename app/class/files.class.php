<?php
/*           
==================================================================
Fichier: files.class.php                                
Description: Class de gestion des fichiers   
------------------------------------------------------------------
Auteur: Jérôme Clerc                              
Editeurs: Jérôme Clerc
Société: Equinoxe MIS Development                 
Version: 1.0               
------------------------------------------------------------------
Changelog
------------------------------------------------------------------
??.??.???? - 1.1
xxxxxxx

==================================================================
*/

class Files {
	/* ATTRIBUTS */
	private $_filename;                             //Nom original du fichier
	private $_filetmpname;                          //tmp_name lors de l'upload
    private $_filetype;                             //Type de fichier
    private $_fileerror;                            //Gestion des erreures
    private $_finalname;                            //Nom original du fichier nettoyé des caratères spéciaux et espaces
    private $_oldimage;                             //Image originale virtuelle
	private $_path;                                 //Chemin de destination du fichier
    private $_originalwidth;                        //Largeur originale
    private $_originalheight;                       //Hauteur originale
    private $_canvaswidth;                          //Largeur du canvas
    private $_canvasheight;                         //Hauteur du canvas
    private $_newwidth;                             //Nouvelle largeur
    private $_newheight;                            //Nouvelle hauteur
    private $_poshoriz;                             //Nouvelle position X
    private $_posverti;                             //Nouvelle position Y
    private $_canvascolor;                          //Couleur du fond de la nouvelle image (par défaut, blanc)
    private $_maximgdim;                            //Largeur maximale d'une image
	
	/* CONSTRUCTEUR */
	public function __construct() {
        //Constructeur
        //$this->setMaxImgDim(MAX_IMG_DIM);
	}
	
	/* GETTER */
	public function getFileName()			        { return $this->_filename; }
	public function getFileTmpName()		        { return $this->_filetmpname; }
    public function getFileType()   		        { return $this->_filetype; }
    public function getFileError()			        { return $this->_fileerror; }
    public function getFinalName()                  { return $this->_finalname; }
    public function getOldImage()			        { return $this->_oldimage; }
	public function getPath()			            { return $this->_path; }
    public function getOriginalWidth()              { return $this->_originalwidth; }
    public function getOriginalHeight()             { return $this->_originalheight; }
    public function getCanvasWidth()                { return $this->_canvaswidth; }
    public function getCanvasHeight()               { return $this->_canvasheight; }
    public function getNewWidth()                   { return $this->_newwidth; }
    public function getNewHeight()                  { return $this->_newheight; }
    public function getPosHoriz()                   { return $this->_poshoriz; }
    public function getPosVerti()                   { return $this->_posverti; }
    public function getCanvasColor()                { return $this->_canvascolor; }
    public function getMaxImgDim()                  { return $this->_maximgdim; }
	
	/* SETTER */
	public function setFileName($filename)		    { $this->_filename = $filename; }
	public function setFileTmpName($filetmpname)    { $this->_filetmpname = $filetmpname; }
    public function setFileType($filetype)          { $this->_filetype = $filetype; }
    public function setFileError($fileerror)	    { $this->_fileerror = $fileerror; }
    public function setFinalName($finalname)        { $this->_finalname = $finalname; }
    public function setOldImage($oldimage)		    { $this->_oldimage = $oldimage; }
	public function setPath($path)			        { $this->_path = $path; }
    public function setOriginalWidth($owidth)       { $this->_originalwidth = $owidth; }
    public function setOriginalHeight($oheight)     { $this->_originalheight = $oheight; }
    public function setCanvasWidth($cwidth)         { $this->_canvaswidth = $cwidth; }
    public function setCanvasHeight($cheight)       { $this->_canvasheight = $cheight; }
    public function setNewWidth($nwidth)            { $this->_newwidth = $nwidth; }
    public function setNewHeight($nheight)          { $this->_newheight = $nheight; }
    public function setPosHoriz($poshoriz)          { $this->_poshoriz = $poshoriz; }
    public function setPosVerti($posverti)          { $this->_posverti = $posverti; }
    public function setCanvasColor($canvascolor)    { $this->_canvascolor = $canvascolor; }
    public function setMaxImgDim($maximgdim)        { $this->_maximgdim = $maximgdim; }
	
        /* METHODES */
	public function UploadFile($file, $path, $dimensions=null, $prefix=null, $canvas_color='#ffffff') {
        /////////////////////////////////////////////////////////////////////////////////////////
        // PARAMETRES                                                                        
        //                                                                                   
        // $dimensions :    reçoit en paramètre widthXheight
        // $prefix :        ajout un préfix timestamp au nom du fichier
        // $canvas_color :  couleur de fond de la nouvelle image
        /////////////////////////////////////////////////////////////////////////////////////////              

        //Encapsulation des variables
        $this->setFileName($file['name']);
        $this->setFileTmpName($file['tmp_name']);
        $this->setFileType($file['type']);
        $this->setFileError($file['error']);
        $this->setPath($path);
        //$this->setPath(DEFAULT_PATH);
        $this->setCanvasColor($canvas_color);

        if($this->_fileerror == '1') {
            throw new Exception('La taille du fichier excède 2Mo. Merci de le compresser.');
        }

        //Cleaning du nom de fichier
        $this->cleanFileName($this->_filename);

        //Ajout d'un préfix
        if($prefix == 'prefix' || $prefix == 'presize') {
            $this->prefixFileName();
        }

        ////////////
        // Upload //
        ////////////

        //Test si le fichier est une image ou un document
        if(!$this->isImage()) {
            //Le fichier est un document
            try {
                //Upload le fichier
                $this->isUploaded();
            }
            catch(Exception $e) {
                throw new Exception($e->getMessage());
            }
        }
        else {
            //Le fichier est une image
            //Test si des dimensions sont passées en paramètre
            if($dimensions == null) {
                //Aucune dimensions spécifées
                //Test si l'image est plus large que le MAX autorisé
                if(imagesx($this->_oldimage) > $this->_maximgdim || imagesy($this->_oldimage) > $this->_maximgdim) {
                    //Largeur supérieur au MAX autorisé
                    //Récupération des dimensions de l'image originale
                    $this->setOriginalImgSize();
                    //Calcul des nouvelles dimensions du canvas
                    $this->calculNewDimensions();
                    try {
                        //Upload et redimensionne le fichier
                        $this->isUploaded('resize');
                    }
                    catch (Exception $e) {
                        throw new Exception($e->getMessage());
                    }
                }
                else {
                    //Largeur inférieur au MAX autorisé
                    try {
                        //Upload le fichier
                        $this->isUploaded();
                    }
                    catch (Exception $e) {
                        throw new Exception($e->getMessage());
                    }
                }
            }
            else {
                //Dimensions spécifiées
                //Récupération des dimensions de l'image originale
                $this->setOriginalImgSize();
                //Récupération des dimensions
                $this->getCanvasDimensions($dimensions);
                //Calcul des nouvelles dimensions du canvas
                $this->calculNewDimensions();
                //Ajout d'un suffix avec le format au nom du fichier
                $this->suffixName();
                try {
                    //Upload et redimensionne le fichier
                    $this->isUploaded('resize');
                }
                catch (Exception $e) {
                    throw new Exception($e->getMessage());
                }
            }
        }

        return $this->_finalname;
	}
        
    private function isUploaded($action='move') {
        /////////////////////////////////////////////////////////////////////////////////////////
        // PARAMETRES                                                                        
        //                                                                                   
        // $action :        move   : déplace le fichier sur le serveur
        //                  resize : déplace et génère une nouvelle image au bon format 
        /////////////////////////////////////////////////////////////////////////////////////////
        if(!is_uploaded_file($this->_filetmpname) || $this->getFileError() != UPLOAD_ERR_OK) {
            throw new Exception('Problème à l\'upload du fichier');
        }
        else {
            if($action == 'move') {
                $this->moveFile();
            }
            else {
                $this->moveResizeFile();
            }
        }
    }
	
	private function moveFile() {
        ini_set ( "memory_limit", "256M");
        if(!file_exists($this->_path)) {
            throw new Exception('Chemin spécifié inexistant');
        } else {
            /*if(!move_uploaded_file($this->_filetmpname, $this->_path.$this->_finalname)) {*/
            if(!copy($this->_filetmpname, $this->_path.$this->_finalname)) {
                throw new Exception('Erreur lors du déplacement du fichier.');
            }
            else {
                chmod($this->_path.$this->_finalname, 0644);
            }
        }
	}
        
    private function moveResizeFile() {
        ini_set ( "memory_limit", "256M");

        //Creation d'une nouvelle image vide
        $new = imagecreatetruecolor($this->_canvaswidth, $this->_canvasheight);
        //Traitement d'un jpg
        if(strtolower($this->_filetype) == 'image/jpeg') {
            //Remplissage de l'image par un fond de couleur
            $tab_color = $this->splitCanvasColor();
            $bgImage = imagecolorallocate($new, "0x".$tab_color[0], "0x".$tab_color[1], "0x".$tab_color[2]);
            imagefill($new, 0, 0, $bgImage);
            //Redimensionnement de l'ancienne image dans la nouvelle image
            imagecopyresampled($new, $this->_oldimage, 0, 0, 0, 0, $this->_canvaswidth, $this->_canvasheight, $this->_newwidth,  $this->_newheight);
        }
        //Traitement d'un png
        if(strtolower($this->_filetype) == 'image/png' || strtolower($this->_filetype) == 'image/gif') {
            //Activation de l'alphablending
            imagealphablending($new, true);
            //Allocation d'une couleur transparente au fond de l'image
            $bgImage = imagecolorallocatealpha( $new, 0, 0, 0, 127 ); 
            imagefill( $new, 0, 0, $bgImage );
            //Redimensionnement de l'ancienne image dans la nouvelle image
            imagecopyresampled($new, $this->_oldimage, 0, 0, 0, 0, $this->_canvaswidth, $this->_canvasheight, $this->_newwidth,  $this->_newheight);
            //Désactivation de l'alphablending
            imagealphablending($new, false);
            //Sauvegarde de la transparence
            imagesavealpha($new,true); 
        }
        //Création du fichier physique en sortie
        $this->generateFinalImg($new);
        chmod($this->_path.$this->_finalname, 0644);
        //Destruction des ressources et libération de la mémoire
        $this->killTmpImg($new);
    }
        
    private function generateFinalImg($new) {
        switch(strtolower($this->_filetype)) {
            case 'image/jpeg':
                imagejpeg($new,$this->_path.$this->_finalname, 95);
                break;
            case 'image/png':
                imagepng($new,$this->_path.$this->_finalname, 0);
                break;
            case 'image/gif':
                imagegif($new,$this->_path.$this->_finalname);
                break;
        }	
    }

    private function killTmpImg($img) {
        imagedestroy($this->_oldimage);
        imagedestroy($img);
    }

    private function isImage() {
        //Contrôle du type de fichier
        //On créé l'image d'origine virtuellement
        switch(strtolower($this->_filetype)) {
            case 'image/jpeg':
                $result = true;
                $this->setOldImage(imagecreatefromjpeg($this->_filetmpname));
                break;
            case 'image/png':
                $result = true;
                $this->setOldImage(imagecreatefrompng($this->_filetmpname));
                imagealphablending($this->_oldimage, false);
                imagesavealpha($this->_oldimage, true);
                break;
            case 'image/gif':
                $result = true;
                $this->setOldImage(imagecreatefromgif($this->_filetmpname));
                break;
            default:
                $result = false;
        }	
        return $result;
	}
        
    private function calculNewPosition() {
        $this->setPosHoriz(($this->_originalwidth / 2)-($this->_canvaswidth / 2));
        $this->setPosVerti(($this->_originalheight / 2)-($this->_canvasheight / 2));
    }
        
    private function calculNewDimensions() {
        //Le format est prédéfini
        if($this->_canvaswidth != null && $this->_canvasheight != null) {
            $this->calculRedimImgPero();
        }
        //L'image uploader à l'échelle 1:1 est trop grande, adaptation de la hauteur
        if($this->_canvaswidth == null && $this->_canvasheight == null) {
            //Image en paysage
            if($this->_originalwidth > $this->_originalheight) {
                $this->setCanvasWidth($this->_maximgdim);
                $this->setCanvasHeight($this->_originalheight * ($this->_canvaswidth / $this->_originalwidth));
                $this->calculRedimImgPero();
            }
            //Image en portrait
            else {
                $this->setCanvasHeight($this->_maximgdim);
                $this->setCanvasWidth($this->_originalwidth * ($this->_canvasheight / $this->_originalheight));
                $this->calculRedimImgPero();
            }

        }
        //Largeur fixe, adaptation de la hauteur
        if($this->_canvaswidth != 0 && $this->_canvasheight == 0) {
            $this->setCanvasHeight($this->_originalheight * ($this->_canvaswidth / $this->_originalwidth));
            $this->calculRedimImgPero();
        }
        //Hauteur fixe, adaptation de la largeur
        if($this->_canvaswidth == 0 && $this->_canvasheight != 0) {
            $this->setCanvasWidth($this->_originalwidth * ($this->_canvasheight / $this->_originalheight));
            $this->calculRedimImgPero();
        }
    }
        
    private function calculRedimImgPero() {
        //Canvas paysage
        if($this->_canvaswidth > $this->_canvasheight) {
            $this->calculRedimImgLandscape();
        }
        //Canvas paysage
        if($this->_canvaswidth < $this->_canvasheight) {
            $this->calculRedimImgPortrait();
        }
        //Format carré
        if($this->_canvaswidth == $this->_canvasheight) {
            if($this->_originalwidth < $this->_originalheight) {
                $this->setNewWidth($this->_originalwidth);
                $this->setNewHeight($this->_originalwidth);
            }
            else {
                $this->setNewWidth($this->_originalheight);
                $this->setNewHeight($this->_originalheight);
            }
        }
    }

    private function calculRedimImgLandscape() {
        $this->setNewHeight($this->_canvasheight / ($this->_canvaswidth / $this->_originalwidth));
        $this->setNewWidth($this->_originalwidth);
    }

    private function calculRedimImgPortrait() {
        $this->setNewWidth($this->_canvaswidth / ($this->_canvasheight / $this->_originalheight));
        $this->setNewHeight($this->_originalheight);
    }

    private function setOriginalImgSize() {
        $dims = getimagesize($this->_filetmpname);
        $this->setOriginalWidth($dims[0]);
        $this->setOriginalHeight($dims[1]);
    }

    private function getCanvasDimensions($dim) {
        $result = explode('X', $dim);
        $this->setCanvasWidth($result['0']);
        $this->setCanvasHeight($result['1']);
    }
        
	private function splitCanvasColor() {
        $canvas_color = $this->_canvascolor;
        $canvas_color = str_replace("#","",$canvas_color);

        return str_split($canvas_color,2);
	}

    private function buildTimeStamp() {
        return $timestamp = time();
	}
	
	private function prefixFileName() {
            $this->setFinalName($this->buildTimeStamp().'_'.$this->_finalname);
	}
        
    private function suffixName() {
        $name = explode('.', $this->_finalname);
        $this->setFinalName($name[0].'_'.ceil($this->_canvaswidth).'x'.ceil($this->_canvasheight).'.'.$name[1]);
    }
	
	private function cleanFileName() {
        $search = array('à','á','â','ã','ä','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ù','ú','û','ü','ý','ÿ',
                        'À','Á','Â','Ã','Ä','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ñ','Ò','Ó','Ô','Õ','Ö','Ù','Ú','Û','Ü','Ý',' ');
        $replace = array('a','a','a','a','a','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','u','u','u','u','y','y',
                         'A','A','A','A','A','C','E','E','E','E','I','I','I','I','N','O','O','O','O','O','U','U','U','U','Y', '_');

        $result = str_replace($search, $replace, $this->_filename);
        $this->setFinalName(strtolower($result));
	}

	public function __destruct() {
        //Destructeur
	}
}
?>