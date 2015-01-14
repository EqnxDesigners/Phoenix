	<!-- AJOUTER UNE NEWS -->
	<!--
	<div class="add_box" id="add_news">
		<div class="form_label">*&nbsp;=&nbsp;champs obligatoires</div>
		<table>
			<tr>
				<td>Catégorie</td>
                <td align="left" valign="top">Informations</td>
                <td align="left" valign="top">Visible</td>
                <td align="left" valign="top">Documents</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
			</tr>
			<tr>
				<form name="add_element" action="<?php echo $_SERVER['PHP_SELF'].'?module='.$_SESSION['module']; ?>" method="post" enctype="multipart/form-data">
					<td align="left" valign="top">
						<?php $mod_class->getSelectorWithCurrent('new_categorie', 'news_categories', 'categorie', 'id', 'news_categories', 'categorie', $lst_news[$i]['categorie'], 'id'); ?>
					</td>
                    <td align="left" valign="top">
						<?php $mod_class->getAllInput("langue", "IDLangue");?>
                    </td>
                    <td align="left" valign="top">
						<div class="form_label">Actif</div>
						<div class="form_label"><input name="actif" type="radio" id="actif" value="1" checked="CHECKED">&nbsp;activé</div>
						<div class="form_label"><input name="actif" type="radio" id="actif" value="0">&nbsp;désactivé</div>
					</td>
                    <td align="left" valign="top">
						<div class="form_label">Illustration de la news</div>
						<input name="img1" type="file">
						<div class="form_label">Illustration de la news</div>
						<input name="img2" type="file">
						<div class="form_label">Illustration de la news</div>
						<input name="img3" type="file">
                        <div class="form_label">Illustration de la news</div>
						<input name="img4" type="file">
                        <div class="form_label">Illustration de la news</div>
						<input name="img5" type="file">
                        <div class="form_label">Illustration de la news</div>
						<input name="img6" type="file">
					</td>
					<td align="center" valign="top"><button type="submit" name="add_news" id="add_news" value="Ajouter"><img src="imgs/bton_valid.png" /></button></td>
					<td align="center" valign="top"><button type="submit" name="close_add_box" id="close_add_box" value=""><img src="imgs/bton_close.png" /></button></td>
				</form>
			</tr>
		</table>
	</div>
	-->










				<!-- EDIT BOX -->
				<!--
				<tr class="edit_box" id="edit_<?php echo $lst_news[$i]['id']; ?>">
					<td colspan="12">
						<table>
							<tr>
								<td>Catégorie</td>
                                <td align="left" valign="top">Informations</td>
                                <td align="left" valign="top">Visible</td>
                                <td align="left" valign="top">Documents</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
							</tr>
							<tr>
								<form name="edit_news" action="<?php echo $_SERVER['PHP_SELF'].'?module='.$_SESSION['module']; ?>" method="post" enctype="multipart/form-data">
									<td align="left" valign="top">
										<?php $mod_class->getSelectorWithCurrent('edit_categorie', 'news_categories', 'categorie', 'id', 'news_categories', 'categorie', $lst_news[$i]['categorie'], 'id'); ?>

                                    </td>
                                    <td align="left" valign="top">
										<?php $mod_class->getAllInput("langue", "IDLangue", $lst_news[$i]["id"]);?>
									</td>
									<td align="left" valign="top">
										<div class="form_label">Actif</div>
										<div class="form_label"><input <?php if (!(strcmp($lst_news[$i]['visible'],"1"))) {echo "checked=\"checked\"";} ?> name="actif" type="radio" id="actif" value="1">&nbsp;activé</div>
										<div class="form_label"><input <?php if (!(strcmp($lst_news[$i]['visible'],"0"))) {echo "checked=\"checked\"";} ?> name="actif" type="radio" id="actif" value="0">&nbsp;désactivé</div>
                                    </td>
									<td align="left" valign="top">
										<div class="form_label">Ajouter une illustration</div>
										<input name="img" type="file">
										<br>
										<?php
											if($mod_class->checkImage($lst_news[$i]['id']) == true) {
												$img = $mod_class->getWhereEqual('news_img', 'id_news', $lst_news[$i]['id'], 'news_img.id');
										 ?>
											<img src="../images/news/<?php echo $img['0']['img']; ?>" width="100" height="100">
										<?php } else { ?>
											<img src="imgs/nopic.png" width="50" height="50">
										<?php } ?>
									</td>
									<td align="center" valign="top">
										<input type="hidden" name="id_news" id="id_news" value="<?php echo $lst_news[$i]['id']; ?>">
										<button type="submit" name="edit_news" id="edit_news" value="Editer">
											<img src="imgs/bton_valid.png" />
										</button>
									</td>
									<td align="center" valign="top">
										<button type="submit" name="close_edit_box" id="close_edit_box" value="<?php echo $lst_news[$i]['id']; ?>">
											<img src="imgs/bton_close.png" />
										</button>
									</td>
								</form>
							</tr>
						</table>
					</td>
				</tr>
				-->
				
				<!-- DEL BOX -->
				<!--
				<tr class="del_box" id="del_<?php echo $lst_news[$i]['id']; ?>">
					<td colspan="12">
						Etes-vous s&ucirc;re de vouloir supprimer cet &eacute;l&eacute;ments ?&nbsp;
						<a href="?module=<?php echo $_SESSION['module']; ?>&action=del_prod&table=news&id=<?php echo $lst_news[$i]['id']; ?>" target="_self">
							<img src="imgs/bton_valid.png">
						</a>
						&nbsp;|&nbsp;
						<img src="imgs/bton_del.png" class="close_del_box" title="<?php echo $lst_news[$i]['id']; ?>">
					</td>
				</tr>
				-->
