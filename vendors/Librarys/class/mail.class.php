<?php
/*           
==================================================================
Fichier: mail.class.php                                
Description: class PHP qui gère l'envoi de mail                      
------------------------------------------------------------------
Auteur: Jérôme Clerc                              
Editeurs: Jérôme Clerc
Société: e-novinfo Sàrl                              
Version: 1.1                             
------------------------------------------------------------------
Changelog
------------------------------------------------------------------
- 29.11.2012 - v. 1.1 -
Methode "mailHTMLWithFiles" : mail avec un template HTML et fichiers joints

==================================================================
*/

class MAIL {
	/* ATTRIBUTS */
	private $_header;
	private $_subject;
	private $_mail;
	private $_email;
	private $_path;
	private $_boundary1;
	private $_boundary2;
	private $_lstimages;
	private $_lstpaths;
	private $_htmlcontent;

	/* CONSTANTES */
	const MAIL_NAME		= "Chassot Concept";
	const MAIL_SENDER	= "gruyere-cycling-tour@chassotconcept.ch";
	const MAIL_TEST		= "jerome.clerc@e-novinfo.ch";
	const MAIL_CHARSET	= "utf-8";
	const ENDLINE		= "\r\n";

	/* METHODES */
	public function __construct() {
		//constructeur de la class
		//$this->setEmail(self::MAIL_TEST);
		$this->buildBoundarys();
	}

	/* GETTER */
    public function getHeader()						{ return $this->_header; }
    public function getSubjet()						{ return $this->_subject; }
    public function getMail()						{ return $this->_mail; }
    public function getEmail()						{ return $this->_email; }
    public function getPath()						{ return $this->_path; }
	public function getBoundary1()					{ return $this->_boundary1; }
	public function getBoundary2()					{ return $this->_boundary2; }
	public function getLstImages()					{ return $this->_lstimages; }
	public function getLstPaths()					{ return $this->_lstpaths; }
	public function getHtmlContent()				{ return $this->_htmlcontent; }

	/* SETTER */
	public function setHeader($header)				{ $this->_header = $header; }
	public function setSubject($subject)                            { $this->_subject = $subject; }
	public function setMail($mail)					{ $this->_mail = $mail; }
	public function setEmail($email)				{ $this->_email = $email; }
	public function setPath($path)					{ $this->_path = $path; }
            public function setBoundary1($boundary)			{ $this->_boundary1 = $boundary; }
            public function setBoundary2($boundary)			{ $this->_boundary2 = $boundary; }
            public function setLstImages($lstimages)                    { $this->_lstimages = $lstimages; }
            public function setLstPaths($lstpaths)			{ $this->_lstpaths = $lstpaths; }
	public function setHtmlContent($htmlcontent)                    { $this->_htmlcontent = $htmlcontent; }

	//Envoi du mail
	private function sendMail() {
		//Envoi du mail
		if(!mail($this->getEmail(), $this->getSubjet(), $this->getMail(), $this->getHeader())) {
			throw new ERRORS('Le mail n/a pas pu &ecirc;tre envoy&eacute; !');
		}
	}
	
	//Envoi d'un mail simple
	public function mailSimple($message, $email, $subject) {
		//Encapsulation
		$this->setSubject($subject);
		$this->setEmail($email);
		
		//Génération du Header
		$this->buildHeader();
		
		//Ajout du message
		$this->setMail($message);
		
		//Envoi du mail
		$this->sendMail();
	}
	
	//Envoi d'un mail HTML
	public function mailHTML($message, $email, $subject) {
		//Encapsulation
		$this->setHtmlContent($message);
		$this->setEmail($email);
		$this->setSubject($subject);
		
		//Génération du Header
		$this->buildHeader();
		
		//Starter du mail
		$this->startMail();
		
		//Check si le message contient des images
		if($this->checkIfImgs($this->getHtmlContent()) === true) {
			//Ajout des référence à chaque images
			$this->addRefToImg();
			
			//Ajout du message HTML
			$this->addHTMLWithImg();
		}
		else {
			//Ajout du message HTML
			$this->addHTMLContent();
		}
		
		//Fermeture du mail
		$this->concatElements($this->getMail(), $this->closeBoundary('1'));
		
		//Envoi du mail
		$this->sendMail();
	}
	
	//Envoi d'un mail avec HTML et pièces jointes
	public function mailHTMLWithFiles($message, $email, $subject, $path, $array_files) {
		//Encapsulation
		$this->setHtmlContent($message);
		$this->setEmail($email);
		$this->setSubject($subject);
		$this->setPath($path);
		
		//Génération du Header
		$this->buildHeader();
		
		//Starter du mail
		$this->startMail();
		
		//Check si le message contient des images
		if($this->checkIfImgs($this->getHtmlContent()) === true) {
			//Ajout des référence à chaque images
			$this->addRefToImg();
			
			//Ajout du message HTML
			$this->addHTMLWithImg();
		}
		else {
			//Ajout du message HTML
			$this->addHTMLContent();
		}
		
		//Encodage des pièces jointes
		for($i=0;$i<count($array_files);$i++) {
			$this->addAttachment($array_files[$i]['name']);
		}
		
		//Fermeture du mail
		$this->concatElements($this->getMail(), $this->closeBoundary('1'));
		
		//Envoi du mail
		$this->sendMail();
	}
	
	//Génération du header principal
	private function buildHeader() {
		$header  = "From: \"".self::MAIL_NAME."\" <".self::MAIL_SENDER.">".self::ENDLINE;
		$header .= "Reply-to: \"".self::MAIL_NAME."\" <".self::MAIL_SENDER.">".self::ENDLINE;
		$header .= "MIME-Version: 1.0".self::ENDLINE;
		$header .= "Content-type: multipart/mixed;".self::ENDLINE." boundary=\"".$this->getBoundary1()."\"".self::ENDLINE;
		
		$this->setHeader($header);
	}

	//Génération du début du message
	private function startMail() {
		$header  = $this->openBoundary('1');
		$header .= "Content-Type: multipart/alternative; ".self::ENDLINE." boundary=\"".$this->getBoundary2()."\"".self::ENDLINE;
		$header .= $this->openBoundary('2');
		$this->setMail($header);
	}
	
	//Ajouter d'un contenu HTML
	private function addHTMLContent() {
		$content  = "Content-Type: text/html; charset=\"".self::MAIL_CHARSET."\"".self::ENDLINE;
		$content .= "Content-Transfer-Encoding: 8bit".self::ENDLINE;
		$content .= self::ENDLINE.$this->getHtmlContent().self::ENDLINE;
		$content .= $this->closeBoundary('2');
		
		$this->concatElements($this->getMail(), $content);
	}
	
	//Ajouter du contenu HTML avec des images incluses
	private function addHTMLWithImg() {
		//Récupération des listes
		$lst_images = $this->getLstImages();
		$lst_paths  = $this->getLstPaths();
		
		//Header de la partie HTML du mail
		$content  = "Content-Type: text/html; charset=\"".self::MAIL_CHARSET."\"".self::ENDLINE;
		$content .= "Content-Transfer-Encoding: 8bit".self::ENDLINE;
		$content .= self::ENDLINE.$this->getHtmlContent().self::ENDLINE;
		$content .= self::ENDLINE;
		
		//Pour chaque images incluses dans le mail
		for($i=0;$i<count($lst_images);$i++) {
			$content .= $this->openBoundary('2');
			$content .= $this->encodeEmbededImg($lst_paths[$i], $lst_images[$i], $i);
		}
		
		//Fermeture
		$content .= $this->closeBoundary('2');
		$content .= $this->closeBoundary('2');
		
		//Concaténation
		$this->concatElements($this->getMail(), $content);
	}
	
	//Ajout d'une pièce jointe
	private function addAttachment($file) {
		//Détermination du type de fichier
		$file_type = filetype($file);
		
		//Encodage du fichier
		$file_readed = $this->readFile($this->getPath(), $file);
		$file_encoded = $this->encodeFile64($file_readed);
		
		$content  = $this->openBoundary('1');
		$content .= "Content-Type: ".$file_type."; name=\"".$file."\"".self::ENDLINE;
		$content .= "Content-Transfer-Encoding: base64".self::ENDLINE;
		$content .= self::ENDLINE.$file_encoded.self::ENDLINE.self::ENDLINE;
		
		//Concaténation
		$this->concatElements($this->getMail(), $content);
	}
	
	//Encodage de la liste des images jointe dans le HTML
	private function encodeEmbededImg($path, $file, $key) {
		//Lecture des fichiers
		$attached = $this->readFile($path, $file);
	
		//Encodage
		$encoded_attached = $this->encodeFile64($attached);
		
		//Ajout au contenu HTML
		$content  = "Content-Type: application/octet-stream; name=\"".$file."\"".self::ENDLINE;
		$content .= "Content-Transfer-Encoding: base64".self::ENDLINE; 
		$content .= "Content-ID: <image".$key.">".self::ENDLINE;
		$content .= self::ENDLINE.$encoded_attached.self::ENDLINE;
		$content .= self::ENDLINE.self::ENDLINE;
		
		return $content;	
	}
	
	//Lecture d'un fichier
	private function readFile($path, $file) {
		$fp = fopen($path.$file, 'r') or die('Le fichier : '.$path.$file.' ne peut pas &ecirc;tre lu...');
		$result = fread($fp, filesize($path.$file));
		//$result = chunk_split(base64_encode($attached));
		fclose($fp);
		
		return $result;
	}
	
	//Encodage 64bit d'un fichier
	private function encodeFile64($file) {
		return $result = chunk_split(base64_encode($file));
	}

	//Génération de la BOUNDARY
	private function buildBoundarys() {
		$boundary1 = "-----=".md5(rand());
		$boundary2 = "-----=".md5(rand());
		
		$this->setBoundary1($boundary1);
		$this->setBoundary2($boundary2);
	}
	
	//Ouverture de BOUNDARY
	private function openBoundary($index) {
		if($index == '1') {
			return $boundary = self::ENDLINE.'--'.$this->getBoundary1().self::ENDLINE;
		}
		else {
			return $boundary = self::ENDLINE.'--'.$this->getBoundary2().self::ENDLINE;
		}
	}
	
	//Fermeture de BOUNDARY
	private function closeBoundary($index) {
		if($index == '1') {
			return $boundary = self::ENDLINE.'--'.$this->getBoundary1().'--'.self::ENDLINE;
		}
		else {
			return $boundary = self::ENDLINE.'--'.$this->getBoundary2().'--'.self::ENDLINE;
		}
	}
	
	//Concaténation des éléments du mail
	private function concatElements($first, $second) {
		$result = $first.$second;
		
		$this->setMail($result);
	}
	
	//Récupération des données HTML
	public function getTemplate($file) {
		return $result = file_get_contents($file);
	}
	
	//Recherche les images dans du HTML
	private function checkIfImgs() {
		if (preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/Ui', $this->getHtmlContent(), $matches)) {
			
			//Récupération du chemin et du nom de fichier
			$lst_images = array();
			$lst_paths  = array();
			
			for($i=0;$i<count($matches['1']);$i++) {
				$decomp = explode('/', $matches['1'][$i]);
				
				//Récupération du chemin
				$path = '';
				for($j=0;$j<count($decomp)-1;$j++) { 
						$path .= $decomp[$j].'/';
				}
				array_push($lst_paths, $path);
				
				//Récupération du nom du fichier	
				$result = array_reverse($decomp);
				array_push($lst_images, $result['0']);
			}
			$this->setLstPaths($lst_paths);
			$this->setLstImages($lst_images);
			return true;
		} else {
			return false;
		}
	}
	
	//Ajouter une référence à chaque image du contenu HTML
	private function addRefToImg() {
		$content = $this->getHtmlContent();
		foreach($this->getLstImages() as $k => $v) {
			$content = str_replace($v, 'cid:image'.$k, $content);
		}
		$this->setHtmlContent($content);
	}
}
?>





