<div id="wrapper">
    <div class="container">
        <div class="col s12 m12 l8">
            <span id="dummy" style="display: hidden;"></span>
            <div class="row">
                <div class="col s12 m12 l12">
                    <div class="row section favo-list-section">
                        <div class="accent-2 card-panel col s12 center-align">
                            <p class="event-label section-label"><span> お気に入り一覧 </span></p>
                        </div>
                        <div class="col s12 m12 l12">
                            <ul class="collection favo-list-section__ul">
                                <?=$this->element('favo-list')?>
                            </ul>
                            <div class="favo-more-btn-section center-align">
                                <a class="yellow darken-4 waves-effect waves-green btn see_more_favos"
                                     data-type='see_more_favos' data-action=<?=DS.$this->request->url?>><?=_("もっと見る")?>
                                </a>
                            </div>
                            <span class="paging" style="float:right"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
