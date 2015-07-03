<section class="row" id="index-events">
    <div class="small-12 columns hide-for-small-only">
        <h3><?php getTexte('home-events', 'title'); ?></h3>
    </div>
    <div class="small-12 columns show-for-small-only">
        <h3><?php getTexte('home-events', 'title'); ?></h3>
    </div>
    <div class="row events-tab">

        <div class="medium-4 columns hide-for-small-only">
            <ul class="tabs vertical" data-tab>
                <!--
                <li class="tab-title active"><a href="#panel11" title="panel"><?php getTexte('home-events', 'sem1-title'); ?><span><?php getTexte('home-events', 'sem1-date'); ?></span></a>
                </li>
                -->
                <li class="tab-title active"><a href="#panel21" title="panel"><?php getTexte('home-events', 'sem2-title'); ?><span><?php getTexte('home-events', 'sem2-date'); ?></span></a>
                </li>
            </ul>
        </div>

        <div class="small-12 medium-8 columns">
            <div class="tabs-content">

                <div class="row content active" id="panel11">
                   
                    <div class="row data-event-<?php getTexte('home-events', 'sem1-code'); ?>">
                        <div class="small-12 columns event-details">
                            <div class="small-12 columns">
                                <h4><?php getTexte('home-events', 'sem1-title'); ?></h4>
                                <span class="date"><?php getTexte('home-events', 'sem1-date'); ?></span>
                            </div>
                            <div class="small-12 columns">
                                <?php getMultiLineTexte('home-events', 'sem1-txt', 'text-left'); ?>
                            </div>
                        </div>

                        <div class="small-12 columns action-inscription">
                            <?php if(getIniValue('home-events', 'sem1-inscr') === '1') { ?>
                                <a class="inscription-event" event-code="<?php getTexte('home-events', 'sem1-code'); ?>" title="inscription event"><?php getTexte('home-events', 'inscr-btn'); ?><span class="icon icon-shape-fleche-droite"></span></a>
                            <?php } ?>
                        </div>
                    </div>
                    
                    <div class="row inscription-event-<?php getTexte('home-events', 'sem1-code'); ?>" style="display: none;">
                        <div class="small-12 columns event-details">
                           <h4><?php getTexte('home-events', 'form-title'); ?></h4>
                            <form class="inscription-form">
                              <div class="row">
                                  <div class="small-12 medium-6 columns">
                                      <div class="group">
                                          <input type="text" name="nom" form-code="event-<?php getTexte('home-events', 'sem1-code'); ?>"/>
                                          <label><?php getTexte('home-events', 'label-name'); ?></label>
                                      </div>
                                  </div>                           
                                  <div class="small-12  medium-6 columns">
                                      <div class="group">
                                          <input type="email" name="email" form-code="event-<?php getTexte('home-events', 'sem1-code'); ?>"/>
                                          <label><?php getTexte('home-events', 'label-email'); ?></label>
                                      </div>
                                  </div>
                                  <div class="small-12 columns">
                                      <textarea name="message" rows="5" placeholder="<?php getTexte('home-events', 'label-message'); ?>" form-code="event-<?php getTexte('home-events', 'sem1-code'); ?>"></textarea>
                                  </div>
                              </div>
                              <div class="row hidden">
                                  <input type="hidden" name="eventName" value="<?php getTexte('home-events', 'sem1-title'); ?>" form-code="event-<?php getTexte('home-events', 'sem1-code'); ?>"/>
                                  <input type="hidden" name="eventDate" value="le <?php getTexte('home-events', 'sem1-date'); ?> à <?php getTexte('home-events', 'sem1-heure'); ?>" form-code="event-<?php getTexte('home-events', 'sem1-code'); ?>"/>
                                  <input type="hidden" name="eventPlace" value="<?php getTexte('home-events', 'sem-lieu'); ?>" form-code="event-<?php getTexte('home-events', 'sem1-code'); ?>"/>
                              </div>
                               <div class="row">
                                   <div class="small-12 medium-6 columns text-center">
                                       <input type="button" value="<?php getTexte('home-events', 'form-btn-cancel'); ?>" class="button inscr-form-cancel"/>
                                   </div>
                                   <div class="small-12 medium-6 columns text-center"> 
                                       <input type="button" value="<?php getTexte('home-events', 'form-btn-send'); ?>" class="button send-form" form-code="event-<?php getTexte('home-events', 'sem1-code'); ?>"/>
                                       <span class="send-spinner" style="display:none;">
                                           <div class="bounce1"></div>
                                           <div class="bounce2"></div>
                                           <div class="bounce3"></div>
                                       </span>
                                   </div>
                                </div>            
                            </form>
                        </div>
                    </div>

                </div>

                <div class="row content active" id="panel21">

                    <div class="row data-event-<?php getTexte('home-events', 'sem2-code'); ?>">
                        <div class="small-12 columns event-details">
                            <div class="small-12 columns">
                                <h4><?php getTexte('home-events', 'sem2-title'); ?></h4>
                                <span class="date"><?php getTexte('home-events', 'sem2-date'); ?></span>
                            </div>
                            <div class="small-12 columns">
                                <?php getMultiLineTexte('home-events', 'sem2-txt', 'text-left'); ?>
                            </div>
                        </div>

                        <div class="small-12 columns action-inscription">
                            <?php if(getIniValue('home-events', 'sem2-inscr') === '1') { ?>
                                <a class="inscription-event" event-code="<?php getTexte('home-events', 'sem2-code'); ?>" title="inscription event"><?php getTexte('home-events', 'inscr-btn'); ?><span class="icon icon-shape-fleche-droite"></span></a>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="row inscription-event-<?php getTexte('home-events', 'sem2-code'); ?>" style="display:none;">
                        <div class="small-12 columns event-details">
                            <h4>Inscription à l'event <?php getTexte('home-events', 'sem2-code'); ?></h4>
                            <form class="inscription-form">
                                <div class="row">
                                    <div class="small-12 medium-6 columns">
                                        <div class="group">
                                            <input type="text" name="nom" form-code="event-<?php getTexte('home-events', 'sem2-code'); ?>"/>
                                            <label><?php getTexte('home-events', 'label-name'); ?></label>
                                        </div>
                                    </div>                           
                                    <div class="small-12  medium-6 columns">
                                        <div class="group">
                                            <input type="email" name="email" form-code="event-<?php getTexte('home-events', 'sem2-code'); ?>"/>
                                            <label><?php getTexte('home-events', 'label-email'); ?></label>
                                        </div>
                                    </div>
                                    <div class="small-12 columns">
                                        <textarea name="message" rows="5" placeholder="<?php getTexte('home-events', 'label-message'); ?>" form-code="event-<?php getTexte('home-events', 'sem2-code'); ?>"></textarea>
                                    </div>
                                </div>
                                <div class="row hidden">
                                    <input type="hidden" name="eventName" value="<?php getTexte('home-events', 'sem2-title'); ?>" form-code="event-<?php getTexte('home-events', 'sem2-code'); ?>"/>
                                    <input type="hidden" name="eventDate" value="le <?php getTexte('home-events', 'sem2-date'); ?> à <?php getTexte('home-events', 'sem2-heure'); ?>" form-code="event-<?php getTexte('home-events', 'sem2-code'); ?>"/>
                                    <input type="hidden" name="eventPlace" value="<?php getTexte('home-events', 'sem-lieu'); ?>" form-code="event-<?php getTexte('home-events', 'sem2-code'); ?>"/>
                                </div>
                                <div class="row">
                                    <div class="small-12 medium-6 columns text-center"> 
                                        <input type="button" value="<?php getTexte('home-events', 'form-btn-cancel'); ?>" class="button inscr-form-cancel"/>
                                    </div>
                                    <div class="small-12 medium-6 columns text-center">
                                        <input type="button" value="<?php getTexte('home-events', 'form-btn-send'); ?>" class="button send-form" form-code="event-<?php getTexte('home-events', 'sem2-code'); ?>"/>
                                        <span class="send-spinner" style="display:none;">
                                            <div class="bounce1"></div>
                                            <div class="bounce2"></div>
                                            <div class="bounce3"></div> 
                                        </span>
                                    </div>
                                </div>            
                            </form>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>
    <hr/>
</section>