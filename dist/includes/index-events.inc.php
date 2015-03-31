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
                <li class="tab-title active"><a href="#panel11">Event 1407 <span>27 mars 2015</span></a>
                </li>
                <li class="tab-title"><a href="#panel21">Event 1502 <span>27 juillet 2015</span></a>
                </li>
            </ul>
        </div>
        <div class="small-12 medium-8 columns">
            <div class="tabs-content">

                <div class="row content active" id="panel11">
                   
                    <div class="row data-event-1407">
                        <div class="small-12 columns event-details">
                            <div class="small-12 columns">
                                <h4>Event 1407</h4>
                                <span class="date">27 mars 2015</span>
                            </div>
                            <div class="small-12 columns">
                                <p>Thèmes abordés :</p>
                                <ul>
                                    <li>
                                        Google map dans is-academia
                                    </li>
                                    <li>
                                        Gestion des news
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="small-12 columns action-inscription">
                            <a class="inscription-event" event-code="1407"><?php getTexte('home-events', 'inscr-btn'); ?><span class="icon icon-shape-fleche-droite"></span></a>
                        </div>
                    </div>
                    
                    <div class="row inscription-event-1407" style="display: none;">
                        <div class="small-12 columns event-details">
                           <h4>Inscription à l'event 1407</h4>
                            <form class="inscription-form">
                              <div class="row">
                                  <div class="small-12 medium-6 columns">
                                      <div class="group">
                                          <input type="text" name="nom" form-code="event-1407"/>
                                          <label><?php getTexte('home-events', 'label-name'); ?></label>
                                      </div>
                                  </div>                           
                                  <div class="small-12  medium-6 columns">
                                      <div class="group">
                                          <input type="email" name="email" form-code="event-1407"/>
                                          <label><?php getTexte('home-events', 'label-email'); ?></label>
                                      </div>
                                  </div>
                              </div>
                              <div class="row hidden">
                                  <input type="hidden" name="eventName" value="EVENT 1407" form-code="event-1407"/>
                                  <input type="hidden" name="eventDate" value="le 27 mars 2014 à 9h" form-code="event-1407"/>
                                  <input type="hidden" name="eventPlace" value="Parc scientifique de l'EPFL" form-code="event-1407"/>
                              </div>
                               <div class="row">
                                   <div class="small-12 medium-6 columns text-center">
                                       <input type="button" value="<?php getTexte('home-events', 'form-btn-send'); ?>" class="button send-form" form-code="event-1407"/>
                                       <span class="send-spinner" style="display:none;">
                                           <div class="bounce1"></div>
                                           <div class="bounce2"></div>
                                           <div class="bounce3"></div> 
                                       </span>
                                   </div>
                                   <div class="small-12 medium-6 columns text-center"> 
                                       <input type="button" value="<?php getTexte('home-events', 'form-btn-cancel'); ?>" class="button inscr-form-cancel"/>
                                   </div>
                                </div>            
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row content" id="panel21">
                    <div class="row data-event-1502">
                        <div class="small-12 columns event-details">
                            <div class="small-12 columns">
                                <h4>Event 1502</h4>
                                <span class="date">27 mars 2015</span>
                            </div>
                            <div class="small-12 columns">
                                <p>Thèmes abordés :</p>
                                <ul>
                                    <li>
                                        Google map dans is-academia
                                    </li>
                                    <li>
                                        Gestion des news
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="small-12 columns action-inscription">
                            <a class="inscription-event" event-code="1502">Inscription<span class="icon icon-shape-fleche-droite"></span></a>
                        </div>
                    </div>
                    <div class="row inscription-event-1502" style="display:none;">
                        <div class="small-12 columns event-details">
                            <h4>Inscription à l'event 1502</h4>
                            <form class="inscription-form">
                                <div class="row">
                                    <div class="small-12 medium-6 columns">
                                        <div class="group">
                                            <input type="text" name="nom" form-code="event-1502"/>
                                            <label><?php getTexte('home-events', 'label-name'); ?></label>
                                        </div>
                                    </div>                           
                                    <div class="small-12  medium-6 columns">
                                        <div class="group">
                                            <input type="email" name="email" form-code="event-1502"/>
                                            <label><?php getTexte('home-events', 'label-email'); ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row hidden">
                                    <input type="hidden" name="eventName" value="EVENT 1502" form-code="event-1502"/>
                                    <input type="hidden" name="eventDate" value="le 21 02 2015 à 9h" form-code="event-1502"/>
                                    <input type="hidden" name="eventPlace" value="Parc Scientifique de l'EPFL" form-code="event-1502"/>
                                </div>
                                <div class="row">
                                    <div class="small-12 medium-6 columns text-center"> 
                                        <input type="button" value="<?php getTexte('home-events', 'form-btn-cancel'); ?>" class="button inscr-form-cancel"/>
                                    </div>
                                    <div class="small-12 medium-6 columns text-center">
                                        <input type="button" value="<?php getTexte('home-events', 'form-btn-send'); ?>" class="button send-form" form-code="event-1502"/>
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